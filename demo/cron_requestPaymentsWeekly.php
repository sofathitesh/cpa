<?php

$secret = 'XhmeoxuCPanNEtwork';
if($_SERVER["argv"][1] != $secret)
{
    die("Invalid Access Denied");
}

error_reporting(0);
ini_set("display_errors", "off");
require_once("includes/dbconfig.php");
require_once("includes/settings.php");
require_once("includes/functions.php");
require_once("classes/class.user.php"); //include user class
require_once("classes/class.stats.php");



$min_limit = MIN_CASHOUT_LIMIT;



$sql1 = mysql_query("SELECT uid, balance, email_address, payment_cycle, payment_method, payment_method_details FROM users WHERE balance >= $min_limit AND payment_cycle IS NOT NULL AND payment_method IS NOT NULL AND payment_method_details IS NOT NULL AND payment_cycle = 'weekly'");



if(mysql_num_rows($sql1))
{
    while($row = mysql_fetch_assoc($sql1))
	{
		
		$credits = $row['balance'];
		$uid = $row['uid'];
		$payment_method = $row['payment_method'];
		$payment_detail = $row['payment_method_details'];
		$payment_cycle = $row['payment_cycle'];
		
				
		if(mysql_num_rows(mysql_query("SELECT * FROM cashouts WHERE uid = '$uid' AND status = 'Pending'")))
		{
		   continue;
		}			
			
		
		$method = $payment_method;
  	    $available_money = Stats::getMoney($uid);
	
		$user_newmoney = sprintf("%.2f",  $available_money - $credits); // Deduct money
		$updateMoney = Stats::SetMoney($uid, $user_newmoney);  // Update new money
	
	
	if($updateMoney) //If money updated then insert an order into table.
	{


        $money = $credits;

	    $new_order = mysql_query("INSERT INTO cashouts(`id`, `uid`,	`amount`, `status`,	`method`, `user_notes`, `admin_notes`, `request_date`, `payment_date`, `email_address`, `priority`,	`fee`) VALUES(NULL, '$uid', '$money', 'Pending', '$method', '$payment_detail', NULL, NOW(), NULL, '$payment_detail', '$payment_cycle', '0')");

		if($new_order)
		{
			
		  echo "<br /> Requested Cashout for $uid <br />";	
			
		}else
		{
          die("Error occured while making requests.");         
		}
	
	}else
	{
       continue;
	}	
	
		
	
		
		
		
		
	

  }



		
        		
		
		
	}	


echo "done";

?>