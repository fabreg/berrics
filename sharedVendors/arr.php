<?php

class Arr {
	
	
	
	public static function continents() {
		
		//http://en.wikipedia.org/wiki/List_of_sovereign_states_and_dependent_territories_by_continent_(data_file)
		$a = array(
			
			'AF' => 'Africa',
			'AS' => 'Asia',
			'EU' => 'Europe',
			'NA' => 'North America',
			'SA' => 'South America',
			'OC' => 'Oceania',
			'AN' =>	'Antarctica'
		);
		
		
		return $a;
		
	}
	
	public static function returnCountriesByContinent($continent) {
		
		$a = array();
		
		$c = self::countries();
		
		$ct = self::ContinentByCountry();
		
		foreach($ct as $k=>$v) {
			
			if($v == $continent) {
				
				if(isset($c[$k])) {
					
					$a[$k] = $c[$k];
					
				}
				
			}
			
		}
		
		return $a;
		
	}
	
	public static function returnContinentByCountry($country,$state = false) {
		
		//first, let's do some quick determinations
		if($country == "US" && $state == "HI") {
			
			return "OC";
			
		}
		
		$cbc = self::ContinentByCountry();
		
		$val = $cbc[$country];
		
		if(empty($val)) {
			
			return "NA";
			
		} else {
			
			return $val;
			
		}
		
	}
	
	public function ContinentByCountry() {
		
		$a = array(
			'AD'=>'EU',
			'AE'=>'AS',
			'AF'=>'AS',
			'AG'=>'NA',
			'AI'=>'NA',
			'AL'=>'EU',
			'AM'=>'AS',
			'AN'=>'NA',
			'AO'=>'AF',
			'AP'=>'AS',
			'AQ'=>'AN',
			'AR'=>'SA',
			'AS'=>'OC',
			'AT'=>'EU',
			'AU'=>'OC',
			'AW'=>'NA',
			'AX'=>'EU',
			'AZ'=>'AS',
			'BA'=>'EU',
			'BB'=>'NA',
			'BD'=>'AS',
			'BE'=>'EU',
			'BF'=>'AF',
			'BG'=>'EU',
			'BH'=>'AS',
			'BI'=>'AF',
			'BJ'=>'AF',
			'BM'=>'NA',
			'BN'=>'AS',
			'BO'=>'SA',
			'BR'=>'SA',
			'BS'=>'NA',
			'BT'=>'AS',
			'BV'=>'AN',
			'BW'=>'AF',
			'BY'=>'EU',
			'BZ'=>'NA',
			'CA'=>'NA',
			'CC'=>'AS',
			'CD'=>'AF',
			'CF'=>'AF',
			'CG'=>'AF',
			'CH'=>'EU',
			'CI'=>'AF',
			'CK'=>'OC',
			'CL'=>'SA',
			'CM'=>'AF',
			'CN'=>'AS',
			'CO'=>'SA',
			'CR'=>'NA',
			'CU'=>'NA',
			'CV'=>'AF',
			'CX'=>'AS',
			'CY'=>'AS',
			'CZ'=>'EU',
			'DE'=>'EU',
			'DJ'=>'AF',
			'DK'=>'EU',
			'DM'=>'NA',
			'DO'=>'NA',
			'DZ'=>'AF',
			'EC'=>'SA',
			'EE'=>'EU',
			'EG'=>'AF',
			'EH'=>'AF',
			'ER'=>'AF',
			'ES'=>'EU',
			'ET'=>'AF',
			'EU'=>'EU',
			'FI'=>'EU',
			'FJ'=>'OC',
			'FK'=>'SA',
			'FM'=>'OC',
			'FO'=>'EU',
			'FR'=>'EU',
			'GA'=>'AF',
			'GB'=>'EU',
			'GD'=>'NA',
			'GE'=>'AS',
			'GF'=>'SA',
			'GG'=>'EU',
			'GH'=>'AF',
			'GI'=>'EU',
			'GL'=>'NA',
			'GM'=>'AF',
			'GN'=>'AF',
			'GP'=>'NA',
			'GQ'=>'AF',
			'GR'=>'EU',
			'GS'=>'AN',
			'GT'=>'NA',
			'GU'=>'OC',
			'GW'=>'AF',
			'GY'=>'SA',
			'HK'=>'AS',
			'HM'=>'AN',
			'HN'=>'NA',
			'HR'=>'EU',
			'HT'=>'NA',
			'HU'=>'EU',
			'ID'=>'AS',
			'IE'=>'EU',
			'IL'=>'AS',
			'IM'=>'EU',
			'IN'=>'AS',
			'IO'=>'AS',
			'IQ'=>'AS',
			'IR'=>'AS',
			'IS'=>'EU',
			'IT'=>'EU',
			'JE'=>'EU',
			'JM'=>'NA',
			'JO'=>'AS',
			'JP'=>'AS',
			'KE'=>'AF',
			'KG'=>'AS',
			'KH'=>'AS',
			'KI'=>'OC',
			'KM'=>'AF',
			'KN'=>'NA',
			'KP'=>'AS',
			'KR'=>'AS',
			'KW'=>'AS',
			'KY'=>'NA',
			'KZ'=>'AS',
			'LA'=>'AS',
			'LB'=>'AS',
			'LC'=>'NA',
			'LI'=>'EU',
			'LK'=>'AS',
			'LR'=>'AF',
			'LS'=>'AF',
			'LT'=>'EU',
			'LU'=>'EU',
			'LV'=>'EU',
			'LY'=>'AF',
			'MA'=>'AF',
			'MC'=>'EU',
			'MD'=>'EU',
			'ME'=>'EU',
			'MG'=>'AF',
			'MH'=>'OC',
			'MK'=>'EU',
			'ML'=>'AF',
			'MM'=>'AS',
			'MN'=>'AS',
			'MO'=>'AS',
			'MP'=>'OC',
			'MQ'=>'NA',
			'MR'=>'AF',
			'MS'=>'NA',
			'MT'=>'EU',
			'MU'=>'AF',
			'MV'=>'AS',
			'MW'=>'AF',
			'MX'=>'NA',
			'MY'=>'AS',
			'MZ'=>'AF',
			'NA'=>'AF',
			'NC'=>'OC',
			'NE'=>'AF',
			'NF'=>'OC',
			'NG'=>'AF',
			'NI'=>'NA',
			'NL'=>'EU',
			'NO'=>'EU',
			'NP'=>'AS',
			'NR'=>'OC',
			'NU'=>'OC',
			'NZ'=>'OC',
			'OM'=>'AS',
			'PA'=>'NA',
			'PE'=>'SA',
			'PF'=>'OC',
			'PG'=>'OC',
			'PH'=>'AS',
			'PK'=>'AS',
			'PL'=>'EU',
			'PM'=>'NA',
			'PN'=>'OC',
			'PR'=>'NA',
			'PS'=>'AS',
			'PT'=>'EU',
			'PW'=>'OC',
			'PY'=>'SA',
			'QA'=>'AS',
			'RE'=>'AF',
			'RO'=>'EU',
			'RS'=>'EU',
			'RU'=>'EU',
			'RW'=>'AF',
			'SA'=>'AS',
			'SB'=>'OC',
			'SC'=>'AF',
			'SD'=>'AF',
			'SE'=>'EU',
			'SG'=>'AS',
			'SH'=>'AF',
			'SI'=>'EU',
			'SJ'=>'EU',
			'SK'=>'EU',
			'SL'=>'AF',
			'SM'=>'EU',
			'SN'=>'AF',
			'SO'=>'AF',
			'SR'=>'SA',
			'ST'=>'AF',
			'SV'=>'NA',
			'SY'=>'AS',
			'SZ'=>'AF',
			'TC'=>'NA',
			'TD'=>'AF',
			'TF'=>'AN',
			'TG'=>'AF',
			'TH'=>'AS',
			'TJ'=>'AS',
			'TK'=>'OC',
			'TL'=>'AS',
			'TM'=>'AS',
			'TN'=>'AF',
			'TO'=>'OC',
			'TR'=>'EU',
			'TT'=>'NA',
			'TV'=>'OC',
			'TW'=>'AS',
			'TZ'=>'AF',
			'UA'=>'EU',
			'UG'=>'AF',
			'UM'=>'OC',
			'US'=>'NA',
			'UY'=>'SA',
			'UZ'=>'AS',
			'VA'=>'EU',
			'VC'=>'NA',
			'VE'=>'SA',
			'VG'=>'NA',
			'VI'=>'NA',
			'VN'=>'AS',
			'VU'=>'OC',
			'WF'=>'OC',
			'WS'=>'OC',
			'YE'=>'AS',
			'YT'=>'AF',
			'ZA'=>'AF',
			'ZM'=>'AF',
			'ZW'=>'AF'
		);
		
		return $a;
		
	}
	
	public static function reportCountries() {
		
		$a = array(
			"A1"=>"Anonymous Proxy"
		);
		
		$c = self::countries();
		
		return $a + $c;
		
	}
	
	public static function countries() {
		
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
	
	public static function usStates() {
		
		$state_array = array(
					            'AL'=>"Alabama",
					            'AK'=>"Alaska",
					            'AZ'=>"Arizona",
					            'AR'=>"Arkansas",
					            'CA'=>"California",
					            'CO'=>"Colorado",
					            'CT'=>"Connecticut",
					            'DE'=>"Delaware",
					            'DC'=>"District Of Columbia",
					            'FL'=>"Florida",
					            'GA'=>"Georgia",
					            'HI'=>"Hawaii",
					            'ID'=>"Idaho",
					            'IL'=>"Illinois",
					            'IN'=>"Indiana",
					            'IA'=>"Iowa",
					            'KS'=>"Kansas",
					            'KY'=>"Kentucky",
					            'LA'=>"Louisiana",
					            'ME'=>"Maine",
					            'MD'=>"Maryland",
					            'MA'=>"Massachusetts",
					            'MI'=>"Michigan",
					            'MN'=>"Minnesota",
					            'MS'=>"Mississippi",
					            'MO'=>"Missouri",
					            'MT'=>"Montana",
					            'NE'=>"Nebraska",
					            'NV'=>"Nevada",
					            'NH'=>"New Hampshire",
					            'NJ'=>"New Jersey",
					            'NM'=>"New Mexico",
					            'NY'=>"New York",
					            'NC'=>"North Carolina",
					            'ND'=>"North Dakota",
					            'OH'=>"Ohio",
					            'OK'=>"Oklahoma",
					            'OR'=>"Oregon",
					            'PA'=>"Pennsylvania",
					            'RI'=>"Rhode Island",
					            'SC'=>"South Carolina",
					            'SD'=>"South Dakota",
					            'TN'=>"Tennessee",
					            'TX'=>"Texas",
					            'UT'=>"Utah",
					            'VT'=>"Vermont",
					            'VA'=>"Virginia",
					            'WA'=>"Washington",
					            'WV'=>"West Virginia",
					            'WI'=>"Wisconsin",
					            'WY'=>"Wyoming"
						);
						
			return $state_array;
		
	}
	
	public static function gbStates() {
		
		
		$ukCounties = array(
							    'Bedfordshire' => 'Bedfordshire',
							    'Berkshire' => 'Berkshire',
							    'Buckinghamshire' => 'Buckinghamshire',
							    'Cambridgeshire' => 'Cambridgeshire',
							    'Cheshire' => 'Cheshire',
							    'Cornwall' => 'Cornwall',
							    'Cumberland' => 'Cumberland',
							    'Derbyshire' => 'Derbyshire',
							    'Devon' => 'Devon',
							    'Dorset' => 'Dorset',
							    'Durham' => 'Durham',
							    'East Yorkshire' => 'East Yorkshire',
							    'Essex' => 'Essex',
							    'Gloucestershire' => 'Gloucestershire',
							    'Hampshire' => 'Hampshire',
							    'Herefordshire' => 'Herefordshire',
							    'Hertfordshire' => 'Hertfordshire',
							    'Huntingdonshire' => 'Huntingdonshire',
							    'Kent' => 'Kent',
							    'Lancashire' => 'Lancashire',
							    'Leicestershire' => 'Leicestershire',
							    'Lincolnshire' => 'Lincolnshire',
							    'Middlesex' => 'Middlesex',
							    'Norfolk' => 'Norfolk',
							    'North Yorkshire' => 'North Yorkshire',
							    'Northamptonshire' => 'Northamptonshire',
							    'Northumberland' => 'Northumberland',
							    'Nottinghamshire' => 'Nottinghamshire',
							    'Oxfordshire' => 'Oxfordshire',
							    'Rutland' => 'Rutland',
							    'Shropshire' => 'Shropshire',
							    'Somerset' => 'Somerset',
							    'Staffordshire' => 'Staffordshire',
							    'Suffolk' => 'Suffolk',
							    'Surrey' => 'Surrey',
							    'Sussex' => 'Sussex',
							    'Warwickshire' => 'Warwickshire',
							    'West Yorkshire' => 'West Yorkshire',
							    'Westmorland' => 'Westmorland',
							    'Wiltshire' => 'Wiltshire',
							    'Worcestershire' => 'Worcestershire',
							    'Aberdeenshire' => 'Aberdeenshire',
							    'Angus/Forfarshire' => 'Angus/Forfarshire',
							    'Argyllshire' => 'Argyllshire',
							    'Ayrshire' => 'Ayrshire',
							    'Banffshire' => 'Banffshire',
							    'Berwickshire' => 'Berwickshire',
							    'Buteshire' => 'Buteshire',
							    'Cromartyshire' => 'Cromartyshire',
							    'Caithness' => 'Caithness',
							    'Clackmannanshire' => 'Clackmannanshire',
							    'Dumfriesshire' => 'Dumfriesshire',
							    'Dunbartonshire/Dumbartonshire' => 'Dunbartonshire/Dumbartonshire',
							    'East Lothian/Haddingtonshire' => 'East Lothian/Haddingtonshire',
							    'Fife' => 'Fife',
							    'Inverness-shire' => 'Inverness-shire',
							    'Kincardineshire' => 'Kincardineshire',
							    'Kinross-shire' => 'Kinross-shire',
							    'Kirkcudbrightshire' => 'Kirkcudbrightshire',
							    'Lanarkshire' => 'Lanarkshire',
							    'Midlothian/Edinburghshire' => 'Midlothian/Edinburghshire',
							    'Morayshire' => 'Morayshire',
							    'Nairnshire' => 'Nairnshire',
							    'Orkney' => 'Orkney',
							    'Peeblesshire' => 'Peeblesshire',
							    'Perthshire' => 'Perthshire',
							    'Renfrewshire' => 'Renfrewshire',
							    'Ross-shire' => 'Ross-shire',
							    'Roxburghshire' => 'Roxburghshire',
							    'Selkirkshire' => 'Selkirkshire',
							    'Shetland' => 'Shetland',
							    'Stirlingshire' => 'Stirlingshire',
							    'Sutherland' => 'Sutherland',
							    'West Lothian/Linlithgowshire' => 'West Lothian/Linlithgowshire',
							    'Wigtownshire' => 'Wigtownshire',
							    'Anglesey/Sir Fon' => 'Anglesey/Sir Fon',
							    'Brecknockshire/Sir Frycheiniog' => 'Brecknockshire/Sir Frycheiniog',
							    'Caernarfonshire/Sir Gaernarfon' => 'Caernarfonshire/Sir Gaernarfon',
							    'Carmarthenshire/Sir Gaerfyrddin' => 'Carmarthenshire/Sir Gaerfyrddin',
							    'Cardiganshire/Ceredigion' => 'Cardiganshire/Ceredigion',
							    'Denbighshire/Sir Ddinbych' => 'Denbighshire/Sir Ddinbych',
							    'Flintshire/Sir Fflint' => 'Flintshire/Sir Fflint',
							    'Glamorgan/Morgannwg' => 'Glamorgan/Morgannwg',
							    'Merioneth/Meirionnydd' => 'Merioneth/Meirionnydd',
							    'Monmouthshire/Sir Fynwy' => 'Monmouthshire/Sir Fynwy',
							    'Montgomeryshire/Sir Drefaldwyn' => 'Montgomeryshire/Sir Drefaldwyn',
							    'Pembrokeshire/Sir Benfro' => 'Pembrokeshire/Sir Benfro',
							    'Radnorshire/Sir Faesyfed' => 'Radnorshire/Sir Faesyfed',
							    'County Antrim' => 'County Antrim',
							    'County Armagh' => 'County Armagh',
							    'County Down' => 'County Down',
							    'County Fermanagh' => 'County Fermanagh',
							    'County Tyrone' => 'County Tyrone',
							    'County Londonderry/Derry' => 'County Londonderry/Derry',
							);
							
				return $ukCounties;
		
	}
	
	public static function caStates() {
		
				return array( 
								"BC"=>"British Columbia", 
								"ON"=>"Ontario", 
								"NF"=>"Newfoundland", 
								"NS"=>"Nova Scotia", 
								"PE"=>"Prince Edward Island", 
								"NB"=>"New Brunswick", 
								"QC"=>"Quebec", 
								"MB"=>"Manitoba", 
								"SK"=>"Saskatchewan", 
								"AB"=>"Alberta", 
								"NT"=>"Northwest Territories", 
								"YT"=>"Yukon Territory");	
		
	}
	
	public static function auStates() {
		
		return array(
					'AAT' => 'Australian Antarctic Territory',
					'ACT' => 'Australian Capital Territory',
					'JBT' => 'Jervis Bay Territory',
					'NSW' => 'New South Wales',
					'NT' => 'Northern Territory',
					'QLD' => 'Queensland',
					'SA' => 'South Australia',
					'TAS' => 'Tasmania',
					'VIC' => 'Victoria',
					'WA' => 'Western Australia'
					);
		
	}
	
	public static function brStates() {
		
		$a = array(
				'AC'=>'Acre',
				'AL'=>'Alagoas',
				'AP'=>'Amapá',
				'AM'=>'Amazonas',
				'BA'=>'Bahia',
				'CE'=>'Ceará',
				'DF'=>'Distrito Federal',
				'ES'=>'Espírito Santo',
				'GO'=>'Goiás',
				'MA'=>'Maranhão',
				'MT'=>'Mato Grosso',
				'MS'=>'Mato Grosso do Sul',
				'MG'=>'Minas Gerais',
				'PA'=>'Pará',
				'PB'=>'Paraíba',
				'PR'=>'Paraná',
				'PE'=>'Pernambuco',
				'PI'=>'Piauí',
				'RJ'=>'Rio de Janeiro',
				'RN'=>'Rio Grande do Norte',
				'RS'=>'Rio Grande do Sul',
				'RO'=>'Rondônia',
				'RR'=>'Roraima',
				'SC'=>'Santa Catarina',
				'SP'=>'São Paulo',
				'SE'=>'Sergipe',
				'TO'=>'Tocantins'
		);
		
		return $a;
		
	}
	
	public static function states() {
		$gb = self::gbStates();
		sort($gb);
		$a = array(
		
			"US"=>self::usStates(),
			"CA"=>self::caStates(),
			"AU"=>self::auStates(),
			"GB"=>$gb,
			"BR"=>self::brStates()
		
		);
		
		return $a;
		
	}	
	
	
	public static function videoAdUrls($options = false) {
		
		$a = array(
		
			"DefaultPreRoll"=>"http://ad.doubleclick.net/N5885/pfadx/berr.mainvid/;res=glo;sz=8x8;ord=".time()."?",
			"DefaultPostRoll"=>"http://ad.doubleclick.net/N5885/pfadx/berr.mainvid/;res=glo;sz=8x8;ord=".time()."?",
			"PreRollLocked"=>"http://ad.doubleclick.net/N5885/adx/PRELOCK;sz=8x8;cue=pre;ord=".time()."?",
			"NewDefaultPreRoll"=>"http://ad.doubleclick.net/N5885/adx/PRE001;sz=8x8;cue=pre;ord=".time()."?",
			"NewDefaultPostRoll"=>"http://ad.doubleclick.net/N5885/adx/PRE001;sz=8x8;cue=post;ord=".time()."?",
			"BATB4PreRoll"=>"http://ad.doubleclick.net/N5885/adx/#LABEL#;sz=8x8;cue=pre;ord=".time()."?",
			"BATB4PostRoll"=>"http://ad.doubleclick.net/N5885/adx/#LABEL#;sz=8x8;cue=post;ord=".time()."?"
			
		);
		//
		if($options !== false) {
			
			if(is_bool($options)) {
				
				$tmp = array();
				foreach($a as $k=>$v) $tmp[$k]=$k;
				$a = $tmp;
				 
			} else if(is_string($options) && array_key_exists($options,$a)) {
				
				$a = $a[$options];
				
			}
			
		}
		
		return $a;
		
	}
	
	
	public static function adLabelUrls() {
		
		return array(
			"preroll"=>"http://ad.doubleclick.net/N5885/adx/#LABEL#;sz=8x8;cue=pre;#TAGS#ord=".microtime()."?",
			"postroll"=>"http://ad.doubleclick.net/N5885/adx/#LABEL#;sz=8x8;cue=post;#TAGS#ord=".microtime()."?"
		);
		
	}
	

	
	
	public static function sectionViewOverrides() {
		
		$a = array(
			
			""=>"Standard",
			"stacked2"=>"Stacked 2 Per Row",
			"stacked3"=>"Stacked 3 Per Row",
			"firstpost"=>"Standard Shit with latest post on top",
			"firstpost2"=>"Latest Post Stacked 2 Per Row",
			"firstpost3"=>"Latest Post Stacked 3 Per Row"
			
		);
		
		return $a;
		
	}
	
	public static function dailyopsMiscCategories() {
		
		$a = array(
		
			"younited-promo"=>"YOUnited Nations Promo",
			"younited-entry"=>"YOUnited Nations Entry",
			"younited-finalist"=>"YOUnited Nations Finalist",
			"news-general"=>"News - General",
			"news-unified"=>"News - Unified",
			"news-event"=>"News - Event"
		
		);
		
		return $a;
		
	}
	
	
	
	static function adLabels() {
		
		$a = array(
		
			"BATB4"=>"BATB4",
			"PRE001"=>"PRE001",
			"LEVIS"=>"LEVIS",
			"POST001"=>"POST001",
			"BYS3"=>"BYS3"
			
		);
		
		return $a;
		
	}
	
	
}
