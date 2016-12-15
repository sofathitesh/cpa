<?php

if($hourly)
{
	
	//get clicks and their hours first
	$mm1 = mysql_query("SELECT COUNT(offer_process.id) as clicks ,offer_process.date as ddate, (SELECT COUNT(id) FROM offer_process WHERE status = 1 AND uid = '$uid' AND DATE(date) = DATE(ddate)) as downloads FROM offer_process WHERE uid = '$uid' $q GROUP BY HOUR(date) ");
	if(mysql_num_rows($mm1))
	{
		while($mr1 = mysql_fetch_object($mm1))
		{
			$cdate1 = date("H", strtotime($mr1->ddate));
			$___clicks = $mr1->clicks;
			$___downloads = $mr1->downloads;
			
            $clicks[$cdate1] = 	$___clicks;
			$downloads[$cdate1] = $___downloads;
		}
		
	}	
	

	/*$mm2 = mysql_query("SELECT COUNT(gw_session_offers.id) as clicks ,gw_session_offers.date as ddate, (SELECT COUNT(id) FROM gw_session_offers WHERE status = 'complete' AND uid = '$uid' AND DATE(date) = DATE(ddate)) as downloads FROM gw_session_offers WHERE uid = '$uid' $q GROUP BY HOUR(date)  ");
	if(mysql_num_rows($mm2))
	{
		while($mr2 = mysql_fetch_object($mm2))
		{
			$cdate2 = date("H", strtotime($mr2->ddate));
	        $___clicks2 = $mr2->clicks;
			$___downloads2 = $mr2->downloads;	
			
			if(array_key_exists($cdate2, $clicks))
			{
				$clicks[$cdate2] += $___clicks2;	
			}else
			{
				$clicks[$cdate2] = $___clicks2;	
			}
			
			if(array_key_exists($cdate2, $downloads))
			{
				$downloads[$cdate2] += $___downloads2;	
			}else
			{
				$downloads[$cdate2] = $___downloads2;	
			}					
			

			
			
		}
		
	}*/
	
	
    if(empty($clicks))
	return;	


	//merge clicks and downloads array
	foreach($clicks as $hour => $count)
	{
	    if(array_key_exists($hour, $downloads))
		{
		    $data .= "[$hour, $count, ".$downloads[$hour]."],";	
		}else
		{
		     $data .= "[$hour, $count, 0],";	
		}
	}
	
	    $data = "['Date', 'Clicks', 'Downloads'],".$data;
		$data = substr($data, 0, -1);
		$template->assign('ldata', $data);	
	
	
}else
{

	
	$mm1 = mysql_query("SELECT COUNT(offer_process.id) as clicks ,offer_process.date as ddate, (SELECT COUNT(id) FROM offer_process WHERE status = 1 AND uid = '$uid' AND DATE(date) = DATE(ddate)) as downloads FROM offer_process WHERE uid = '$uid' $q GROUP BY DATE(date) ");
	if(mysql_num_rows($mm1))
	{
		while($mr1 = mysql_fetch_object($mm1))
		{
			$cdate1 = date("Y-m-d", strtotime($mr1->ddate));
			$___clicks = $mr1->clicks;
			$___downloads = $mr1->downloads;
			
            $clicks[$cdate1] = 	$___clicks;
			$downloads[$cdate1] = $___downloads;
		}
		
	}	
	

	/*$mm2 = mysql_query("SELECT COUNT(gw_session_offers.id) as clicks ,gw_session_offers.date as ddate, (SELECT COUNT(id) FROM gw_session_offers WHERE status = 'complete' AND uid = '$uid' AND DATE(date) = DATE(ddate)) as downloads FROM gw_session_offers WHERE uid = '$uid' $q GROUP BY DATE(date)  ");
	if(mysql_num_rows($mm2))
	{
		while($mr2 = mysql_fetch_object($mm2))
		{
			$cdate2 = date("Y-m-d", strtotime($mr2->ddate));
	        $___clicks2 = $mr2->clicks;
			$___downloads2 = $mr2->downloads;	
			
			if(array_key_exists($cdate2, $clicks))
			{
				$clicks[$cdate2] += $___clicks2;	
			}else
			{
				$clicks[$cdate2] = $___clicks2;	
			}
			
			if(array_key_exists($cdate2, $downloads))
			{
				$downloads[$cdate2] += $___downloads2;	
			}else
			{
				$downloads[$cdate2] = $___downloads2;	
			}					
			

			
			
		}
		
	}*/
	
	


    if(empty($clicks))
	return;

	//merge clicks and downloads array
	foreach($clicks as $d => $count)
	{
	    if(array_key_exists($d, $downloads))
		{
		    $data .= "['$d', $count, ".$downloads[$d]."],";	
		}else
		{
		     $data .= "['$d', $count, 0],";	
		}
	}
	
	    $data = "['Date', 'Clicks', 'Downloads'],".$data;
		$data = substr($data, 0, -1);
		$template->assign('ldata', $data);	



	
}








?>
