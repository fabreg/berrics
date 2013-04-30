<?php

class UspsApi {
	
	private $login = array(
		"username"=>"655THEBE6004",
		"password"=>"106LM93HO712"
	);
	
	private $from_address = array(
		"firm"=>"",
		"name"=>"The Berrics Canteen",
		"address1"=>"#115",
		"address2"=>"2121 E. 7TH St",
		"city"=>"Los Angeles",
		"zip"=>"90031",
		"state"=>"CA" 
	);
	
	public function __construct($login = false, $from_address = false) {
		
		if($login) $this->setLogin($login);

		if($from_address) $this->setFromAddress($from_address);

	}	
	
	public function setLogin() {
		
		
	}
	
	public function setFromAddress($from_address) {
		
		$from = array_merge($this->from_address,$from_address);

		$this->from_address = $from;
		
	}
	
	private function from_element() {
		
		$a = "<FromName>{$this->from_address['name']}</FromName>
			<FromFirm>{$this->from_address['firm']}</FromFirm>
			<FromAddress1>{$this->from_address['address1']}</FromAddress1>
			<FromAddress2>{$this->from_address['address2']}</FromAddress2>
			<FromCity>{$this->from_address['city']}</FromCity>
			<FromState>{$this->from_address['state']}</FromState>
			<FromZip5>{$this->from_address['zip']}</FromZip5>
			<FromZip4></FromZip4>";
		
		return $a;
		
	}
	
	private function from_element_int() {
		
		$a = "<FromFirstName>The Berrics</FromFirstName>
			<FromLastName>Canteen</FromLastName>
			<FromFirm>{$this->from_address['name']}</FromFirm>
			<FromAddress1>{$this->from_address['address1']}</FromAddress1>
			<FromAddress2>{$this->from_address['address2']}</FromAddress2>
			<FromCity>{$this->from_address['city']}</FromCity>
			<FromState>{$this->from_address['state']}</FromState>
			<FromZip5>{$this->from_address['zip']}</FromZip5>
			<FromZip4></FromZip4>
			<FromPhone>0000000000</FromPhone>
			";
		
		return $a;
		
	}
	
	public function ship_delcon($a) {
		
		//do some data scrubbing
		
		if(!isset($a['ref_number'])) $a['ref_number'] = '';

		$s = "<DeliveryConfirmationV3.0Request USERID='{$this->login['username']}' PASSWORD='{$this->login['password']}'>
				<Option>1</Option>
				<ImageParameters></ImageParameters>";
		
		$s .= $this->from_element();
		
		$s .= "<ToName>{$a['first_name']} {$a['last_name']}</ToName>
				<ToFirm></ToFirm>
				<ToAddress1>{$a['apt']}</ToAddress1>
				<ToAddress2>{$a['street']}</ToAddress2>
				<ToCity>{$a['city']}</ToCity>
				<ToState>{$a['province']}</ToState>
				<ToZip5>{$a['postal_code']}</ToZip5>
				<ToZip4></ToZip4>
				<WeightInOunces>{$a['weight']}</WeightInOunces>
				<ServiceType>{$a['shipping_method']}</ServiceType>
				<SeparateReceiptPage></SeparateReceiptPage>
				<POZipCode></POZipCode>
				<ImageType>TIF</ImageType>
				<LabelDate></LabelDate>
				<CustomerRefNo>{$a['ref_number']}</CustomerRefNo>
				<AddressServiceRequested></AddressServiceRequested>
				<SenderName></SenderName>
				<SenderEMail></SenderEMail>
				<RecipientName></RecipientName>
				<RecipientEMail></RecipientEMail>
				</DeliveryConfirmationV3.0Request>";
		
		$url = "https://secure.shippingapis.com/ShippingAPI.dll";
		
		$d = array(
			"API"=>"DeliveryConfirmationV3",
			"XML"=>$s
		);		
		
		$ret = $this->curlGet($url,$d);
		
		return $ret;
		
	}
	
	public function ship_int($a,$items) {
		

		$oz = $a['weight'] * 16;
		
		$lbs = floor($oz/16);
			
		$oz = floor($oz - ($lbs*16));
		
		$countries = $this->countries();
				
		
		$_s = "<FirstClassMailIntlRequest USERID='{$this->login['username']}' PASSWORD='{$this->login['password']}'>
			
			    <Option/>
			
			    <Revision>2</Revision>
			
			    <ImageParameters/>
			
			   ";
		$_s.= $this->from_element_int();
			
		$_s .= "<ToName>{$a['first_name']} {$a['last_name']}</ToName>
			
			    <ToFirm></ToFirm>
			
			    <ToAddress1>{$a['street']}</ToAddress1>
			
			    <ToAddress2>{$a['apt']}</ToAddress2>
			
			    <ToCity>{$a['city']}</ToCity>
			
			    <ToCountry>{$countries[$a['country_code']]}</ToCountry>
			
			    <ToPostalCode>{$a['postal_code']}</ToPostalCode>
			
			    <ToPOBoxFlag>N</ToPOBoxFlag>
			    <ToPhone />
			    <ToFax />
			    <ToEmail />
			    <FirstClassMailType>PARCEL</FirstClassMailType>
			    <ShippingContents>
					{$items}
			    </ShippingContents>
			    <GrossPounds>{$lbs}</GrossPounds>
			    <GrossOunces>{$oz}</GrossOunces>
			    <Machinable>false</Machinable>
			    <ContentType>MERCHANDISE</ContentType>
			    <Agreement>Y</Agreement>
			    <Comments />
			    <ImageType>TIF</ImageType>
			    <ImageLayout>ONEPERFILE</ImageLayout>
			    <HoldForManifest>N</HoldForManifest>
			    <Size>REGULAR</Size>
			</FirstClassMailIntlRequest>";

					
		$url = "https://secure.shippingapis.com/ShippingAPI.dll";
					
		$res = $this->curlGet($url,array("API"=>"FirstClassMailIntl","XML"=>$_s));
		
		return $res;	
	
	}

	public function validate_address($UserAddress = false) {
		
		$s = "<AddressValidateRequest%20USERID='{$this->login['username']}' PASSWORD='{$this->login['password']}' >
					<Address ID='1'>
						<Address1></Address1>
						<Address2>8 Wildwood Drive</Address2>
						<City>Old Lyme</City>
						<State>CT</State>
						<Zip5>06371</Zip5>
						<Zip4></Zip4>
					</Address>
			</AddressValidateRequest>";

		$url = "https://secure.shippingapis.com/ShippingAPI.dll";

		$data = array(
			"API"=>"Verify",
			"XML"=>$s,
		);

		$res = $this->curlGet($url,$data);

		die(print_r($res));

	}


	private function curlGet($url,$data) {
			
			$curl = curl_init();
			curl_setopt($curl,CURLOPT_URL,$url."?".http_build_query($data));
			curl_setopt($curl,CURLOPT_POST,0);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			$ret = curl_exec($curl);
			curl_close($curl);
			return $ret;
			
	}
	
	public function processCanteenItems($data) {
		
		
		
		$items = '';
		
		foreach($data as $v) {
			
			$oz = $v['weight'] * 16;

			$lbs = floor($oz/16);
			
			$oz = floor($oz - ($lbs*16));
			
			$s = "<ItemDetail>
			
			            <Description>{$v['title']} {$v['sub_title']}</Description>
			
			            <Quantity>{$v['quantity']}</Quantity>
			
			            <Value>{$v['sub_total']}</Value>
			
			            <NetPounds>{$lbs}</NetPounds>
			
			            <NetOunces>{$oz}</NetOunces>
			
			            <HSTariffNumber></HSTariffNumber>
			
			            <CountryOfOrigin>United States</CountryOfOrigin>
			
			        </ItemDetail>";
			$items .= $s;
			
		}
		
		return $items;
	}
	
	
	public function calc_dom_rate($data) {
		
		$method = "FIRST CLASS";
		
		$oz = $data['weight'] * 16;

		if($oz>=13) $method = "Parcel Post";
		
		
		$lbs = floor($oz/16);
		
		$oz = floor($oz - ($lbs*16));
		
		$s = "<RateV4Request USERID='{$this->login['username']}'>
			    <Revision>2</Revision>
			    <Package ID='1ST'>
			        <Service>{$method}</Service>
			        <FirstClassMailType>PARCEL</FirstClassMailType>
			        <ZipOrigination>{$data['origin_zip']}</ZipOrigination>
			        <ZipDestination>{$data['dest_zip']}</ZipDestination>
			        <Pounds>{$lbs}</Pounds>			
			        <Ounces>{$oz}</Ounces>			
			        <Container/>			
			        <Size>REGULAR</Size>			
			        <Machinable>false</Machinable>		
			    </Package>			
			</RateV4Request>";
		
		$url = "http://production.shippingapis.com/ShippingAPI.dll";
		$d = array(
			"API"=>"RateV4",
			"XML"=>$s
		);
		
		$res = $this->curlGet($url,$d);
		
		return $res;
		
	}
	
	public function calc_int_rate($data) {
		
		$oz = $data['weight'] * 16;

		$lbs = floor($oz/16);
		
		$oz = floor($oz - ($lbs*16));
		
		$s = "<IntlRateV2Request USERID='{$this->login['username']}'>

			  <Revision>2</Revision>
			
			  <Package ID='1ST'>
			
			    <Pounds>{$lbs}</Pounds>
			
			    <Ounces>{$oz}</Ounces>
			
			    <Machinable>False</Machinable>
			
			    <MailType>Package</MailType>
			
			    <ValueOfContents></ValueOfContents>
			
			    <Country>{$data['country']}</Country>
			
			    <Container>RECTANGULAR</Container>
			
			    <Size>REGULAR</Size>
			
			    <Width>0</Width>
			
			    <Length>0</Length>
			
			    <Height>0</Height>
			
			    <Girth>0</Girth>
			
			    <OriginZip>{$data['origin_zip']}</OriginZip>
			
			    <CommercialFlag>N</CommercialFlag>
			
			  </Package>
			
			</IntlRateV2Request>";
		
		$url = "http://production.shippingapis.com/ShippingAPI.dll";
		$d = array(
			"API"=>"IntlRateV2",
			"XML"=>$s
		);
		
		$res = $this->curlGet($url,$d);
		
		return $res;
	}
	
	
	public function countries() {
		
		$a = array(
				"AF"=>"Afghanistan",
				"AX"=>"Aland Islands",
				"AL"=>"Albania",
				"DZ"=>"Algeria",
				"AS"=>"American Samoa",
				"AD"=>"Andorra",
				"AO"=>"Angola",
				"AI"=>"Anguilla",
				"AQ"=>"Antarctica",
				"AG"=>"Antigua and Barbuda",
				"AR"=>"Argentina",
				"AM"=>"Armenia",
				"AW"=>"Aruba",
				"AP"=>"Asia/Pacific Region",
				"AU"=>"Australia",
				"AT"=>"Austria",
				"AZ"=>"Azerbaijan",
				"BS"=>"Bahamas",
				"BH"=>"Bahrain",
				"BD"=>"Bangladesh",
				"BB"=>"Barbados",
				"BY"=>"Belarus",
				"BE"=>"Belgium",
				"BZ"=>"Belize",
				"BJ"=>"Benin",
				"BM"=>"Bermuda",
				"BT"=>"Bhutan",
				"BO"=>"Bolivia",
				"BA"=>"Bosnia and Herzegovina",
				"BW"=>"Botswana",
				"BV"=>"Bouvet Island",
				"BR"=>"Brazil",
				"IO"=>"British Indian Ocean Territory",
				"BN"=>"Brunei Darussalam",
				"BG"=>"Bulgaria",
				"BF"=>"Burkina Faso",
				"BI"=>"Burundi",
				"KH"=>"Cambodia",
				"CM"=>"Cameroon",
				"CA"=>"Canada",
				"CV"=>"Cape Verde",
				"KY"=>"Cayman Islands",
				"CF"=>"Central African Republic",
				"TD"=>"Chad",
				"CL"=>"Chile",
				"CN"=>"China",
				"CX"=>"Christmas Island",
				"CC"=>"Cocos (Keeling) Islands",
				"CO"=>"Colombia",
				"KM"=>"Comoros",
				"CG"=>"Congo",
				"CD"=>"Congo",
				"CK"=>"Cook Islands",
				"CR"=>"Costa Rica",
				"CI"=>"Cote d'Ivoire",
				"HR"=>"Croatia",
				"CU"=>"Cuba",
				"CY"=>"Cyprus",
				"CZ"=>"Czech Republic",
				"DK"=>"Denmark",
				"DJ"=>"Djibouti",
				"DM"=>"Dominica",
				"DO"=>"Dominican Republic",
				"EC"=>"Ecuador",
				"EG"=>"Egypt",
				"SV"=>"El Salvador",
				"GQ"=>"Equatorial Guinea",
				"ER"=>"Eritrea",
				"EE"=>"Estonia",
				"ET"=>"Ethiopia",
				"EU"=>"Europe",
				"FK"=>"Falkland Islands (Malvinas)",
				"FO"=>"Faroe Islands",
				"FJ"=>"Fiji",
				"FI"=>"Finland",
				"FR"=>"France",
				"GF"=>"French Guiana",
				"PF"=>"French Polynesia",
				"TF"=>"French Southern Territories",
				"GA"=>"Gabon",
				"GM"=>"Gambia",
				"GE"=>"Georgia",
				"DE"=>"Germany",
				"GH"=>"Ghana",
				"GI"=>"Gibraltar",
				"GR"=>"Greece",
				"GL"=>"Greenland",
				"GD"=>"Grenada",
				"GP"=>"Guadeloupe",
				"GU"=>"Guam",
				"GT"=>"Guatemala",
				"GG"=>"Guernsey",
				"GN"=>"Guinea",
				"GW"=>"Guinea-Bissau",
				"GY"=>"Guyana",
				"HT"=>"Haiti",
				"HM"=>"Heard Island and McDonald Islands",
				"VA"=>"Holy See (Vatican City State)",
				"HN"=>"Honduras",
				"HK"=>"Hong Kong",
				"HU"=>"Hungary",
				"IS"=>"Iceland",
				"IN"=>"India",
				"ID"=>"Indonesia",
				"IR"=>"Iran",
				"IQ"=>"Iraq",
				"IE"=>"Ireland",
				"IM"=>"Isle of Man",
				"IL"=>"Israel",
				"IT"=>"Italy",
				"JM"=>"Jamaica",
				"JP"=>"Japan",
				"JE"=>"Jersey",
				"JO"=>"Jordan",
				"KZ"=>"Kazakhstan",
				"KE"=>"Kenya",
				"KI"=>"Kiribati",
				"KP"=>"Korea",
				"KR"=>"Korea",
				"KW"=>"Kuwait",
				"KG"=>"Kyrgyzstan",
				"LA"=>"Lao People's Democratic Republic",
				"LV"=>"Latvia",
				"LB"=>"Lebanon",
				"LS"=>"Lesotho",
				"LR"=>"Liberia",
				"LY"=>"Libyan Arab Jamahiriya",
				"LI"=>"Liechtenstein",
				"LT"=>"Lithuania",
				"LU"=>"Luxembourg",
				"MO"=>"Macao",
				"MK"=>"Macedonia",
				"MG"=>"Madagascar",
				"MW"=>"Malawi",
				"MY"=>"Malaysia",
				"MV"=>"Maldives",
				"ML"=>"Mali",
				"MT"=>"Malta",
				"MH"=>"Marshall Islands",
				"MQ"=>"Martinique",
				"MR"=>"Mauritania",
				"MU"=>"Mauritius",
				"YT"=>"Mayotte",
				"MX"=>"Mexico",
				"FM"=>"Micronesia",
				"MD"=>"Moldova",
				"MC"=>"Monaco",
				"MN"=>"Mongolia",
				"ME"=>"Montenegro",
				"MS"=>"Montserrat",
				"MA"=>"Morocco",
				"MZ"=>"Mozambique",
				"MM"=>"Myanmar",
				"NA"=>"Namibia",
				"NR"=>"Nauru",
				"NP"=>"Nepal",
				"NL"=>"Netherlands",
				"AN"=>"Netherlands Antilles",
				"NC"=>"New Caledonia",
				"NZ"=>"New Zealand",
				"NI"=>"Nicaragua",
				"NE"=>"Niger",
				"NG"=>"Nigeria",
				"NU"=>"Niue",
				"NF"=>"Norfolk Island",
				"MP"=>"Northern Mariana Islands",
				"NO"=>"Norway",
				"OM"=>"Oman",
				"PK"=>"Pakistan",
				"PW"=>"Palau",
				"PS"=>"Palestinian Territory",
				"PA"=>"Panama",
				"PG"=>"Papua New Guinea",
				"PY"=>"Paraguay",
				"PE"=>"Peru",
				"PH"=>"Philippines",
				"PN"=>"Pitcairn",
				"PL"=>"Poland",
				"PT"=>"Portugal",
				"PR"=>"Puerto Rico",
				"QA"=>"Qatar",
				"RE"=>"Reunion",
				"RO"=>"Romania",
				"RU"=>"Russian Federation",
				"RW"=>"Rwanda",
				"SH"=>"Saint Helena",
				"KN"=>"Saint Kitts and Nevis",
				"LC"=>"Saint Lucia",
				"PM"=>"Saint Pierre and Miquelon",
				"VC"=>"Saint Vincent and the Grenadines",
				"WS"=>"Samoa",
				"SM"=>"San Marino",
				"ST"=>"Sao Tome and Principe",
				"SA"=>"Saudi Arabia",
				"SN"=>"Senegal",
				"RS"=>"Serbia",
				"SC"=>"Seychelles",
				"SL"=>"Sierra Leone",
				"SG"=>"Singapore",
				"SK"=>"Slovakia",
				"SI"=>"Slovenia",
				"SB"=>"Solomon Islands",
				"SO"=>"Somalia",
				"ZA"=>"South Africa",
				"GS"=>"South Georgia and the South Sandwich Islands",
				"ES"=>"Spain",
				"LK"=>"Sri Lanka",
				"SD"=>"Sudan",
				"SR"=>"Suriname",
				"SJ"=>"Svalbard and Jan Mayen",
				"SZ"=>"Swaziland",
				"SE"=>"Sweden",
				"CH"=>"Switzerland",
				"SY"=>"Syrian Arab Republic",
				"TW"=>"Taiwan",
				"TJ"=>"Tajikistan",
				"TZ"=>"Tanzania",
				"TH"=>"Thailand",
				"TL"=>"Timor-Leste",
				"TG"=>"Togo",
				"TK"=>"Tokelau",
				"TO"=>"Tonga",
				"TT"=>"Trinidad and Tobago",
				"TN"=>"Tunisia",
				"TR"=>"Turkey",
				"TM"=>"Turkmenistan",
				"TC"=>"Turks and Caicos Islands",
				"TV"=>"Tuvalu",
				"UG"=>"Uganda",
				"UA"=>"Ukraine",
				"AE"=>"United Arab Emirates",
				"GB"=>"United Kingdom",
				"US"=>"United States",
				"UM"=>"United States Minor Outlying Islands",
				"UY"=>"Uruguay",
				"UZ"=>"Uzbekistan",
				"VU"=>"Vanuatu",
				"VE"=>"Venezuela",
				"VN"=>"Vietnam",
				"VG"=>"Virgin Islands",
				"VI"=>"Virgin Islands",
				"WF"=>"Wallis and Futuna",
				"EH"=>"Western Sahara",
				"YE"=>"Yemen",
				"ZM"=>"Zambia",
				"ZW"=>"Zimbabwe"
		);
		
		return $a;
		
	}
	
	
		public function run_tests() {
		
		//test #1
		$s = "<AddressValidateRequest USERID='{$this->login['username']}'><Address ID='0'><Address1></Address1>
			<Address2>6406 Ivy Lane</Address2><City>Greenbelt</City><State>MD</State>
			<Zip5></Zip5><Zip4></Zip4></Address></AddressValidateRequest>";
		echo $this->curlGet(
			"http://production.shippingapis.com/ShippingAPITest.dll",
			array(
				"API"=>"Verify",
				"XML"=>$s
			));
		
		//test #2
		$s = "<AddressValidateRequest USERID='{$this->login['username']}'><Address ID='1'><Address1>
				</Address1><Address2>8 Wildwood Drive</Address2><City>Old Lyme</City>
				<State>CT</State><Zip5>06371</Zip5><Zip4></Zip4></Address>
				</AddressValidateRequest>";
		echo $this->curlGet(
			"http://production.shippingapis.com/ShippingAPITest.dll",
			array(
				"API"=>"Verify",
				"XML"=>$s
			));
			
		//test #3
		$s = "<CityStateLookupRequest USERID='{$this->login['username']}'><ZipCode ID= '0'>
			<Zip5>90210</Zip5></ZipCode></CityStateLookupRequest>";
		echo $this->curlGet(
			"http://production.shippingapis.com/ShippingAPITest.dll",
			array(
				"API"=>"CityStateLookup",
				"XML"=>$s
			));
			
		//test #4
		$s = "<CityStateLookupRequest USERID='{$this->login['username']}'><ZipCode ID='5'>
		<Zip5>20770</Zip5></ZipCode></CityStateLookupRequest>";
		echo $this->curlGet(
			"http://production.shippingapis.com/ShippingAPITest.dll",
			array(
				"API"=>"CityStateLookup",
				"XML"=>$s
			));	
			
		//test #5
		$s = "<ZipCodeLookupRequest USERID='{$this->login['username']}'><Address ID='0'>
				<Address1></Address1><Address2>6406 Ivy Lane</Address2>
				<City>Greenbelt</City><State>MD</State></Address></ZipCodeLookupRequest>";
		echo $this->curlGet(
			"http://production.shippingapis.com/ShippingAPITest.dll",
			array(
				"API"=>"ZipCodeLookup",
				"XML"=>$s
			));	
		
		//test #6
		$s = "<ZipCodeLookupRequest USERID='{$this->login['username']}'>
				<Address ID='1'><Address1></Address1>
				<Address2>8 Wildwood Drive</Address2><City>Old Lyme</City><State>CT</State>
				</Address></ZipCodeLookupRequest>";
		echo $this->curlGet(
			"http://production.shippingapis.com/ShippingAPITest.dll",
			array(
				"API"=>"ZipCodeLookup",
				"XML"=>$s
			));	
		
		//Test Request #1
		$s = "<TrackRequest USERID='{$this->login['username']}'>
				<TrackID ID='EJ958083578US'></TrackID></TrackRequest>";
		echo $this->curlGet(
			"http://production.shippingapis.com/ShippingAPITest.dll",
			array(
				"API"=>"TrackV2",
				"XML"=>$s
			));	
		
		//Test Request #2
		$s = "<TrackRequest USERID='{$this->login['username']}'>
		<TrackID ID='EJ958088694US'></TrackID></TrackRequest>";
		echo $this->curlGet(
			"http://production.shippingapis.com/ShippingAPITest.dll",
			array(
				"API"=>"TrackV2",
				"XML"=>$s
			));	
		
		//
		$s = "<ExpressMailCommitmentRequest USERID='{$this->login['username']}'>
		      <OriginZIP>207</OriginZIP>
		      <DestinationZIP>11210</DestinationZIP>
		      <Date></Date>
				</ExpressMailCommitmentRequest>";
		echo $this->curlGet(
			"http://production.shippingapis.com/ShippingAPITest.dll",
			array(
				"API"=>"ExpressMailCommitment",
				"XML"=>$s
			));	
		//
		$s = "<ExpressMailCommitmentRequest USERID='{$this->login['username']}'><OriginZIP>20770</OriginZIP>
				<DestinationZIP>11210</DestinationZIP><Date>05-Aug-2004</Date>
				</ExpressMailCommitmentRequest>";
		echo $this->curlGet(
			"http://production.shippingapis.com/ShippingAPITest.dll",
			array(
				"API"=>"ExpressMailCommitment",
				"XML"=>$s
			));	
		
		//	
		$s = "<CarrierPickupAvailabilityRequest USERID='{$this->login['username']}'>
				<FirmName>ABC Corp.</FirmName>
				<SuiteOrApt>Suite 777</SuiteOrApt>
				<Address2>1390 Market Street</Address2>
				<Urbanization></Urbanization>
				<City>Houston</City>
				<State>TX</State>
				<ZIP5>77058</ZIP5>
				<ZIP4>1234</ZIP4>
				</CarrierPickupAvailabilityRequest>";
		echo $this->curlGet(
			"https://secure.shippingapis.com/ShippingAPITest.dll",
			array(
				"API"=>"CarrierPickupAvailability",
				"XML"=>$s
			));	
			
		$s = "<CarrierPickupAvailabilityRequest USERID='{$this->login['username']}'>
		<FirmName></FirmName>
		<SuiteOrApt></SuiteOrApt>
		<Address2>1390 Market Street</Address2>
		<Urbanization></Urbanization>
		<City></City>
		<State></State>
		<ZIP5>77058</ZIP5>
		<ZIP4></ZIP4>
		</CarrierPickupAvailabilityRequest>";
			echo $this->curlGet(
			"https://secure.shippingapis.com/ShippingAPITest.dll",
			array(
				"API"=>"CarrierPickupAvailability",
				"XML"=>$s
			));	
			
			
	}
	
	
}