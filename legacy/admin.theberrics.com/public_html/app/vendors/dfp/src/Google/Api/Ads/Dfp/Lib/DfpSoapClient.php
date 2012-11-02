<?php
/**
 * An extension of the {@link AdsSoapClient} for Google's DoubleClick for
 * Publishers API.
 *
 * PHP version 5
 *
 * Copyright 2011, Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @package    GoogleApiAdsDfp
 * @subpackage Lib
 * @category   WebServices
 * @copyright  2011, Google Inc. All Rights Reserved.
 * @license    http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @author     Adam Rogal <api.arogal@gmail.com>
 * @author     Eric Koleda <api.ekoleda@gmail.com>
 * @see        AdsSoapClient
 */

require_once dirname(__FILE__) . '/../../Common/Lib/AdsSoapClient.php';
require_once dirname(__FILE__) . '/../../Common/Util/OAuthUtils.php';

/**
 * An extension of the {@link AdsSoapClient} for Google's DoubleClick for
 * Publishers API.
 */
class DfpSoapClient extends AdsSoapClient {
  /**
   * Constructor for Google's DoubleClick for Publishers API SOAP client.
   * @param string $wsdl URI of the WSDL file or <var>NULL</var> if working in
   *     non-WSDL mode
   * @param array $options the SOAP client options
   * @param AdsUser $user the user which is responsible for this client
   * @param string $serviceName the name of the service which is making this
   *     call
   * @param string $serviceNamespace the namespace of the service
   */
  public function __construct($wsdl, array $options, AdsUser $user,
      $serviceName, $serviceNamespace) {
    parent::__construct($wsdl, $options, $user, $serviceName,
        $serviceNamespace);
  }

  /**
   * Generates the SOAP header for the client.
   * @return SoapHeader the instantiated SoapHeader ready to set
   * @access protected
   */
  protected function GenerateSoapHeader() {
    $headersOverrides = array();
    if ($this->user->GetOAuthInfo() != NULL) {
      $oauthParameters =
          OAuthUtils::GetSignedRequestParameters($this->user->GetOAuthInfo(),
              $this->location);
      $headersOverrides['oAuthToken'] = 'OAuth '
          . OAuthUtils::FormatParametersForHeader($oauthParameters);
    }
    if (array_key_exists('authentication',
        get_class_vars('SoapRequestHeader'))) {
      // v201103 and later uses the 'authentication' header to hold both
      // ClientLogin and OAuth information.
      if (isset($headersOverrides['oAuthToken'])) {
        $authentication = new DfpOAuth();
        $authentication->parameters = $headersOverrides['oAuthToken'];
      } else {
        $authentication = new ClientLogin();
        $authentication->token = $this->GetHeaderValue('authToken');
      }
      $headersOverrides['authentication'] = $authentication;
    }
    return parent::CreateSoapHeader('SoapRequestHeader', 'RequestHeader',
        $headersOverrides);
  }

  /**
   * Removes the authentication information from the request before being
   * logged.
   * @param string $request the request with sensitive data to remove
   * @return string the request with the authentication token removed
   * @access protected
   */
  protected function RemoveSensitiveInfo($request) {
    $tags = array('authToken', 'authentication');
    $regexFormat = '/(<(?:[^:]+:)?%s(?:\s[^>]*)?>).*(<\/(?:[^:]+:)?%s\s*>)/sU';
    $result = $request;
    foreach ($tags as $tag) {
      $regex = sprintf($regexFormat, $tag, $tag);
      $result = preg_replace($regex, '\1*****\2', $result);
    }
    return isset($result) ? $result : $request;
  }

  /**
   * Generates the request info message containing:
   * <ul>
   * <li>email</li>
   * <li>service</li>
   * <li>method</li>
   * <li>responseTime</li>
   * <li>requestId</li>
   * <li>server</li>
   * <li>isFault</li>
   * <li>faultMessage</li>
   * </ul>
   * @return string the request info message to log
   * @access protected
   */
  protected function GenerateRequestInfoMessage() {
    return 'email=' . $this->GetEmail() . ' service=' . $this->GetServiceName()
        . ' method=' . $this->GetLastMethodName() . ' responseTime='
        . $this->GetLastResponseTime() . ' requestId='
        . $this->GetLastRequestId() . ' server=' . $this->GetServer()
        . ' isFault=' . $this->IsFault() . ' faultMessage='
        . $this->GetLastFaultMessage();
  }
}