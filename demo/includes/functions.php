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

function validEmail($email)
{
    
	$pattern = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$";
      if (eregi($pattern, $email))
	  {
         return true;
      }
      else{
         return false;
      }
	  
	 
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




//Count user's referral
function getReferralCount($uid)
{
    $sql = mysql_query("SELECT COUNT(uid) as total FROM users WHERE referrer_id = $uid AND active=1");
	if(!mysql_num_rows($sql))
	{
	    return 0;
	}
	
	$row = mysql_fetch_object($sql);
	return $row->total;
}


function getPackages($selected = '')
{
 
    $sql = mysql_query("SELECT * FROM premium_packages WHERE active = 1");
	if(!mysql_num_rows($sql))
	{
	    return "<option value=\"0\">No Package Available</option>";
	}
    
     
   
  
      while($row = mysql_fetch_object($sql))
     {
        $type = $row->period_type;
		if($row->pid == $selected && !empty($selected))
		{
		   $opt .= "<option value=\"".$row->pid."\" selected=\"selected\">".$row->name." (".$row->expiry_period." $type)</option>";
		}else
		{
		   $opt .= "<option value=\"".$row->pid."\" >".$row->name." (".$row->expiry_period." $type)</option>";
		}
     }
	 
	 return $opt;
  
  
}


function calculateExpiry($pid)
{
    $sql = mysql_query("SELECT * FROM premium_packages WHERE pid = $pid AND active = 1");
	if(!mysql_num_rows($sql))
	{
	    return false;
	}
	
	$row = mysql_fetch_object($sql);
	$days = $row->expiry_period;
	$type = $row->period_type;
	$expiry = date("Y-m-d H:i:s",strtotime("+".$days." $type"));

	return $expiry;
}



function getPackageCost($pid)
{
    $sql = mysql_query("SELECT * FROM premium_packages WHERE pid = $pid AND active = 1");
	if(!mysql_num_rows($sql))
	{
	    return false;
	}
	
	$row = mysql_fetch_object($sql);
	
	return $row->cost;
}



function getPackageById($pid)
{
    $sql = mysql_query("SELECT * FROM premium_packages WHERE pid = $pid AND active = 1");
	if(!mysql_num_rows($sql))
	{
	    return false;
	}
	
	$row = mysql_fetch_object($sql);
	
	return $row->name;
}

function getPackageIdByName($name)
{
    $sql = mysql_query("SELECT * FROM premium_packages WHERE name = '$name'");
	if(!mysql_num_rows($sql))
	{
	    return false;
	}
	
	$row = mysql_fetch_object($sql);
	
	return $row->pid;
}


function getPremiumAccountPackage($id)
{
    $sql = mysql_query("SELECT * FROM premium_accounts WHERE uid = '$id'");
	if(!mysql_num_rows($sql))
	{
	    return false;
	}
	
	$row = mysql_fetch_object($sql);
	
	return stripslashes($row->package_name);  	
}


function getReferrerId($uid)
{
    $sql = mysql_query("SELECT referrer_id FROM users WHERE uid = $uid LIMIT 1");
	if(!mysql_num_rows($sql))
	{
	    return false;
	}
	
	$row = mysql_fetch_object($sql);
	if(empty($row->referrer_id))
	{
	    return false;
	}else
	{
	    return $row->referrer_id;
	}
	
	
	
}



function getUserById($id)
{
    $sql = mysql_query("SELECT email_address FROM users WHERE uid = $id");
	if(!mysql_num_rows($sql))
	{
	    return false;
	}
	
	$row = mysql_fetch_object($sql);
	return stripslashes($row->email_address);
}



function getUserIdByUsername($username)
{
 $sql = mysql_query("SELECT uid FROM users WHERE email_address = '$username' LIMIT 1");
	if(!mysql_num_rows($sql))
	{
	    return false;
	}
	
	$row = mysql_fetch_object($sql);
	return $row->uid;	
}


function getUserIdByEmail($email)
{
    $sql = mysql_query("SELECT uid FROM users WHERE email_address = '$email' LIMIT 1");
	if(!mysql_num_rows($sql))
	{
	    return false;
	}
	
	$row = mysql_fetch_object($sql);
	return $row->uid;
}



function getUsernameByEmail($email)
{
    $sql = mysql_query("SELECT username FROM users WHERE email_address = '$email' LIMIT 1");
	if(!mysql_num_rows($sql))
	{
	    return false;
	}
	
	$row = mysql_fetch_object($sql);
	return $row->username;
}


function getUserEmail($id)
{
    $sql = mysql_query("SELECT email_address FROM users WHERE uid = $id");
	if(!mysql_num_rows($sql))
	{
	    return false;
	}
	
	$row = mysql_fetch_object($sql);
	return stripslashes($row->email_address);
}




function getUploaderId($lid)
{
    $sql = mysql_query("SELECT uid FROM links WHERE id = $lid");
	if(!mysql_num_rows($sql))
	{
	    return 0;
	}
	
	$row = mysql_fetch_object($sql);
	return $row->uid;
}

function getUploaderIdByLinkCode($lid)
{
    $sql = mysql_query("SELECT uid FROM links WHERE `code` = '$lid'");
	if(!mysql_num_rows($sql))
	{
	    return 0;
	}
	
	$row = mysql_fetch_object($sql);
	return $row->uid;
}

//check user's status, 0 => inactive, 1 => active
function checkUserStatus($uid)
{
    $sql = mysql_query("SELECT active FROM users WHERE uid = $uid LIMIT 1");
	if(!mysql_num_rows($sql))
	{
	    return 0;
	}
	
	$row = mysql_fetch_object($sql);
	return $row->active;
}



//Premium user more functions
function getPremiumUserEmailById($uid)
{
    $sql = mysql_query("SELECT email_address FROM premium_accounts WHERE uid = $uid");
	if(!mysql_num_rows($sql))
	{
	    return 'None';
	}
	
	$row = mysql_fetch_object($sql);
	return stripslashes($row->email_address);
}




function getPremiumUserIdByEmail($email)
{
    $sql = mysql_query("SELECT uid FROM premium_accounts WHERE email_address = '$email' LIMIT 1");
	if(!mysql_num_rows($sql))
	{
	    return false;
	}
	
	$row = mysql_fetch_object($sql);
	return $row->uid;
}




function isMessageAllowed($senderId, $receiverId)
{
   if(mysql_num_rows(mysql_query("SELECT * FROM users WHERE uid = '$senderId' AND referrer_id = '$receiverId'")) || mysql_num_rows(mysql_query("SELECT * FROM users WHERE uid = '$receiverId' AND referrer_id = '$senderId'")))
			{
				    return true;
			}else
			{
			    return false;	
			}
}


function validURL($url)
{
    return preg_match("/\b(?:(?:https?):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $url);
}
	
	
function getToken($token)	
{
	    
		if(empty($token))
		return false;
		
		$sssql = mysql_query("SELECT * FROM valid_payments WHERE code = '$token' AND used = 0");
		if(!mysql_num_rows($sssql))
  	    return false;
		else
		return true;
				
	
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


function setEpc($campId, $network)
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




function getCashoutRequests($uid, $limit)
{
	  
  if(!empty($limit))
  $query = mysql_query("SELECT * FROM cashouts WHERE uid = $uid ORDER BY id DESC LIMIT $limit");
  else
  $query = mysql_query("SELECT * FROM cashouts WHERE uid = $uid ORDER BY id DESC");
  if(mysql_num_rows($query)){
  while($row = mysql_fetch_object($query))
  {
  
		  $hid = $row->id;
		  $amount = $row->amount;
		  $status = $row->status;
		  $method = $row->method;
		  $client_notes = nl2br($row->user_notes);
		  $admin_notes = nl2br($row->admin_notes);
		  $request_date = $row->request_date;
		  $payment_date = $row->payment_date;
		  $fee = $row->fee;
		  $priority = $row->priority;
  
			  if($payment_date != '0000-00-00 00:00:00')
			  {
				  $payment_date = date('d M, Y', strtotime($payment_date));	
			  }   
			  
			  $request_date = date('d M, Y', strtotime($request_date));	
  
	   $payHistory[] = array('id' => $hid,'cash' => $amount, 'status' => $status, 'method' => $method, 'client_notes' => $client_notes, 'admin_notes' => $admin_notes, 'date' => $request_date, 'payment_date' => $payment_date, 'fee' => $fee, 'priority' => $priority);
  }

      return $payHistory;

  }else
  {
      return false;	  
  }
  

	
}







function GetDays($sStartDate, $sEndDate){
  // Firstly, format the provided dates.
  // This function works best with YYYY-MM-DD
  // but other date formats will work thanks
  // to strtotime().
  $sStartDate = date("Y-m-d", strtotime($sStartDate));
  $sEndDate = date("Y-m-d", strtotime($sEndDate));

  // Start the variable off with the start date
  $aDays[] = $sStartDate;

  // Set a 'temp' variable, sCurrentDate, with
  // the start date - before beginning the loop
  $sCurrentDate = $sStartDate;

  // While the current date is less than the end date
  while($sCurrentDate < $sEndDate){
    // Add a day to the current date
    $sCurrentDate = date("Y-m-d", strtotime("+1 day", strtotime($sCurrentDate)));

    // Add this new day to the aDays array
    $aDays[] = $sCurrentDate;
  }

  // Once the loop has finished, return the
  // array of days.
  return $aDays;
}


function alreadyCreditedPremium($uid)
{
    $sql = mysql_query("SELECT uid FROM premium_accounts WHERE uid = '$uid' AND `credited` = '1' LIMIT 1");
	if(mysql_num_rows($sql))
    return true;
	else
	return false;
}


function getTotalEarnedHistoryAmount($uid)
{
    $sql = mysql_query("SELECT direct_credits + referral_credits as totalEarned FROM stats WHERE uid = $uid");	
	if(mysql_num_rows($sql))
	{
		
		$m = mysql_fetch_object($sql);
		return $m->totalEarned;
		
	}else
	{
	    return 0;	
	}
}


function getEarningsByGid($gid)
{
	$gid = makesafe($gid);
    $sql = mysql_query("SELECT SUM(credits) as totalEarned FROM gw_stats WHERE gid = $gid");	
	if(mysql_num_rows($sql))
	{
		
		$m = mysql_fetch_object($sql);
		return $m->totalEarned;
		
	}else
	{
	    return 0;	
	}
}



function getCountries($sel = '')
{

$array = array("AF" => "AFGHANISTAN", "AX" => "ALAND ISLANDS", "AL" => "ALBANIA", "DZ" => "ALGERIA", "AS" => "AMERICAN SAMOA", "AD" =>  "ANDORRA", "AO" => "ANGOLA", "AI" => "ANGUILLA", "AQ" => "ANTARCTICA", "AG" => "ANTIGUA AND BARBUDA", "AR" => "ARGENTINA", "AM" => "ARMENIA", "AW" => "ARUBA", "AU" => "AUSTRALIA", "AT" => "AUSTRIA", "AZ" => "AZERBAIJAN", "BS" => "BAHAMAS", "BH" => "BAHRAIN", "BD" => "BANGLADESH", "BB" => "BARBADOS", "BY" => "BELARUS", "BE" => "BELGIUM", "BZ" => "BELIZE", "BJ" => "BENIN", "BM" => "BERMUDA", "BT" => "BHUTAN", "BO" => "BOLIVIA, PLURINATIONAL STATE OF", "BA" => "BOSNIA AND HERZEGOVINA", "BW" => "BOTSWANA", "BV" => "BOUVET ISLAND", "BR" => "BRAZIL", "IO" => "BRITISH INDIAN OCEAN TERRITORY", "BN" => "BRUNEI DARUSSALAM", "BG" => "BULGARIA", "BF" => "BURKINA FASO", "BI" => "BURUNDI", "KH" => "CAMBODIA", "CM" => "CAMEROON", "CA" => "CANADA", "CV" => "CAPE VERDE", "KY" => "CAYMAN ISLANDS", "CF" => "CENTRAL AFRICAN REPUBLIC", "TD" => "CHAD", "CL" => "CHILE", "CN" => "CHINA", "CX" => "CHRISTMAS ISLAND", "CC" => "COCOS (KEELING) ISLANDS", "CO" => "COLOMBIA", "KM" => "COMOROS", "CG" => "CONGO", "CD" => "CONGO, THE DEMOCRATIC REPUBLIC OF THE", "CK" => "COOK ISLANDS", "CR" => "COSTA RICA", "CI" => "CÔTE D'IVOIRE", "HR" => "CROATIA", "CU" => "CUBA", "CY" => "CYPRUS", "CZ" =>  "CZECH REPUBLIC", "DK" => "DENMARK", "DJ" => "DJIBOUTI", "DM" => "DOMINICA", "DO" => "DOMINICAN REPUBLIC", "EC" => "ECUADOR", "EG" => "EGYPT", "SV" => "EL SALVADOR", "GQ" => "EQUATORIAL GUINEA", "ER" => "ERITREA", "EE" => "ESTONIA", "ET" => "ETHIOPIA", "FK" => "FALKLAND ISLANDS (MALVINAS)", "FO" => "FAROE ISLANDS", "FJ" => "FIJI", "FI" => "FINLAND", "FR" => "FRANCE", "GF" => "FRENCH GUIANA", "PF" => "FRENCH POLYNESIA", "TF" => "FRENCH SOUTHERN TERRITORIES", "GA" => "GABON", "GM" => "GAMBIA", "GE" => "GEORGIA", "DE" => "GERMANY", "GH" => "GHANA", "GI" => "GIBRALTAR", "GR" => "GREECE", "GL" => "GREENLAND", "GD" => "GRENADA", "GP" => "GUADELOUPE", "GU" => "GUAM", "GT" => "GUATEMALA", "GG" => "GUERNSEY", "GN" => "GUINEA", "GW" => "GUINEA-BISSAU", "GY" => "GUYANA", "HT" => "HAITI", "HM" => "HEARD ISLAND AND MCDONALD ISLANDS", "VA" => "HOLY SEE (VATICAN CITY STATE)", "HN" => "HONDURAS", "HK" => "HONG KONG", "HU" => "HUNGARY", "IS" => "ICELAND", "IN" => "INDIA", "ID" => "INDONESIA", "IR" => "IRAN, ISLAMIC REPUBLIC OF", "IQ" => "IRAQ", "IE" => "IRELAND", "IM" => "ISLE OF MAN", "IL" => "ISRAEL", "IT" => "ITALY", "JM" => "JAMAICA", "JP" => "JAPAN", "JE" =>  "JERSEY", "JO" => "JORDAN", "KZ" => "KAZAKHSTAN", "KE" => "KENYA", "KI" => "KIRIBATI", "KP" => "KOREA, DEMOCRATIC PEOPLE'S REPUBLIC OF", "KR" => "KOREA, REPUBLIC OF", "KW" => "KUWAIT", "KG" => "KYRGYZSTAN", "LA" => "LAO PEOPLE'S DEMOCRATIC REPUBLIC", "LV" => "LATVIA", "LB" => "LEBANON", "LS" => "LESOTHO", "LR" => "LIBERIA", "LY" => "LIBYAN ARAB JAMAHIRIYA", "LI" => "LIECHTENSTEIN", "LT" => "LITHUANIA", "LU" => "LUXEMBOURG", "MO" => "MACAO", "MK" => "MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF", "MG" => "MADAGASCAR", "MW" => "MALAWI", "MY" => "MALAYSIA", "MV" => "MALDIVES", "ML" => "MALI", "MT" => "MALTA", "MH" =>  "MARSHALL ISLANDS", "MQ" => "MARTINIQUE", "MR" => "MAURITANIA", "MU" => "MAURITIUS", "YT" => "MAYOTTE", "MX" => "MEXICO", "FM" => "MICRONESIA, FEDERATED STATES OF", "MD" => "MOLDOVA, REPUBLIC OF", "MC" => "MONACO", "MN" => "MONGOLIA", "ME" => "MONTENEGRO", "MS" => "MONTSERRAT", "MA" => "MOROCCO", "MZ" => "MOZAMBIQUE", "MM" => "MYANMAR", "NA" => "NAMIBIA", "NR" => "NAURU", "NP" => "NEPAL", "NL" => "NETHERLANDS", "AN" => "NETHERLANDS ANTILLES", "NC" => "NEW CALEDONIA", "NZ" => "NEW ZEALAND", "NI" => "NICARAGUA", "NE" => "NIGER", "NG" => "NIGERIA", "NU" => "NIUE", "NF" => "NORFOLK ISLAND", "MP" => "NORTHERN MARIANA ISLANDS", "NO" => "NORWAY", "OM" => "OMAN", "PK" => "PAKISTAN", "PW" => "PALAU", "PS" => "PALESTINIAN TERRITORY, OCCUPIED", "PA" => "PANAMA", "PG" => "PAPUA NEW GUINEA", "PY" => "PARAGUAY", "PE" => "PERU", "PH" => "PHILIPPINES", "PN" => "PITCAIRN", "PL" => "POLAND", "PT" => "PORTUGAL", "PR" => "PUERTO RICO", "QA" => "QATAR", "RE" => "REUNION", "RO" => "ROMANIA", "RU" => "RUSSIAN FEDERATION", "RW" => "RWANDA", "BL" => "SAINT BARTHÉLEMY", "SH" => "SAINT HELENA, ASCENSION AND TRISTAN DA CUNHA", "KN" => "SAINT KITTS AND NEVIS", "LC" => "SAINT LUCIA", "MF" => "SAINT MARTIN", "PM" => "SAINT PIERRE AND MIQUELON", "VC" => "SAINT VINCENT AND THE GRENADINES", "WS" => "SAMOA", "SM" => "SAN MARINO", "ST" => "SAO TOME AND PRINCIPE", "SA" => "SAUDI ARABIA", "SN" => "SENEGAL", "RS" => "SERBIA", "SC" => "SEYCHELLES", "SL" => "SIERRA LEONE", "SG" => "SINGAPORE", "SK" => "SLOVAKIA", "SI" => "SLOVENIA", "SB" => "SOLOMON ISLANDS", "SO" => "SOMALIA", "ZA" => "SOUTH AFRICA", "GS" => "SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS", "ES" => "SPAIN", "LK" => "SRI LANKA", "SD" => "SUDAN", "SR" => "SURINAME", "SJ" => "SVALBARD AND JAN MAYEN", "SZ" => "SWAZILAND", "SE" => "SWEDEN", "CH" => "SWITZERLAND", "SY" => "SYRIAN ARAB REPUBLIC", "TW" => "TAIWAN, PROVINCE OF CHINA", "TJ" => "TAJIKISTAN", "TZ" => "TANZANIA, UNITED REPUBLIC OF", "TH" => "THAILAND", "TL" => "TIMOR-LESTE", "TG" => "TOGO", "TK" => "TOKELAU", "TO" => "TONGA", "TT" => "TRINIDAD AND TOBAGO", "TN" => "TUNISIA", "TR" => "TURKEY", "TM" => "TURKMENISTAN", "TC" => "TURKS AND CAICOS ISLANDS", "TV" => "TUVALU", "UG" => "UGANDA", "UA" => "UKRAINE", "AE" => "UNITED ARAB EMIRATES", "GB" => "UNITED KINGDOM", "US" => "UNITED STATES", "UM" => "UNITED STATES MINOR OUTLYING ISLANDS", "UY" => "URUGUAY", "UZ" => "UZBEKISTAN", "VU" => "VANUATU", "VE" => "VENEZUELA, BOLIVARIAN REPUBLIC OF", "VN" => "VIET NAM", "VG" => "VIRGIN ISLANDS, BRITISH", "VI" => "VIRGIN ISLANDS, U.S.", "WF" =>  "WALLIS AND FUTUNA", "EH" => "WESTERN SAHARA", "YE" => "YEMEN", "ZM" => "ZAMBIA", "ZW" => "ZIMBABWE");
$countries = "";


foreach($array as $code => $name)
{

 if(!empty($sel))
	{
        
		
		if(!is_array($sel)){
		
		if($sel == $code)
			$countries .= '<option value="'.$code.'" selected="selected">'.$name.'</option>';
		else
	    $countries .= '<option value="'.$code.'">'.$name.'</option>';
		

		}else
		{

	
		  if(in_array($code, $sel))
		  $countries .= '<option value="'.$code.'" selected="selected">'.$name.'</option>';
		  else
		  $countries .= '<option value="'.$code.'">'.$name.'</option>';
			
		}
		
		
		
	}else
	{
	    $countries .= '<option value="'.$code.'">'.$name.'</option>';
	}

}

return $countries;
}

	
function countrUnreadMessages($user)
{
    $user = makesafe($user);
	$sql = mysql_query("SELECT COUNT(msg_id) as `total` FROM messages WHERE receiver = '$user' AND `read` = 0");
	if(mysql_num_rows($sql))
	{
		
		$r = mysql_fetch_object($sql);
		return $r->total;
		
	}else{
	return 0;
	}
}
	
function getLinkIdByLinkCode($code)
{
	
    $code = makesafe($code);
	$sql = mysql_query("SELECT id  FROM links WHERE code = '$code'");
	if(mysql_num_rows($sql))
	{
		
		$r = mysql_fetch_object($sql);
		return $r->id;
		
	}else{
	return false;
	}	
}	

function getLinkCodeById($fid)
{
	
    $code = makesafe($code);
	$sql = mysql_query("SELECT code  FROM links WHERE id = '$fid'");
	if(mysql_num_rows($sql))
	{
		
		$r = mysql_fetch_object($sql);
		return $r->code;
		
	}else{
	return false;
	}	
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

		
		
function getLatestDownloads($uid, $limit = 3)
{


	$ldsql = mysql_query("SELECT id, date, credits, country, file_id FROM offer_process WHERE uid = '$uid' AND status = '1' AND DATE(date) = CURDATE() ORDER BY id DESC LIMIT $limit");
	
	if(mysql_num_rows($ldsql))
	{
	    while($lr = mysql_fetch_object($ldsql))
		{
		    $_date =strtotime($lr->date);
			$_country = $lr->country;
			$_credits = $lr->credits;	
			$file_id  = $lr->file_id;
			$_arr[] = array('date' => date("d-m-Y H:i", $_date), 'time' => date("H:i", $_date), 'country' => $_country, 'credits' => $_credits, 'stamp' => $_date, 'file_id' => $file_id);
		}	
	}
	

$arr = array_slice($_arr, 0, $limit);
	return $arr;

	
	
}



function getMyRank($uid)
{
   
    //Get my rank this month
    $sql = mysql_query("SELECT SUM(s.credits) as credits, u.uid as uid FROM users as u INNER JOIN  earnings_log as s ON u.uid = s.uid WHERE DATE(`s`.`date`) = CURDATE()  GROUP BY uid ORDER BY credits DESC LIMIT 100");	
	
	if(mysql_num_rows($sql))
	{
	     $x = 1;
	     while($r = mysql_fetch_object($sql)){
			 
			 $credits = $r->credits;
			 $ranks[$x] = $credits;
		 
		     if($r->uid == $uid)
			 {
			    $myRank = $x;
				$upper = $ranks[$x-1]+0.01;
				$goal = $upper - $credits;
				break;
			 }
			 
			 $x++;
		 
		 }
		 
	 return array('rank' => $myRank, 'goal' => $goal);
		
	    	
	}
	
}

function curl_get_file_contents($URL)
    {
        $c = curl_init();
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_URL, $URL);
        $contents = curl_exec($c);
        curl_close($c);

        if ($contents) return $contents;
            else return FALSE;
    }


function  sendPostback($uid, $offer_id, $status, $campid, $network, $payout = 0,  $sid = "", $sid2 ="", $sid3 = "", $sid4 = "", $sid5 = "")
{
    $sql = mysql_query("SELECT pb_type, url FROM pb_settings WHERE uid = '$uid'");	
	if(!mysql_num_rows($sql))
	return;
	
	
	$row = mysql_fetch_array($sql);
	$type = $row['pb_type'];
	$url = stripslashes($row['url']);
	

	
	if(empty($url) || !validURL($url))
	return;
	

	
	$url = str_ireplace("%CAMPID%", $offer_id, $url);
	
	$url = str_ireplace("%STATUS%", $status, $url);
	
	$url = str_ireplace("%SID%", $sid, $url);
	$url = str_ireplace("%SID2%", $sid2, $url);
	$url = str_ireplace("%SID3%", $sid3, $url);
	$url = str_ireplace("%SID4%", $sid4, $url);
	$url = str_ireplace("%SID5%", $sid5, $url);	
	$url = str_ireplace("%PAYOUT%", $payout, $url);					
	
	
   
	
	
	if(curl_get_file_contents($url))
	{
		
		@mysql_query("INSERT INTO pb_sent VALUES (NULL, '$uid', '$campid', '$network', '$url', '$status', NOW())");
		return true;
		
	}
	
	
}
		
function isOfferRejected($campid, $network,  $uid, $country)
{

   if(mysql_num_rows(mysql_query("SELECT id FROM user_rejected_offers WHERE uid = '$uid' AND campid = '$campid' AND network = '$network' AND country_code = '$country'")))
   return "1";
   else
   return "0";	
}




function disableOffer($uid, $campid, $network, $country)
{
	

    if(mysql_query("INSERT INTO user_rejected_offers(id, uid, country_code, campid, network) VALUES (NULL, '$uid', '$country', '$campid', '$network')")){		

	return true;
	}else
	return false;
		

}


function enableOffer($uid, $campid, $network, $country)
{
	

    if(mysql_query("DELETE FROM  user_rejected_offers WHERE uid  = '$uid' AND country_code =  '$country' AND campid =  '$campid' AND network = '$network'"))
	return true;
	else
	return false;
	
}


		
function getGatewayNameByGid($gid)
{
	$gid = makesafe($gid);
    $sql = mysql_query("SELECT name FROM gateways WHERE gid = $gid");	
	if(mysql_num_rows($sql))
	{
		
		$m = mysql_fetch_object($sql);
		return $m->name;
		
	}else
	{
	    return 0;	
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


function GetDays2($sStartDate, $sEndDate){
  // Firstly, format the provided dates.
  // This function works best with YYYY-MM-DD
  // but other date formats will work thanks
  // to strtotime().
  $sStartDate = date("Y-m-d", strtotime($sStartDate));
  $sEndDate = date("Y-m-d", strtotime($sEndDate));

  // Start the variable off with the start date
  $aDays[] = $sStartDate;

  // Set a 'temp' variable, sCurrentDate, with
  // the start date - before beginning the loop
  $sCurrentDate = $sStartDate;

  // While the current date is less than the end date
  while($sCurrentDate < $sEndDate){
    // Add a day to the current date
    $sCurrentDate = date("Y-m-d", strtotime("+1 day", strtotime($sCurrentDate)));

    // Add this new day to the aDays array
    $aDays[] = $sCurrentDate;
  }

  // Once the loop has finished, return the
  // array of days.
  return $aDays;
}




function includePrivate($id)
{
    $sql = mysql_query("SELECT private_offers FROM users WHERE uid = $id");
	if(!mysql_num_rows($sql))
	{
	    return false;
	}
	
	$row = mysql_fetch_object($sql);
	return stripslashes($row->private_offers);
}

		
?>