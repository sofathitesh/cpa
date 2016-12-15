<script type="text/javascript" src="../templates/js/jquery.js"></script>
<link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>    

<script type="text/javascript">
var today = '<?=$serverDate?>';

 $(document).ready(function(){

 $('#date1').datepicker({ dateFormat: "yy-mm-dd"});
 $('#date1').datepicker( "option", "defaultDate", today );
 $('#date2').datepicker({ dateFormat: "yy-mm-dd"}); 
 $('#date2').datepicker( "option", "defaultDate", today );

	 
 });

 
</script>

<div class="row">
            <div class="col-xs-12">
              <ol class="breadcrumb">
                <li>
                  <a href="index.php">Dashboard</a>
                </li>
                <li class="active">
                  <a href="#">Statistics</a>
                </li>
              </ol>
            </div>
          </div>

<div class="row">
            <div class="col-md-6">
              <h1>
                <span aria-hidden="true" class="icon icon-grid-big"></span>
                <span class="main-text">
                  Statistics
                </span>
              </h1>
            </div>
            <div class="col-md-6">
            </div>
          </div>


<div class="block overview-block">
                    <div class="block-heading">
                      <div class="main-text h2">
                        Overview
                      </div>
                      <div class="block-controls">
                        <span aria-hidden="true" class="icon icon-cross icon-size-medium block-control-remove"></span>
                        <span aria-hidden="true" class="icon icon-arrow-down icon-size-medium block-control-collapse"></span>
                      </div>
                    </div>
                    <div class="block-content-outer">
                      <div class="block-content-inner">
<form action="index.php" id="searchForm" method="get">
<input type="hidden" name="show" value="1" />
<input type="hidden" name="m" value="stats" />


<table class="table" style="text-align:center;">

<tr>

    <td class="dslabel" style="vertical-align:middle">Start Date</td>
    <td class="dateCalc" style="vertical-align:middle"><img src="../templates/images/calc.png" alt="" /></td>
    <td style="vertical-align:middle"><div class="dateField" style="vertical-align:middle; margin-top:10px;"><input type="text" name="date1" style="height:35px;" id="date1" class="form-control" value="<?=$from?>" /></div></td>
    <td class="dslabel2" style="vertical-align:middle">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;End Date</td>
    <td class="dateCalc" style="vertical-align:middle"><img src="../templates/images/calc.png" alt="" /></td>
    <td><div class="dateField" style="margin-top:10px;"><input type="text" name="date2" id="date2" style="height:35px;" class="form-control" value="<?=$to?>" /></div></td>
    <td><input type="submit" style="margin-top:10px;" name="show" value="View Stats" class="btn btn-default" /></td>

</tr>
</table>
</form>

                    </div>
                  </div>


<div class="row">
            <div class="col-md-6">
              <h1>
                <span class="main-text">
                  Showing Stats from <?=$from?> <? if(!empty($to)) { ?> to <?=$to?> <? } ?>
                </span>
              </h1>
            </div>
            <div class="col-md-6">
            </div>
          </div>


<br  />
<div class="clear-fix"></div>
 
<div class="row">
            <div class="col-sm-6 col-md-4">
              <div class="c-widget c-widget-quick-info c-widget-size-small highlight-color-orange" data-url="pages-profile.html" style="cursor: pointer;">
                <div class="c-widget-icon">
                  <span class="icon icon-graphs"></span>
                </div>
                <div class="c-wdiget-content-block">
                  <div class="c-widget-content-heading">
                    <?=$totalClicks?>
                  </div>
                  <div class="c-widget-content-sub">
                    Clicks
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-md-4">
              <div class="c-widget c-widget-quick-info c-widget-size-small highlight-color-red" data-url="#" style="cursor: pointer;">
                <div class="c-widget-icon">
                  <span class="icon icon-triple-points"></span>
                </div>
                <div class="c-wdiget-content-block">
                  <div class="c-widget-content-heading">
                    <?=$totalLeads?>
                  </div>
                  <div class="c-widget-content-sub">
                    Leads
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-md-4">
              <div class="c-widget c-widget-quick-info c-widget-size-small highlight-color-blue" data-url="#" style="cursor: pointer;">
                <div class="c-widget-icon">
                  <span class="icon icon-dollar"></span>
                </div>
                <div class="c-wdiget-content-block">
                  <div class="c-widget-content-heading">
                    $<?=$totalEarnings?>
                  </div>
                  <div class="c-widget-content-sub">
                    Earnings
                  </div>
                </div>
              </div>
            </div>
          </div>
<div class="row">
            <div class="col-sm-6 col-md-4">
              <div class="c-widget c-widget-quick-info c-widget-size-small highlight-color-green" data-url="pages-profile.html" style="cursor: pointer;">
                <div class="c-widget-icon">
                  <span class="icon icon-info"></span>
                </div>
                <div class="c-wdiget-content-block">
                  <div class="c-widget-content-heading">
                    <?=$totalCR?>
                  </div>
                  <div class="c-widget-content-sub">
                    CR
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-md-4">
              <div class="c-widget c-widget-quick-info c-widget-size-small highlight-color-green" data-url="#" style="cursor: pointer;">
                <div class="c-widget-icon">
                  <span class="icon icon-info"></span>
                </div>
                <div class="c-wdiget-content-block">
                  <div class="c-widget-content-heading">
                    <?=$totalEPC?>
                  </div>
                  <div class="c-widget-content-sub">
                    EPC
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-md-4">
              <div class="c-widget c-widget-quick-info c-widget-size-small highlight-color-green" data-url="#" style="cursor: pointer;">
                <div class="c-widget-icon">
                  <span class="icon icon-info"></span>
                </div>
                <div class="c-wdiget-content-block">
                  <div class="c-widget-content-heading">
                    $<?=$avgCPA?>
                  </div>
                  <div class="c-widget-content-sub">
                    AVGCPA
                  </div>
                </div>
              </div>
            </div>
          </div>

              <div class="block">
                <div class="block-heading">
                  <div class="main-text h2">
                    User Leads Stats
                  </div>
                  <div class="block-controls">
                    <span aria-hidden="true" class="icon icon-cross icon-size-medium block-control-remove"></span>
                    <span aria-hidden="true" class="icon icon-arrow-down icon-size-medium block-control-collapse"></span>
                  </div>
                </div>
                <div class="block-content-outer">
                  <div class="block-content-inner">
                    <table class="table table-striped table-hover">
                      <thead>
                        <tr>
                          <th>Date</th>
                          <th>Clicks</th>
                          <th>Leads</th>
                          <th>Earnings</th>
                          <th>EPC</th>
                          <th>CR</th>
                        </tr>
                      </thead>
                      <tbody>
<?php

foreach($leads as $lead)
{
    ?>
  
    <tr>
    <td><?=$lead['date']?></td>
    <td><?=$lead['clicks']?></td>
    <td><?=$lead['leads']?></td>
    <td>$<?=$lead['earnings']?></td>  
    <td><?=$lead['epc']?></td>  
    <td><?=$lead['cr']?></td>                    
    </tr>
  
  <?  
}

?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

             <div class="block">
                <div class="block-heading">
                  <div class="main-text h2">
                    User Leads Stats
                  </div>
                  <div class="block-controls">
                    <span aria-hidden="true" class="icon icon-cross icon-size-medium block-control-remove"></span>
                    <span aria-hidden="true" class="icon icon-arrow-down icon-size-medium block-control-collapse"></span>
                  </div>
                </div>
                <div class="block-content-outer">
                  <div class="block-content-inner">
<div id="lineChart"></div>



<? if(!empty($admin_data)){ ?>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">

	
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
           <?=$admin_data?>
        ]);

      var options = {
          title: 'Admin Earnings',		  
		  pointSize: 3,
		  backgroundColor: "#fff" <?php if($noData == 1){ ?>,
		  
		  'vAxis': { 'minValue': 0, 'maxValue': 5}
		  
		  <? } ?>
		  
		  
        };


        var chart = new google.visualization.LineChart(document.getElementById('lineChart'));
        chart.draw(data, options);
      }

    </script>
<? } ?>





<?php
//admin's earnings
$sql22 = mysql_query("SELECT uid, credits, campaign_id, network, hash, offer_id, offer_name, date FROM admin_earnings WHERE $q");
if(mysql_num_rows($sql22))
{
   
    while($ar2 = mysql_fetch_array($sql22)){	


	$date = date('d-m-Y h:i:s A', strtotime($ar2['date']));
	$earnings = $ar2['credits'];
    $u = $ar2['uid'];
    $camp = $ar2['campaign_id'];
    $a_network = $ar2['network'];

    $hash = $ar2['hash'];			
    $offer_id = $ar2['offer_id'];			

	$offer_name = $ar2['offer_name'];	
	
	
	$admin_tab .= "['<span>$date</span>', '$u', '$$earnings', '$offer_id', '$camp', '$offer_name', '$a_network', '$hash'],";
	
 /* <tr>
    <td><?=$date?></td>
    <td><?=$u?></td>
    <td><?=$earnings?></td>
    <td><?=$offer_id?></td>
    <td><?=$camp?></td>
    <td><?=$offer_name?></td>                    
    <td><?=$a_network?></td>
    <td><?=$hash?></td>
        
    </tr>*/

	
	}
  $admin_tab = substr($admin_tab, 0, -1);


}



?>

<script type="text/javascript" src="<?=SITE_URL?>templates/js/jquery.dataTables.js"></script>
<link href="<?=SITE_URL?>templates/css/jquery.dataTables.css" rel="stylesheet" type="text/css" />

</div></div></div>

             <div class="block">
                <div class="block-heading">
                  <div class="main-text h2">
                    User Leads Stats
                  </div>
                  <div class="block-controls">
                    <span aria-hidden="true" class="icon icon-cross icon-size-medium block-control-remove"></span>
                    <span aria-hidden="true" class="icon icon-arrow-down icon-size-medium block-control-collapse"></span>
                  </div>
                </div>
                <div class="block-content-outer">
                  <div class="block-content-inner">
<h4>Admin's Earnings Detailed Table</h4>
<br />

<div style="font-size:12px; color:#963;">Note: Offer Id is an internal id of offer/campaign, Camp Id is an id of Offer/Campaign provided by other networks.<br /></div>
<br />
<div style="clear:both;">
<table class="table table-bordered table-hover dataTable" id="dataGrid">
<thead>
<tr>

  <th>Date</th>
  <th>Aff ID</th>
  <th>Profit</th>        
  <th>Offer ID</th>  
  <th>Camp ID</th>        
  <th>Campaign</th>        
  <th>Network</th>
  <th>Lead Hash</th>          
    

</tr>
</thead>



</table>
</div>

<script type="text/javascript">

$(document).ready(function(){


   $('#dataGrid').dataTable( {

	   "aaData": [<?=$admin_tab?>]	 	 	 	 	 	
	  

   });
	  
	  
	  
	  
	  

	
});


</script>