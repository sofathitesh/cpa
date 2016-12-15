<?php

$environment = 'live';	// or 'sandbox' or 'live' 
$priority = $_POST['priority'];

switch($priority)
{

    case 'net30':
	$ww = " AND priority = 'net30' ";
	break;
	
    case 'net15':
	$ww = " AND priority = 'net15' ";
	break;
	
    case 'weekly':
	$ww = " AND priority = 'weekly' ";
	break;


    case 'net45':
	$ww = " AND priority = 'net45' ";
	break;		
	
	
}


if(empty($ww))
die("Select Cashout Priority Type e.g. daily or weekly");



function PPHttpPost($methodName_, $nvpStr_) {
	global $environment;

	// Set up your API credentials, PayPal end point, and API version.
	$API_UserName = urlencode('YOUR API USERNAME');
	$API_Password = urlencode('YOUR API PASSWORD');
	$API_Signature = urlencode('YOUR API SIGNATURE');
	$API_Endpoint = "https://api-3t.paypal.com/nvp";
	if("sandbox" == $environment || "beta-sandbox" == $environment) {
		$API_Endpoint = "https://api-3t.$environment.paypal.com/nvp";
	}
	$version = urlencode('51.0');

	// Set the curl parameters.
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $API_Endpoint);
	curl_setopt($ch, CURLOPT_VERBOSE, 1);

	// Turn off the server and peer verification (TrustManager Concept).
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);

	// Set the API operation, version, and API signature in the request.
	$nvpreq = "METHOD=$methodName_&VERSION=$version&PWD=$API_Password&USER=$API_UserName&SIGNATURE=$API_Signature$nvpStr_";

	// Set the request as a POST FIELD for curl.
	curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);

	// Get response from the server.
	$httpResponse = curl_exec($ch);

	if(!$httpResponse) {
		exit("$methodName_ failed: ".curl_error($ch).'('.curl_errno($ch).')');
	}

	// Extract the response details.
	$httpResponseAr = explode("&", $httpResponse);

	$httpParsedResponseAr = array();
	foreach ($httpResponseAr as $i => $value) {
		$tmpAr = explode("=", $value);
		if(sizeof($tmpAr) > 1) {
			$httpParsedResponseAr[$tmpAr[0]] = $tmpAr[1];
		}
	}

	if((0 == sizeof($httpParsedResponseAr)) || !array_key_exists('ACK', $httpParsedResponseAr)) {
		exit("Invalid HTTP Response for POST request($nvpreq) to $API_Endpoint.");
	}

	return $httpParsedResponseAr;
}

// Set request-specific fields.
$emailSubject =urlencode(SITE_NAME.' - Payment Withdraw');
$receiverType = urlencode('EmailAddress');
$currency = urlencode('USD');							// or other currency ('GBP', 'EUR', 'JPY', 'CAD', 'AUD')

// Add request-specific fields to the request string.
$nvpStr="&EMAILSUBJECT=$emailSubject&RECEIVERTYPE=$receiverType&CURRENCYCODE=$currency";

$sql = mysql_query("SELECT * FROM cashouts WHERE method = 'paypal' AND status = 'Locked' $ww LIMIT 20");
if(!mysql_num_rows($sql))
{
    echo "No Cashout Request Found";
	return;
}

while($row = mysql_fetch_object($sql))
{
$uid = $row->uid;
$id = $row->id;
$payee_email = stripslashes($row->email_address);



$amt = $row->amount;

if($payee_email == 'None' || !validEmail($payee_email))
{
    mysql_query("UPDATE cashouts SET status = 'Cancelled' WHERE uid = $uid AND status = 'Locked' AND id = $id AND method = 'paypal'");
	mysql_query("UPDATE users SET balance=balance+$amt WHERE uid = '$uid' LIMIT 1");
	continue;
}

$uniqId = substr(md5(uniqid()),0,3).strtotime();






mysql_query("UPDATE cashouts SET status = 'Complete', `payment_date` = NOW() WHERE uid = $uid AND  status = 'Locked' AND id = $id AND method = 'paypal'");

$PAYEE[] = array('receiveremail' => $payee_email, 'amount' => $amt, 'uniqueID' => $uniqId, 'note' => '','uid' => $uid);   

}

$count= count($PAYEE);
for($i=0,$j=0;$i<$count;$i++) {
		if (isset($PAYEE[$i]['receiveremail']) && $PAYEE[$i]['receiveremail']!='' ) {
				
				
				$receiverEmail = urlencode($PAYEE[$i]['receiveremail']);
				$amount = urlencode($PAYEE[$i]['amount']);
				$uniqueID = urlencode($PAYEE[$i]['uniqueID']);
				$note = urlencode($PAYEE[$i]['note']);
				$nvpStr.="&L_EMAIL$j=$receiverEmail&L_Amt$j=$amount&L_UNIQUEID$j=$uniqueID&L_NOTE$j=$note";
				$j++;
				
				
				
				
		}
}

// Execute the API operation; see the PPHttpPost function above.
$httpParsedResponseAr = PPHttpPost('MassPay', $nvpStr);

if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {
	//exit('MassPay Completed Successfully: '.print_r($httpParsedResponseAr, true));
	
	exit("MassPay Transaction Completed, Payment made to locked paypal requests");
	
} else  {
	exit('MassPay failed: ' . print_r($httpParsedResponseAr, true));
}

?>