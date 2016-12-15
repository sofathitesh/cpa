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


function toggleStatus($status)
{
   if($status == 1)
    {
	return 'Active';
	}else
	{
	return 'Inactive';
	}
}


function selection($sel = '')
{
    
	    if($sel == 1)
		$opts = '<option value="1" selected="selected">Active</option><option value="0">Inactive</option>'; 
		else
        $opts = '<option value="0" selected="selected">Inactive</option><option value="1">Active</option>'; 
	return $opts;
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


function getUserId($username)
{
    $sql = mysql_query("SELECT uid FROM users WHERE email_address = '$username'");
	if(!mysql_num_rows($sql))
	{
	    return 0;
	}
	
	$row = mysql_fetch_object($sql);
	return stripslashes($row->uid);
}


function getPackage($id)
{
    $sql = mysql_query("SELECT name FROM premium_packages WHERE pid = $id");
	if(!mysql_num_rows($sql))
	{
	    return false;
	}
	
	$row = mysql_fetch_object($sql);
	return stripslashes($row->name);
}




function selectPaymentStatus($sel = '')
{
	if($sel == "Pending")
	$opts = '<option value="Pending" selected="selected">Pending</option><option value="Locked">Locked</option><option value="Complete">Complete</option><option value="Cancelled">Cancelled</option>'; 
	elseif($sel == "Locked")
	$opts = '<option value="Pending">Pending</option><option value="Locked" selected="selected">Locked</option><option value="Complete">Complete</option><option value="Cancelled">Cancelled</option>'; 
	elseif($sel == "Complete")
	$opts = '<option value="Pending">Pending</option><option value="Locked">Locked</option><option value="Complete" selected="selected">Complete</option><option value="Cancelled">Cancelled</option>';
	elseif($sel == "Cancelled")
	$opts = '<option value="Pending">Pending</option><option value="Locked">Locked</option><option value="Complete">Complete</option><option value="Cancelled" selected="selected">Cancelled</option>';
	return $opts;
}





function datePicker($date = '', $m = '')
{

 
    $m_days = date('t');
	$m_day = date('d');
	$m_hour = date('H');
	$m_month = date('m');
	$m_minutes = date('i');
	$m_seconds = date('s');
	
	if(!empty($date) && $m == '')
	{
	  
	    $m_days = date('t',$date);
	    $m_day = date('d',$date);
	    $m_hour = date('H',$date);
	    $m_month = date('m',$date);
	    $m_minutes = date('i',$date);
	    $m_seconds = date('s',$date);
	
	}
	
	if($m != '')
	{
	
       //$m_month = str_replace("0","",$m);
	   // $date = mktime(date('H',$date), date('i',$date), date('s',$date), $m, date('d',$date), date('Y',$date));
	   $date = mktime(0,0,0, '0'.$m, 1, date('Y'));
	    $m_days = date('t',$date);
	   $m_day = date('d',$date);
	    $m_hour = date('H',$date);
	    $m_month = date('m',$date);
	    $m_minutes = date('i',$date);
	    $m_seconds = date('s',$date);
		
	}
	
	
	
	
	//Get Days Options
	$i = 0;
	while($i<$m_days)
	{
	    $i++;
		if($i < 10)
		{
		  $i ='0'.$i;
		}
		
		
		if($i == $m_day)
		{
	       $day .= "<option value=\"$i\" selected=\"selected\">$i</option>";   
		}else
		{
  	       $day .= "<option value=\"$i\">$i</option>";   
		}
	}
	
	
	//Get Month Options
	$i = 0;
	$m = 0;
	$month = '';
	 $months = array("","Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
	while($i<12)
	{
	   
	    $i++; $m++;
		if($m < 10)
		{
		  $m ='0'.$m;
		}	
		
		
		
		if($i == $m_month)
		{  
		
	       $month .= "<option value=\"$m\" selected=\"selected\">$months[$i]</option>";   
		}else
		{
  	       $month .= "<option value=\"$m\">$months[$i]</option>";   
		}
	}
	
	
    //Get Hours Options
	$i = 0;
	while($i<=23)
	{
		if($i < 10)
		{
		  $i ='0'.$i;
		}	   

		if($i == $m_hour)
		{
	       $hour .= "<option value=\"$i\" selected=\"selected\">$i</option>";   
		}else
		{
  	       $hour .= "<option value=\"$i\">$i</option>";   
		}
		
	    $i++;		
	}
	
	
	//Get Minutes Options
	$i = 0;
	while($i<=59)
	{
		if($i < 10)
		{
		  $i ='0'.$i;
		}	
	    
		if($i == $m_minutes)
		{
	       $minutes .= "<option value=\"$i\" selected=\"selected\">$i</option>";   
		}else
		{
  	       $minutes .= "<option value=\"$i\">$i</option>";   
		}
		
		$i++;
	}
	
	
	//Get Seconds Options
	$i = 0;
	while($i<=59)
	{
		if($i < 10)
		{
		  $i ='0'.$i;
		}	
	    
		if($i == $m_seconds)
		{
	       $seconds .= "<option value=\"$i\" selected=\"selected\">$i</option>";   
		}else
		{
  	       $seconds .= "<option value=\"$i\">$i</option>";   
		}
		
		$i++;
	}	
	
	
	$dateArr = array();
	$dateArr['days'] = $day;
	$dateArr['months'] = $month;
	$dateArr['hours'] = $hour;
	$dateArr['minutes'] = $minutes;
	$dateArr['seconds'] = $seconds;				
	
	return $dateArr;
	
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
        
		if($row->pid == $selected && !empty($selected))
		{
		   $opt .= "<option value=\"".$row->pid."\" selected=\"selected\">".$row->name."</option>";
		}else
		{
		   $opt .= "<option value=\"".$row->pid."\" >".$row->name."</option>";
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

function getAlertPayEmail($uid)
{

    $sql = mysql_query("SELECT alertpay_email FROM users WHERE uid = $uid");
	if(!mysql_num_rows($sql))
	{
	    return 'None';
	}
	
	$row = mysql_fetch_object($sql);
	return stripslashes($row->alertpay_email);

}


function getCountries($sel)
{

$array = array("AF" => "AFGHANISTAN", "AX" => "ALAND ISLANDS", "AL" => "ALBANIA", "DZ" => "ALGERIA", "AS" => "AMERICAN SAMOA", "AD" =>  "ANDORRA", "AO" => "ANGOLA", "AI" => "ANGUILLA", "AQ" => "ANTARCTICA", "AG" => "ANTIGUA AND BARBUDA", "AR" => "ARGENTINA", "AM" => "ARMENIA", "AW" => "ARUBA", "AU" => "AUSTRALIA", "AT" => "AUSTRIA", "AZ" => "AZERBAIJAN", "BS" => "BAHAMAS", "BH" => "BAHRAIN", "BD" => "BANGLADESH", "BB" => "BARBADOS", "BY" => "BELARUS", "BE" => "BELGIUM", "BZ" => "BELIZE", "BJ" => "BENIN", "BM" => "BERMUDA", "BT" => "BHUTAN", "BO" => "BOLIVIA, PLURINATIONAL STATE OF", "BA" => "BOSNIA AND HERZEGOVINA", "BW" => "BOTSWANA", "BV" => "BOUVET ISLAND", "BR" => "BRAZIL", "IO" => "BRITISH INDIAN OCEAN TERRITORY", "BN" => "BRUNEI DARUSSALAM", "BG" => "BULGARIA", "BF" => "BURKINA FASO", "BI" => "BURUNDI", "KH" => "CAMBODIA", "CM" => "CAMEROON", "CA" => "CANADA", "CV" => "CAPE VERDE", "KY" => "CAYMAN ISLANDS", "CF" => "CENTRAL AFRICAN REPUBLIC", "TD" => "CHAD", "CL" => "CHILE", "CN" => "CHINA", "CX" => "CHRISTMAS ISLAND", "CC" => "COCOS (KEELING) ISLANDS", "CO" => "COLOMBIA", "KM" => "COMOROS", "CG" => "CONGO", "CD" => "CONGO, THE DEMOCRATIC REPUBLIC OF THE", "CK" => "COOK ISLANDS", "CR" => "COSTA RICA", "CI" => "CÔTE D'IVOIRE", "HR" => "CROATIA", "CU" => "CUBA", "CY" => "CYPRUS", "CZ" =>  "CZECH REPUBLIC", "DK" => "DENMARK", "DJ" => "DJIBOUTI", "DM" => "DOMINICA", "DO" => "DOMINICAN REPUBLIC", "EC" => "ECUADOR", "EG" => "EGYPT", "SV" => "EL SALVADOR", "GQ" => "EQUATORIAL GUINEA", "ER" => "ERITREA", "EE" => "ESTONIA", "ET" => "ETHIOPIA", "FK" => "FALKLAND ISLANDS (MALVINAS)", "FO" => "FAROE ISLANDS", "FJ" => "FIJI", "FI" => "FINLAND", "FR" => "FRANCE", "GF" => "FRENCH GUIANA", "PF" => "FRENCH POLYNESIA", "TF" => "FRENCH SOUTHERN TERRITORIES", "GA" => "GABON", "GM" => "GAMBIA", "GE" => "GEORGIA", "DE" => "GERMANY", "GH" => "GHANA", "GI" => "GIBRALTAR", "GR" => "GREECE", "GL" => "GREENLAND", "GD" => "GRENADA", "GP" => "GUADELOUPE", "GU" => "GUAM", "GT" => "GUATEMALA", "GG" => "GUERNSEY", "GN" => "GUINEA", "GW" => "GUINEA-BISSAU", "GY" => "GUYANA", "HT" => "HAITI", "HM" => "HEARD ISLAND AND MCDONALD ISLANDS", "VA" => "HOLY SEE (VATICAN CITY STATE)", "HN" => "HONDURAS", "HK" => "HONG KONG", "HU" => "HUNGARY", "IS" => "ICELAND", "IN" => "INDIA", "ID" => "INDONESIA", "IR" => "IRAN, ISLAMIC REPUBLIC OF", "IQ" => "IRAQ", "IE" => "IRELAND", "IM" => "ISLE OF MAN", "IL" => "ISRAEL", "IT" => "ITALY", "JM" => "JAMAICA", "JP" => "JAPAN", "JE" =>  "JERSEY", "JO" => "JORDAN", "KZ" => "KAZAKHSTAN", "KE" => "KENYA", "KI" => "KIRIBATI", "KP" => "KOREA, DEMOCRATIC PEOPLE'S REPUBLIC OF", "KR" => "KOREA, REPUBLIC OF", "KW" => "KUWAIT", "KG" => "KYRGYZSTAN", "LA" => "LAO PEOPLE'S DEMOCRATIC REPUBLIC", "LV" => "LATVIA", "LB" => "LEBANON", "LS" => "LESOTHO", "LR" => "LIBERIA", "LY" => "LIBYAN ARAB JAMAHIRIYA", "LI" => "LIECHTENSTEIN", "LT" => "LITHUANIA", "LU" => "LUXEMBOURG", "MO" => "MACAO", "MK" => "MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF", "MG" => "MADAGASCAR", "MW" => "MALAWI", "MY" => "MALAYSIA", "MV" => "MALDIVES", "ML" => "MALI", "MT" => "MALTA", "MH" =>  "MARSHALL ISLANDS", "MQ" => "MARTINIQUE", "MR" => "MAURITANIA", "MU" => "MAURITIUS", "YT" => "MAYOTTE", "MX" => "MEXICO", "FM" => "MICRONESIA, FEDERATED STATES OF", "MD" => "MOLDOVA, REPUBLIC OF", "MC" => "MONACO", "MN" => "MONGOLIA", "ME" => "MONTENEGRO", "MS" => "MONTSERRAT", "MA" => "MOROCCO", "MZ" => "MOZAMBIQUE", "MM" => "MYANMAR", "NA" => "NAMIBIA", "NR" => "NAURU", "NP" => "NEPAL", "NL" => "NETHERLANDS", "AN" => "NETHERLANDS ANTILLES", "NC" => "NEW CALEDONIA", "NZ" => "NEW ZEALAND", "NI" => "NICARAGUA", "NE" => "NIGER", "NG" => "NIGERIA", "NU" => "NIUE", "NF" => "NORFOLK ISLAND", "MP" => "NORTHERN MARIANA ISLANDS", "NO" => "NORWAY", "OM" => "OMAN", "PK" => "PAKISTAN", "PW" => "PALAU", "PS" => "PALESTINIAN TERRITORY, OCCUPIED", "PA" => "PANAMA", "PG" => "PAPUA NEW GUINEA", "PY" => "PARAGUAY", "PE" => "PERU", "PH" => "PHILIPPINES", "PN" => "PITCAIRN", "PL" => "POLAND", "PT" => "PORTUGAL", "PR" => "PUERTO RICO", "QA" => "QATAR", "RE" => "REUNION", "RO" => "ROMANIA", "RU" => "RUSSIAN FEDERATION", "RW" => "RWANDA", "BL" => "SAINT BARTHÉLEMY", "SH" => "SAINT HELENA, ASCENSION AND TRISTAN DA CUNHA", "KN" => "SAINT KITTS AND NEVIS", "LC" => "SAINT LUCIA", "MF" => "SAINT MARTIN", "PM" => "SAINT PIERRE AND MIQUELON", "VC" => "SAINT VINCENT AND THE GRENADINES", "WS" => "SAMOA", "SM" => "SAN MARINO", "ST" => "SAO TOME AND PRINCIPE", "SA" => "SAUDI ARABIA", "SN" => "SENEGAL", "RS" => "SERBIA", "SC" => "SEYCHELLES", "SL" => "SIERRA LEONE", "SG" => "SINGAPORE", "SK" => "SLOVAKIA", "SI" => "SLOVENIA", "SB" => "SOLOMON ISLANDS", "SO" => "SOMALIA", "ZA" => "SOUTH AFRICA", "GS" => "SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS", "ES" => "SPAIN", "LK" => "SRI LANKA", "SD" => "SUDAN", "SR" => "SURINAME", "SJ" => "SVALBARD AND JAN MAYEN", "SZ" => "SWAZILAND", "SE" => "SWEDEN", "CH" => "SWITZERLAND", "SY" => "SYRIAN ARAB REPUBLIC", "TW" => "TAIWAN, PROVINCE OF CHINA", "TJ" => "TAJIKISTAN", "TZ" => "TANZANIA, UNITED REPUBLIC OF", "TH" => "THAILAND", "TL" => "TIMOR-LESTE", "TG" => "TOGO", "TK" => "TOKELAU", "TO" => "TONGA", "TT" => "TRINIDAD AND TOBAGO", "TN" => "TUNISIA", "TR" => "TURKEY", "TM" => "TURKMENISTAN", "TC" => "TURKS AND CAICOS ISLANDS", "TV" => "TUVALU", "UG" => "UGANDA", "UA" => "UKRAINE", "AE" => "UNITED ARAB EMIRATES", "GB" => "UNITED KINGDOM", "US" => "UNITED STATES", "UM" => "UNITED STATES MINOR OUTLYING ISLANDS", "UY" => "URUGUAY", "UZ" => "UZBEKISTAN", "VU" => "VANUATU", "VE" => "VENEZUELA, BOLIVARIAN REPUBLIC OF", "VN" => "VIET NAM", "VG" => "VIRGIN ISLANDS, BRITISH", "VI" => "VIRGIN ISLANDS, U.S.", "WF" =>  "WALLIS AND FUTUNA", "EH" => "WESTERN SAHARA", "YE" => "YEMEN", "ZM" => "ZAMBIA", "ZW" => "ZIMBABWE");
$countries = "";
foreach($array as $code => $name)
{  



    if(in_array($code,$sel) || (in_array("UK", $sel) && $code == 'GB'))
	{
	    $countries .= '<option value="'.$code.'" selected="selected">'.$name.'</option>';
	}else
	{
	    $countries .= '<option value="'.$code.'">'.$name.'</option>';
	}
	


}

return $countries;
}




function convertFileSize($size)
{
  $size = $size/1024;	
	 if($size < 1024)
	 {
  		$size = sprintf("%.2f", $size)."KB";  
	 }else if($size/1024 < 1024)
	 {
  		$size = $size / 1024;
  		$size = sprintf("%.2f", $size) . "MB";
	 }else if(size/1024/1024 < 1024)
	 {
  		 $size = $size / 1024 / 1024;  
  		 $size = sprintf("%.2f", $size) . "GB";
 	 }else if($size / 1024 / 1024 / 1024 < 1024)
	 {
		 $size = $size / 1024 / 1024 / 1024;
		 $size = sprintf("%.2f", $size) . "TB";
	 }
 
	  return $size;     

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



function getNetworks($sel = '')
{


   $sql = mysql_query("SELECT * FROM networks WHERE active = 1 ORDER BY name ASC");
   if(!mysql_num_rows($sql))
			return;
		while($row = mysql_fetch_object($sql))
		{
   	 $array[] = $row->name; //array('Adscendmedia', 'Ironoffers', 'BlueTrackMedia', 'MediaWhiz', 'Epic', 'RevenueStreet');		
 	}	
			
	
		foreach($array as $name)
		{
		
				if($sel == $name)
				{
					$cats .= '<option value="'.$name.'" selected="selected">'.$name.'</option>';
				}else
				{
					$cats .= '<option value="'.$name.'">'.$name.'</option>';
				}
			
		
		}
		
		return $cats;
}


function getBanScopeOpts($sel = '')
{

	    $array = array('Website', 'Authentication');
		foreach($array as $name)
		{
		
				if($sel == $name)
				{
					$opts .= '<option value="'.$name.'" selected="selected">'.$name.'</option>';
				}else
				{
					$opts .= '<option value="'.$name.'">'.$name.'</option>';
				}
			
		
		}
		
		return $opts;
	
}


function checkUserStatusById($uid)
{
    $sql = mysql_query("SELECT active FROM users WHERE uid = $uid");
	if(!mysql_num_rows($sql))
	{
	    return 'None';
	}
	
	$row = mysql_fetch_object($sql);
	return stripslashes($row->active);
}

function getEmailById($uid)
{
    $sql = mysql_query("SELECT email_address FROM users WHERE uid = $uid");
	if(!mysql_num_rows($sql))
	{
	    return 'None';
	}
	
	$row = mysql_fetch_object($sql);
	return stripslashes($row->email_address);
}


function getAllFilesSizeByUserId($uid)
{
    $sql = mysql_query("SELECT SUM(filesize) as totalSize FROM files WHERE uid = $uid");
	if(!mysql_num_rows($sql))
	{
	    return 0;
	}
	
	$row = mysql_fetch_object($sql);
	return stripslashes($row->totalSize);
	
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


//Get link uploader id
function getUploaderId($lid)
{
    $sql = mysql_query("SELECT uid FROM files WHERE id = $lid");
	if(!mysql_num_rows($sql))
	{
	    return 0;
	}
	
	$row = mysql_fetch_object($sql);
	return $row->uid;
}


function getFilenameById($id)
{
		$sssql = mysql_query("SELECT * FROM files WHERE id = '$id'");
		if(!mysql_num_rows($sssql))
  	    return false;
		else
		$row = mysql_fetch_object($sssql);
		return $row->filename;
}


function getMirror($id)
{
    $sql = mysql_query("SELECT domain FROM mirrors WHERE id = $id");
	if(!mysql_num_rows($sql))
	{
	    return false;
	}
	
	$row = mysql_fetch_object($sql);
	return stripslashes($row->domain);
}





function getOfferByCampaign($camp, $network)
{
	mysql_query("SET character_set_results=utf8");
    mysql_query("SET character_set_client=utf8");
    mysql_query("SET character_set_connection=utf8");	
    $sql = mysql_query("SELECT * FROM offers WHERE campaign_id = '$camp' AND network = '$network'");
	if(!mysql_num_rows($sql))
	{
	    return false;
	}
	
	$row = mysql_fetch_object($sql);
	
	return stripslashes($row->name);
}


function getUserIpById($id)
{
    $sql = mysql_query("SELECT ip_address FROM users WHERE uid = $id");
	if(!mysql_num_rows($sql))
	{
	    return false;
	}
	
	$row = mysql_fetch_object($sql);
	return stripslashes($row->ip_address);
}


function getUserEmailById($id)
{
    $sql = mysql_query("SELECT email_address FROM users WHERE uid = $id");
	if(!mysql_num_rows($sql))
	{
	    return false;
	}
	
	$row = mysql_fetch_object($sql);
	return stripslashes($row->email_address);
}


function getCodeByCountryName($name)
{
$countries = array("AF" => "AFGHANISTAN", "AX" => "ALAND ISLANDS", "AL" => "ALBANIA", "DZ" => "ALGERIA", "AS" => "AMERICAN SAMOA", "AD" =>  "ANDORRA", "AO" => "ANGOLA", "AI" => "ANGUILLA", "AQ" => "ANTARCTICA", "AG" => "ANTIGUA AND BARBUDA", "AR" => "ARGENTINA", "AM" => "ARMENIA", "AW" => "ARUBA", "AU" => "AUSTRALIA", "AT" => "AUSTRIA", "AZ" => "AZERBAIJAN", "BS" => "BAHAMAS", "BH" => "BAHRAIN", "BD" => "BANGLADESH", "BB" => "BARBADOS", "BY" => "BELARUS", "BE" => "BELGIUM", "BZ" => "BELIZE", "BJ" => "BENIN", "BM" => "BERMUDA", "BT" => "BHUTAN", "BO" => "BOLIVIA, PLURINATIONAL STATE OF", "BA" => "BOSNIA AND HERZEGOVINA", "BW" => "BOTSWANA", "BV" => "BOUVET ISLAND", "BR" => "BRAZIL", "IO" => "BRITISH INDIAN OCEAN TERRITORY", "BN" => "BRUNEI DARUSSALAM", "BG" => "BULGARIA", "BF" => "BURKINA FASO", "BI" => "BURUNDI", "KH" => "CAMBODIA", "CM" => "CAMEROON", "CA" => "CANADA", "CV" => "CAPE VERDE", "KY" => "CAYMAN ISLANDS", "CF" => "CENTRAL AFRICAN REPUBLIC", "TD" => "CHAD", "CL" => "CHILE", "CN" => "CHINA", "CX" => "CHRISTMAS ISLAND", "CC" => "COCOS (KEELING) ISLANDS", "CO" => "COLOMBIA", "KM" => "COMOROS", "CG" => "CONGO", "CD" => "CONGO, THE DEMOCRATIC REPUBLIC OF THE", "CK" => "COOK ISLANDS", "CR" => "COSTA RICA", "CI" => "CÔTE D'IVOIRE", "HR" => "CROATIA", "CU" => "CUBA", "CY" => "CYPRUS", "CZ" =>  "CZECH REPUBLIC", "DK" => "DENMARK", "DJ" => "DJIBOUTI", "DM" => "DOMINICA", "DO" => "DOMINICAN REPUBLIC", "EC" => "ECUADOR", "EG" => "EGYPT", "SV" => "EL SALVADOR", "GQ" => "EQUATORIAL GUINEA", "ER" => "ERITREA", "EE" => "ESTONIA", "ET" => "ETHIOPIA", "FK" => "FALKLAND ISLANDS (MALVINAS)", "FO" => "FAROE ISLANDS", "FJ" => "FIJI", "FI" => "FINLAND", "FR" => "FRANCE", "GF" => "FRENCH GUIANA", "PF" => "FRENCH POLYNESIA", "TF" => "FRENCH SOUTHERN TERRITORIES", "GA" => "GABON", "GM" => "GAMBIA", "GE" => "GEORGIA", "DE" => "GERMANY", "GH" => "GHANA", "GI" => "GIBRALTAR", "GR" => "GREECE", "GL" => "GREENLAND", "GD" => "GRENADA", "GP" => "GUADELOUPE", "GU" => "GUAM", "GT" => "GUATEMALA", "GG" => "GUERNSEY", "GN" => "GUINEA", "GW" => "GUINEA-BISSAU", "GY" => "GUYANA", "HT" => "HAITI", "HM" => "HEARD ISLAND AND MCDONALD ISLANDS", "VA" => "HOLY SEE (VATICAN CITY STATE)", "HN" => "HONDURAS", "HK" => "HONG KONG", "HU" => "HUNGARY", "IS" => "ICELAND", "IN" => "INDIA", "ID" => "INDONESIA", "IR" => "IRAN, ISLAMIC REPUBLIC OF", "IQ" => "IRAQ", "IE" => "IRELAND", "IM" => "ISLE OF MAN", "IL" => "ISRAEL", "IT" => "ITALY", "JM" => "JAMAICA", "JP" => "JAPAN", "JE" =>  "JERSEY", "JO" => "JORDAN", "KZ" => "KAZAKHSTAN", "KE" => "KENYA", "KI" => "KIRIBATI", "KP" => "KOREA, DEMOCRATIC PEOPLE'S REPUBLIC OF", "KR" => "KOREA, REPUBLIC OF", "KW" => "KUWAIT", "KG" => "KYRGYZSTAN", "LA" => "LAO PEOPLE'S DEMOCRATIC REPUBLIC", "LV" => "LATVIA", "LB" => "LEBANON", "LS" => "LESOTHO", "LR" => "LIBERIA", "LY" => "LIBYAN ARAB JAMAHIRIYA", "LI" => "LIECHTENSTEIN", "LT" => "LITHUANIA", "LU" => "LUXEMBOURG", "MO" => "MACAO", "MK" => "MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF", "MG" => "MADAGASCAR", "MW" => "MALAWI", "MY" => "MALAYSIA", "MV" => "MALDIVES", "ML" => "MALI", "MT" => "MALTA", "MH" =>  "MARSHALL ISLANDS", "MQ" => "MARTINIQUE", "MR" => "MAURITANIA", "MU" => "MAURITIUS", "YT" => "MAYOTTE", "MX" => "MEXICO", "FM" => "MICRONESIA, FEDERATED STATES OF", "MD" => "MOLDOVA, REPUBLIC OF", "MC" => "MONACO", "MN" => "MONGOLIA", "ME" => "MONTENEGRO", "MS" => "MONTSERRAT", "MA" => "MOROCCO", "MZ" => "MOZAMBIQUE", "MM" => "MYANMAR", "NA" => "NAMIBIA", "NR" => "NAURU", "NP" => "NEPAL", "NL" => "NETHERLANDS", "AN" => "NETHERLANDS ANTILLES", "NC" => "NEW CALEDONIA", "NZ" => "NEW ZEALAND", "NI" => "NICARAGUA", "NE" => "NIGER", "NG" => "NIGERIA", "NU" => "NIUE", "NF" => "NORFOLK ISLAND", "MP" => "NORTHERN MARIANA ISLANDS", "NO" => "NORWAY", "OM" => "OMAN", "PK" => "PAKISTAN", "PW" => "PALAU", "PS" => "PALESTINIAN TERRITORY, OCCUPIED", "PA" => "PANAMA", "PG" => "PAPUA NEW GUINEA", "PY" => "PARAGUAY", "PE" => "PERU", "PH" => "PHILIPPINES", "PN" => "PITCAIRN", "PL" => "POLAND", "PT" => "PORTUGAL", "PR" => "PUERTO RICO", "QA" => "QATAR", "RE" => "REUNION", "RO" => "ROMANIA", "RU" => "RUSSIAN FEDERATION", "RW" => "RWANDA", "BL" => "SAINT BARTHÉLEMY", "SH" => "SAINT HELENA, ASCENSION AND TRISTAN DA CUNHA", "KN" => "SAINT KITTS AND NEVIS", "LC" => "SAINT LUCIA", "MF" => "SAINT MARTIN", "PM" => "SAINT PIERRE AND MIQUELON", "VC" => "SAINT VINCENT AND THE GRENADINES", "WS" => "SAMOA", "SM" => "SAN MARINO", "ST" => "SAO TOME AND PRINCIPE", "SA" => "SAUDI ARABIA", "SN" => "SENEGAL", "RS" => "SERBIA", "SC" => "SEYCHELLES", "SL" => "SIERRA LEONE", "SG" => "SINGAPORE", "SK" => "SLOVAKIA", "SI" => "SLOVENIA", "SB" => "SOLOMON ISLANDS", "SO" => "SOMALIA", "ZA" => "SOUTH AFRICA", "GS" => "SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS", "ES" => "SPAIN", "LK" => "SRI LANKA", "SD" => "SUDAN", "SR" => "SURINAME", "SJ" => "SVALBARD AND JAN MAYEN", "SZ" => "SWAZILAND", "SE" => "SWEDEN", "CH" => "SWITZERLAND", "SY" => "SYRIAN ARAB REPUBLIC", "TW" => "TAIWAN, PROVINCE OF CHINA", "TJ" => "TAJIKISTAN", "TZ" => "TANZANIA, UNITED REPUBLIC OF", "TH" => "THAILAND", "TL" => "TIMOR-LESTE", "TG" => "TOGO", "TK" => "TOKELAU", "TO" => "TONGA", "TT" => "TRINIDAD AND TOBAGO", "TN" => "TUNISIA", "TR" => "TURKEY", "TM" => "TURKMENISTAN", "TC" => "TURKS AND CAICOS ISLANDS", "TV" => "TUVALU", "UG" => "UGANDA", "UA" => "UKRAINE", "AE" => "UNITED ARAB EMIRATES", "GB" => "UNITED KINGDOM", "US" => "UNITED STATES", "UM" => "UNITED STATES MINOR OUTLYING ISLANDS", "UY" => "URUGUAY", "UZ" => "UZBEKISTAN", "VU" => "VANUATU", "VE" => "VENEZUELA, BOLIVARIAN REPUBLIC OF", "VN" => "VIET NAM", "VG" => "VIRGIN ISLANDS, BRITISH", "VI" => "VIRGIN ISLANDS, U.S.", "WF" =>  "WALLIS AND FUTUNA", "EH" => "WESTERN SAHARA", "YE" => "YEMEN", "ZM" => "ZAMBIA", "ZW" => "ZIMBABWE");

foreach($countries as $code => $n)
{
    if(strcasecmp($name, $n) == 0)
	return $code;

}
	
}


function  getEPC($campaignId, $network)
{

	$campaignId = makesafe($campaignId);
	$network = makesafe($network);

    $sql = mysql_query("SELECT epc FROM epc WHERE camp_id = '$campaignId' AND network = '$network'");	
	if(mysql_num_rows($sql))
	{
	    	
			$r = mysql_fetch_object($sql);
			return $r->epc;
			
	}else
	{
	    return 0.00;	
	}
}


function updateEPC($campaignId, $network, $epc)
{
	$campaignId = makesafe($campaignId);
	$network = makesafe($network);
	$epc  = makesafe($epc);
    @mysql_query("UPDATE offers SET epc = '$epc' WHERE campaign_id  = '$campaignId' AND network = '$network' ");	
}

function logEPC($campaignId, $network, $epc)
{
	$campaignId = makesafe($campaignId);
	$network = makesafe($network);
	$epc  = makesafe($epc);
	
	@mysql_query("DELETE FROM epc WHERE camp_id = '$campaignId' AND network = '$network'");       	
	@mysql_query("INSERT INTO epc VALUES(NULL, '$campaignId', '$network', '$epc')");
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



function call_url($URL)
{
        $c = curl_init();
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_URL, $URL);
        $contents = curl_exec($c);
        curl_close($c);

        if (!empty($contents)) return $contents;
            else return file_get_contents($URL);
}


?>