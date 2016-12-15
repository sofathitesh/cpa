<?php

function getIP()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}


function safeGet($val){
// safe from most dangerous chars 
$val = str_replace(array('&', '"', '<', '>'),array('&amp;', '&quot;',
'&lt;', '&gt;'),$val);
	
return $val;
} 

function makesafe($val)
{

  $var = trim($val);
  if(get_magic_quotes_gpc())
  {
	$var = stripslashes($var);
  }
	
  if(function_exists('mysql_real_escape_string'))
  {
	 $var = mysql_real_escape_string($var);
  }else
  {
     $var = addslashes($var);
  }
	  
	  return $var;
  
}


function validURL($url)
{
    return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url);
}
	
		
function getCountryName($country_code)
{
$array = array("AF" => "AFGHANISTAN", "AX" => "ALAND ISLANDS", "AL" => "ALBANIA", "DZ" => "ALGERIA", "AS" => "AMERICAN SAMOA", "AD" =>  "ANDORRA", "AO" => "ANGOLA", "AI" => "ANGUILLA", "AQ" => "ANTARCTICA", "AG" => "ANTIGUA AND BARBUDA", "AR" => "ARGENTINA", "AM" => "ARMENIA", "AW" => "ARUBA", "AU" => "AUSTRALIA", "AT" => "AUSTRIA", "AZ" => "AZERBAIJAN", "BS" => "BAHAMAS", "BH" => "BAHRAIN", "BD" => "BANGLADESH", "BB" => "BARBADOS", "BY" => "BELARUS", "BE" => "BELGIUM", "BZ" => "BELIZE", "BJ" => "BENIN", "BM" => "BERMUDA", "BT" => "BHUTAN", "BO" => "BOLIVIA, PLURINATIONAL STATE OF", "BA" => "BOSNIA AND HERZEGOVINA", "BW" => "BOTSWANA", "BV" => "BOUVET ISLAND", "BR" => "BRAZIL", "IO" => "BRITISH INDIAN OCEAN TERRITORY", "BN" => "BRUNEI DARUSSALAM", "BG" => "BULGARIA", "BF" => "BURKINA FASO", "BI" => "BURUNDI", "KH" => "CAMBODIA", "CM" => "CAMEROON", "CA" => "CANADA", "CV" => "CAPE VERDE", "KY" => "CAYMAN ISLANDS", "CF" => "CENTRAL AFRICAN REPUBLIC", "TD" => "CHAD", "CL" => "CHILE", "CN" => "CHINA", "CX" => "CHRISTMAS ISLAND", "CC" => "COCOS (KEELING) ISLANDS", "CO" => "COLOMBIA", "KM" => "COMOROS", "CG" => "CONGO", "CD" => "CONGO, THE DEMOCRATIC REPUBLIC OF THE", "CK" => "COOK ISLANDS", "CR" => "COSTA RICA", "CI" => "CÔTE D'IVOIRE", "HR" => "CROATIA", "CU" => "CUBA", "CY" => "CYPRUS", "CZ" =>  "CZECH REPUBLIC", "DK" => "DENMARK", "DJ" => "DJIBOUTI", "DM" => "DOMINICA", "DO" => "DOMINICAN REPUBLIC", "EC" => "ECUADOR", "EG" => "EGYPT", "SV" => "EL SALVADOR", "GQ" => "EQUATORIAL GUINEA", "ER" => "ERITREA", "EE" => "ESTONIA", "ET" => "ETHIOPIA", "FK" => "FALKLAND ISLANDS (MALVINAS)", "FO" => "FAROE ISLANDS", "FJ" => "FIJI", "FI" => "FINLAND", "FR" => "FRANCE", "GF" => "FRENCH GUIANA", "PF" => "FRENCH POLYNESIA", "TF" => "FRENCH SOUTHERN TERRITORIES", "GA" => "GABON", "GM" => "GAMBIA", "GE" => "GEORGIA", "DE" => "GERMANY", "GH" => "GHANA", "GI" => "GIBRALTAR", "GR" => "GREECE", "GL" => "GREENLAND", "GD" => "GRENADA", "GP" => "GUADELOUPE", "GU" => "GUAM", "GT" => "GUATEMALA", "GG" => "GUERNSEY", "GN" => "GUINEA", "GW" => "GUINEA-BISSAU", "GY" => "GUYANA", "HT" => "HAITI", "HM" => "HEARD ISLAND AND MCDONALD ISLANDS", "VA" => "HOLY SEE (VATICAN CITY STATE)", "HN" => "HONDURAS", "HK" => "HONG KONG", "HU" => "HUNGARY", "IS" => "ICELAND", "IN" => "INDIA", "ID" => "INDONESIA", "IR" => "IRAN, ISLAMIC REPUBLIC OF", "IQ" => "IRAQ", "IE" => "IRELAND", "IM" => "ISLE OF MAN", "IL" => "ISRAEL", "IT" => "ITALY", "JM" => "JAMAICA", "JP" => "JAPAN", "JE" =>  "JERSEY", "JO" => "JORDAN", "KZ" => "KAZAKHSTAN", "KE" => "KENYA", "KI" => "KIRIBATI", "KP" => "KOREA, DEMOCRATIC PEOPLE'S REPUBLIC OF", "KR" => "KOREA, REPUBLIC OF", "KW" => "KUWAIT", "KG" => "KYRGYZSTAN", "LA" => "LAO PEOPLE'S DEMOCRATIC REPUBLIC", "LV" => "LATVIA", "LB" => "LEBANON", "LS" => "LESOTHO", "LR" => "LIBERIA", "LY" => "LIBYAN ARAB JAMAHIRIYA", "LI" => "LIECHTENSTEIN", "LT" => "LITHUANIA", "LU" => "LUXEMBOURG", "MO" => "MACAO", "MK" => "MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF", "MG" => "MADAGASCAR", "MW" => "MALAWI", "MY" => "MALAYSIA", "MV" => "MALDIVES", "ML" => "MALI", "MT" => "MALTA", "MH" =>  "MARSHALL ISLANDS", "MQ" => "MARTINIQUE", "MR" => "MAURITANIA", "MU" => "MAURITIUS", "YT" => "MAYOTTE", "MX" => "MEXICO", "FM" => "MICRONESIA, FEDERATED STATES OF", "MD" => "MOLDOVA, REPUBLIC OF", "MC" => "MONACO", "MN" => "MONGOLIA", "ME" => "MONTENEGRO", "MS" => "MONTSERRAT", "MA" => "MOROCCO", "MZ" => "MOZAMBIQUE", "MM" => "MYANMAR", "NA" => "NAMIBIA", "NR" => "NAURU", "NP" => "NEPAL", "NL" => "NETHERLANDS", "AN" => "NETHERLANDS ANTILLES", "NC" => "NEW CALEDONIA", "NZ" => "NEW ZEALAND", "NI" => "NICARAGUA", "NE" => "NIGER", "NG" => "NIGERIA", "NU" => "NIUE", "NF" => "NORFOLK ISLAND", "MP" => "NORTHERN MARIANA ISLANDS", "NO" => "NORWAY", "OM" => "OMAN", "PK" => "PAKISTAN", "PW" => "PALAU", "PS" => "PALESTINIAN TERRITORY, OCCUPIED", "PA" => "PANAMA", "PG" => "PAPUA NEW GUINEA", "PY" => "PARAGUAY", "PE" => "PERU", "PH" => "PHILIPPINES", "PN" => "PITCAIRN", "PL" => "POLAND", "PT" => "PORTUGAL", "PR" => "PUERTO RICO", "QA" => "QATAR", "RE" => "REUNION", "RO" => "ROMANIA", "RU" => "RUSSIAN FEDERATION", "RW" => "RWANDA", "BL" => "SAINT BARTHÉLEMY", "SH" => "SAINT HELENA, ASCENSION AND TRISTAN DA CUNHA", "KN" => "SAINT KITTS AND NEVIS", "LC" => "SAINT LUCIA", "MF" => "SAINT MARTIN", "PM" => "SAINT PIERRE AND MIQUELON", "VC" => "SAINT VINCENT AND THE GRENADINES", "WS" => "SAMOA", "SM" => "SAN MARINO", "ST" => "SAO TOME AND PRINCIPE", "SA" => "SAUDI ARABIA", "SN" => "SENEGAL", "RS" => "SERBIA", "SC" => "SEYCHELLES", "SL" => "SIERRA LEONE", "SG" => "SINGAPORE", "SK" => "SLOVAKIA", "SI" => "SLOVENIA", "SB" => "SOLOMON ISLANDS", "SO" => "SOMALIA", "ZA" => "SOUTH AFRICA", "GS" => "SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS", "ES" => "SPAIN", "LK" => "SRI LANKA", "SD" => "SUDAN", "SR" => "SURINAME", "SJ" => "SVALBARD AND JAN MAYEN", "SZ" => "SWAZILAND", "SE" => "SWEDEN", "CH" => "SWITZERLAND", "SY" => "SYRIAN ARAB REPUBLIC", "TW" => "TAIWAN, PROVINCE OF CHINA", "TJ" => "TAJIKISTAN", "TZ" => "TANZANIA, UNITED REPUBLIC OF", "TH" => "THAILAND", "TL" => "TIMOR-LESTE", "TG" => "TOGO", "TK" => "TOKELAU", "TO" => "TONGA", "TT" => "TRINIDAD AND TOBAGO", "TN" => "TUNISIA", "TR" => "TURKEY", "TM" => "TURKMENISTAN", "TC" => "TURKS AND CAICOS ISLANDS", "TV" => "TUVALU", "UG" => "UGANDA", "UA" => "UKRAINE", "AE" => "UNITED ARAB EMIRATES", "GB" => "UNITED KINGDOM", "US" => "UNITED STATES", "UM" => "UNITED STATES MINOR OUTLYING ISLANDS", "UY" => "URUGUAY", "UZ" => "UZBEKISTAN", "VU" => "VANUATU", "VE" => "VENEZUELA, BOLIVARIAN REPUBLIC OF", "VN" => "VIET NAM", "VG" => "VIRGIN ISLANDS, BRITISH", "VI" => "VIRGIN ISLANDS, U.S.", "WF" =>  "WALLIS AND FUTUNA", "EH" => "WESTERN SAHARA", "YE" => "YEMEN", "ZM" => "ZAMBIA", "ZW" => "ZIMBABWE");	


foreach($array as $k => $v)
{
    if($country_code == $k)
	{
		$name = $v;
		break;	
	}	
}

return $name;

}


function getCountries($sel = '')
{
$opts = "";
$array = array("AF" => "AFGHANISTAN", "AX" => "ALAND ISLANDS", "AL" => "ALBANIA", "DZ" => "ALGERIA", "AS" => "AMERICAN SAMOA", "AD" =>  "ANDORRA", "AO" => "ANGOLA", "AI" => "ANGUILLA", "AQ" => "ANTARCTICA", "AG" => "ANTIGUA AND BARBUDA", "AR" => "ARGENTINA", "AM" => "ARMENIA", "AW" => "ARUBA", "AU" => "AUSTRALIA", "AT" => "AUSTRIA", "AZ" => "AZERBAIJAN", "BS" => "BAHAMAS", "BH" => "BAHRAIN", "BD" => "BANGLADESH", "BB" => "BARBADOS", "BY" => "BELARUS", "BE" => "BELGIUM", "BZ" => "BELIZE", "BJ" => "BENIN", "BM" => "BERMUDA", "BT" => "BHUTAN", "BO" => "BOLIVIA, PLURINATIONAL STATE OF", "BA" => "BOSNIA AND HERZEGOVINA", "BW" => "BOTSWANA", "BV" => "BOUVET ISLAND", "BR" => "BRAZIL", "IO" => "BRITISH INDIAN OCEAN TERRITORY", "BN" => "BRUNEI DARUSSALAM", "BG" => "BULGARIA", "BF" => "BURKINA FASO", "BI" => "BURUNDI", "KH" => "CAMBODIA", "CM" => "CAMEROON", "CA" => "CANADA", "CV" => "CAPE VERDE", "KY" => "CAYMAN ISLANDS", "CF" => "CENTRAL AFRICAN REPUBLIC", "TD" => "CHAD", "CL" => "CHILE", "CN" => "CHINA", "CX" => "CHRISTMAS ISLAND", "CC" => "COCOS (KEELING) ISLANDS", "CO" => "COLOMBIA", "KM" => "COMOROS", "CG" => "CONGO", "CD" => "CONGO, THE DEMOCRATIC REPUBLIC OF THE", "CK" => "COOK ISLANDS", "CR" => "COSTA RICA", "CI" => "CÔTE D'IVOIRE", "HR" => "CROATIA", "CU" => "CUBA", "CY" => "CYPRUS", "CZ" =>  "CZECH REPUBLIC", "DK" => "DENMARK", "DJ" => "DJIBOUTI", "DM" => "DOMINICA", "DO" => "DOMINICAN REPUBLIC", "EC" => "ECUADOR", "EG" => "EGYPT", "SV" => "EL SALVADOR", "GQ" => "EQUATORIAL GUINEA", "ER" => "ERITREA", "EE" => "ESTONIA", "ET" => "ETHIOPIA", "FK" => "FALKLAND ISLANDS (MALVINAS)", "FO" => "FAROE ISLANDS", "FJ" => "FIJI", "FI" => "FINLAND", "FR" => "FRANCE", "GF" => "FRENCH GUIANA", "PF" => "FRENCH POLYNESIA", "TF" => "FRENCH SOUTHERN TERRITORIES", "GA" => "GABON", "GM" => "GAMBIA", "GE" => "GEORGIA", "DE" => "GERMANY", "GH" => "GHANA", "GI" => "GIBRALTAR", "GR" => "GREECE", "GL" => "GREENLAND", "GD" => "GRENADA", "GP" => "GUADELOUPE", "GU" => "GUAM", "GT" => "GUATEMALA", "GG" => "GUERNSEY", "GN" => "GUINEA", "GW" => "GUINEA-BISSAU", "GY" => "GUYANA", "HT" => "HAITI", "HM" => "HEARD ISLAND AND MCDONALD ISLANDS", "VA" => "HOLY SEE (VATICAN CITY STATE)", "HN" => "HONDURAS", "HK" => "HONG KONG", "HU" => "HUNGARY", "IS" => "ICELAND", "IN" => "INDIA", "ID" => "INDONESIA", "IR" => "IRAN, ISLAMIC REPUBLIC OF", "IQ" => "IRAQ", "IE" => "IRELAND", "IM" => "ISLE OF MAN", "IL" => "ISRAEL", "IT" => "ITALY", "JM" => "JAMAICA", "JP" => "JAPAN", "JE" =>  "JERSEY", "JO" => "JORDAN", "KZ" => "KAZAKHSTAN", "KE" => "KENYA", "KI" => "KIRIBATI", "KP" => "KOREA, DEMOCRATIC PEOPLE'S REPUBLIC OF", "KR" => "KOREA, REPUBLIC OF", "KW" => "KUWAIT", "KG" => "KYRGYZSTAN", "LA" => "LAO PEOPLE'S DEMOCRATIC REPUBLIC", "LV" => "LATVIA", "LB" => "LEBANON", "LS" => "LESOTHO", "LR" => "LIBERIA", "LY" => "LIBYAN ARAB JAMAHIRIYA", "LI" => "LIECHTENSTEIN", "LT" => "LITHUANIA", "LU" => "LUXEMBOURG", "MO" => "MACAO", "MK" => "MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF", "MG" => "MADAGASCAR", "MW" => "MALAWI", "MY" => "MALAYSIA", "MV" => "MALDIVES", "ML" => "MALI", "MT" => "MALTA", "MH" =>  "MARSHALL ISLANDS", "MQ" => "MARTINIQUE", "MR" => "MAURITANIA", "MU" => "MAURITIUS", "YT" => "MAYOTTE", "MX" => "MEXICO", "FM" => "MICRONESIA, FEDERATED STATES OF", "MD" => "MOLDOVA, REPUBLIC OF", "MC" => "MONACO", "MN" => "MONGOLIA", "ME" => "MONTENEGRO", "MS" => "MONTSERRAT", "MA" => "MOROCCO", "MZ" => "MOZAMBIQUE", "MM" => "MYANMAR", "NA" => "NAMIBIA", "NR" => "NAURU", "NP" => "NEPAL", "NL" => "NETHERLANDS", "AN" => "NETHERLANDS ANTILLES", "NC" => "NEW CALEDONIA", "NZ" => "NEW ZEALAND", "NI" => "NICARAGUA", "NE" => "NIGER", "NG" => "NIGERIA", "NU" => "NIUE", "NF" => "NORFOLK ISLAND", "MP" => "NORTHERN MARIANA ISLANDS", "NO" => "NORWAY", "OM" => "OMAN", "PK" => "PAKISTAN", "PW" => "PALAU", "PS" => "PALESTINIAN TERRITORY, OCCUPIED", "PA" => "PANAMA", "PG" => "PAPUA NEW GUINEA", "PY" => "PARAGUAY", "PE" => "PERU", "PH" => "PHILIPPINES", "PN" => "PITCAIRN", "PL" => "POLAND", "PT" => "PORTUGAL", "PR" => "PUERTO RICO", "QA" => "QATAR", "RE" => "REUNION", "RO" => "ROMANIA", "RU" => "RUSSIAN FEDERATION", "RW" => "RWANDA", "BL" => "SAINT BARTHÉLEMY", "SH" => "SAINT HELENA, ASCENSION AND TRISTAN DA CUNHA", "KN" => "SAINT KITTS AND NEVIS", "LC" => "SAINT LUCIA", "MF" => "SAINT MARTIN", "PM" => "SAINT PIERRE AND MIQUELON", "VC" => "SAINT VINCENT AND THE GRENADINES", "WS" => "SAMOA", "SM" => "SAN MARINO", "ST" => "SAO TOME AND PRINCIPE", "SA" => "SAUDI ARABIA", "SN" => "SENEGAL", "RS" => "SERBIA", "SC" => "SEYCHELLES", "SL" => "SIERRA LEONE", "SG" => "SINGAPORE", "SK" => "SLOVAKIA", "SI" => "SLOVENIA", "SB" => "SOLOMON ISLANDS", "SO" => "SOMALIA", "ZA" => "SOUTH AFRICA", "GS" => "SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS", "ES" => "SPAIN", "LK" => "SRI LANKA", "SD" => "SUDAN", "SR" => "SURINAME", "SJ" => "SVALBARD AND JAN MAYEN", "SZ" => "SWAZILAND", "SE" => "SWEDEN", "CH" => "SWITZERLAND", "SY" => "SYRIAN ARAB REPUBLIC", "TW" => "TAIWAN, PROVINCE OF CHINA", "TJ" => "TAJIKISTAN", "TZ" => "TANZANIA, UNITED REPUBLIC OF", "TH" => "THAILAND", "TL" => "TIMOR-LESTE", "TG" => "TOGO", "TK" => "TOKELAU", "TO" => "TONGA", "TT" => "TRINIDAD AND TOBAGO", "TN" => "TUNISIA", "TR" => "TURKEY", "TM" => "TURKMENISTAN", "TC" => "TURKS AND CAICOS ISLANDS", "TV" => "TUVALU", "UG" => "UGANDA", "UA" => "UKRAINE", "AE" => "UNITED ARAB EMIRATES", "GB" => "UNITED KINGDOM", "US" => "UNITED STATES", "UM" => "UNITED STATES MINOR OUTLYING ISLANDS", "UY" => "URUGUAY", "UZ" => "UZBEKISTAN", "VU" => "VANUATU", "VE" => "VENEZUELA, BOLIVARIAN REPUBLIC OF", "VN" => "VIET NAM", "VG" => "VIRGIN ISLANDS, BRITISH", "VI" => "VIRGIN ISLANDS, U.S.", "WF" =>  "WALLIS AND FUTUNA", "EH" => "WESTERN SAHARA", "YE" => "YEMEN", "ZM" => "ZAMBIA", "ZW" => "ZIMBABWE");	


foreach($array as $k => $v)
{
    if($country_code == $k)
	$opts .= "<option value=\"$k\" selected=\"selected\">$v</option>";
	else
	$opts .= "<option value=\"$k\">$v</option>";	

}

return $opts;

	
}


//this function will register new session id for widget, associated to user and gateway
function registerSessId($gwid, $aff_id)
{
	$hash = md5(strtotime('now').uniqid());
	
	$hash = substr($hash, 0, 23);
	
	$gwid = makesafe($gwid);
	$aff_id = makesafe($aff_id);
	if(mysql_num_rows(mysql_query("SELECT id from gw_sessions WHERE session_id = '$hash' AND gid = '$gwid'"))){
	  while(mysql_num_rows(mysql_query("SELECT id from gw_sessions WHERE session_id = '$hash' AND gid = '$gwid'")))
	  {
		  $hash .= rand(000,999);
	  }
	}
	
	$ip = getIP();
	
	if(mysql_query("INSERT INTO gw_sessions VALUES(NULL, '$aff_id', '$gwid', '$hash', 0, '$ip', NOW())"))	
	return $hash;
	else
	return false;
}


function validateSession($sessId, $gwid, $aff_id)
{
 
 
   if(mysql_num_rows(mysql_query("SELECT id FROM gw_sessions WHERE session_id = '$sessId' AND gid = '$gwid' AND uid = '$aff_id' AND complete = 1")))
   return true;
   else
   return false;
   	
}

function sessionExists($sessId)
{
   if(mysql_num_rows(mysql_query("SELECT id FROM gw_sessions WHERE session_id = '$sessId'")))
   return true;
   else
   return false;
	
}



function setGWEpc($campId, $network)
{
    $sql = mysql_query("SELECT hits, leads FROM offers WHERE campaign_id = '$campId' AND network = '$network' LIMIT 1");	
	if(mysql_num_rows($sql))
	{
		
		$row = mysql_fetch_object($sql);
		$clicks = $row->hits;
		$leads = $row->leads;
		
		if(!empty($clicks))
		{
		    $epc = sprintf("%.2f", $leads/$clicks );	
			if(mysql_query("UPDATE offers SET epc = '$epc' WHERE campaign_id = '$campId' AND network = '$network' LIMIT 1"))
				return true;
            else
                return false;
		}
		
	}else
	{
        return false;		
	}
	
}

function get_domain($url)
{
  $pieces = parse_url($url);
  $domain = isset($pieces['host']) ? $pieces['host'] : '';
  if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
    return $regs['domain'];
  }
  return $url;
}	




function getFilenameById($id)
{
		$sssql = mysql_query("SELECT filename FROM files WHERE id = '$id'");
		if(!mysql_num_rows($sssql))
  	    return false;
		else
		$row = mysql_fetch_object($sssql);
		return $row->filename;
}
	
	

function getFileEncodedNameById($id)
{
		$sssql = mysql_query("SELECT  	encodedname FROM files WHERE id = '$id'");
		if(!mysql_num_rows($sssql))
  	    return false;
		else
		$row = mysql_fetch_object($sssql);
		return $row->encodedname;
}
		

function getFileCodeById($fid)
{
	
    $code = makesafe($code);
	$sql = mysql_query("SELECT code  FROM files WHERE id = '$fid'");
	if(mysql_num_rows($sql))
	{
		
		$r = mysql_fetch_object($sql);
		return $r->code;
		
	}else{
	return false;
	}	
}	



function getOfferName($camp, $network)
{
    $sql = mysql_query("SELECT name FROM offers WHERE campaign_id = '$camp' AND network = '$network'");
	if(!mysql_num_rows($sql))
	{
	    return false;
	}
	
	$row = mysql_fetch_object($sql);
	
	return $row->name;
}
			
function getOfferPayout($camp, $network)
{
	$sql = mysql_query("SELECT credits FROM offers WHERE campaign_id = '$camp' AND network = '$network'");
	if(!mysql_num_rows($sql))
	{
	    return false;
	}
	
	$row = mysql_fetch_object($sql);
	
	return $row->credits;
}


function getUserPromoCode($uid)
{
	$sql = mysql_query("SELECT promo_codes FROM users WHERE uid = '$uid' AND active = 1");
	if(!mysql_num_rows($sql))
	{
	    return false;
	}
	
	$row = mysql_fetch_object($sql);
	
	return $row->promo_codes;	
}
	
	
function isValidPromo($code) //check if promo exists
{
	$sql = mysql_query("SELECT id FROM promo_codes WHERE code = '$code'");
	if(!mysql_num_rows($sql))
	{
	    return false;
	}
	
	$row = mysql_fetch_object($sql);
	
	return $row->id;		
}	


function isUserPromoActive($uid)
{
	$sql = mysql_query("SELECT promo_active FROM users WHERE uid = '$uid' AND active = 1");
	if(!mysql_num_rows($sql))
	{
	    return false;
	}
	
	$row = mysql_fetch_object($sql);
	
	return $row->promo_active;		
}
	
	
function getPromoSetupDate($uid) //check if promo exists
{
	$sql = mysql_query("SELECT promo_codes_updated_on FROM users WHERE uid = '$uid' AND active = 1");
	if(!mysql_num_rows($sql))
	{
	    return false;
	}
	
	$row = mysql_fetch_object($sql);
	
	return $row->promo_codes_updated_on;	
}	
		
	
function isPromoExpired($uid, $code)
{

    if(!getUserPromoCode($uid) || !isUserPromoActive($uid))
	return true;
	
	
	$expireOn = strtotime(getPromoExpiry($uid));
	$now = strtotime('now');
	
	if($now > $expireOn){
		
	@mysql_query("UPDATE users SET promo_codes = NULL, promo_codes_updated_on = NULL, promo_codes_expire_on = NULL, promo_active = 0 WHERE uid = '$uid' LIMIT 1");	
		
	return true;
	}else
	return false;
	
	
}

function getPromoRate($code)
{
	$sql = mysql_query("SELECT rate_amt FROM promo_codes WHERE code = '$code'");
	if(!mysql_num_rows($sql))
	{
	    return false;
	}
	
	$row = mysql_fetch_object($sql);
	
	return $row->rate_amt;	
}


function getPromoUsage($code)
{
	$sql = mysql_query("SELECT used FROM promo_codes WHERE code = '$code'");
	if(!mysql_num_rows($sql))
	{
	    return false;
	}
	
	$row = mysql_fetch_object($sql);
	
	return $row->used;	
}


function getPromoDuration($code)
{
	$sql = mysql_query("SELECT period FROM promo_codes WHERE code = '$code'");
	if(!mysql_num_rows($sql))
	{
	    return false;
	}
	
	$row = mysql_fetch_object($sql);
	
	return $row->period;	
}


function getPromoExpiry($uid)
{
	$sql = mysql_query("SELECT promo_codes_expire_on FROM users WHERE uid = '$uid' AND active = 1");
	if(!mysql_num_rows($sql))
	{
	    return false;
	}
	
	$row = mysql_fetch_object($sql);
	
	return $row->promo_codes_expire_on;
}

function calculatePromoExpiry($code)
{
    $sql = mysql_query("SELECT * FROM promo_codes WHERE code = '$code'");
	if(!mysql_num_rows($sql))
	{
	    return false;
	}
	
	$row = mysql_fetch_object($sql);
	$days = $row->period;
	$type = $row->period_type;
	$expiry = date("Y-m-d H:i:s",strtotime("+".$days." $type"));
	

	return $expiry;
}



function time_remaining($timeLeft=0, $endTime=null) {

        /*check if 'endTime' parameter exists so we can calculate timeLeft
        else timeLeft will be '0' and function will return (0,0,0,0)*/
    if($endTime != null)
                $timeLeft = $endTime - time();
               
        /*if timeLeft value is bigger than 0 we have number
        that we can work with, else we return (0,0,0,0) */
    if($timeLeft > 0) {
       
                /*divide timeLeft value with number of seconds for 1 day:  1*24*60*60,
                remove calculated seconds from main timeLeft value*/
        $days = floor($timeLeft / 86400);
        $timeLeft = $timeLeft - $days * 86400;
               
                /*divide timeLeft value with number of seconds for 1 hr:  1*60*60,
                remove calculated seconds from main timeLeft value*/
        $hrs = floor($timeLeft / 3600);
        $timeLeft = $timeLeft - $hrs * 3600;
                 
                /*divide timeLeft value with number of seconds for 1 min:  1*60,
                remove calculated seconds from main timeLeft value */
        $mins = floor($timeLeft / 60);
               
                //what is left is seconds value
        $secs = $timeLeft - $mins * 60;
               
    }
        else
        {
                //return array with 0 values when there is not defined endTime
        return array(0, 0, 0, 0);
    }
       
        //return array with calculated values
    return array($days, $hrs, $mins, $secs);
}
		
?>