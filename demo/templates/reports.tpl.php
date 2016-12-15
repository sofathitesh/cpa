{include file="header.tpl.php"}


<!--Page Title and User earnings overview-->
<div id="page_header">

<div class="pageTitle">
Reports
</div>


<div class="liveCounters">

{include file="live_counters.tpl.php"}

</div>


</div>
<!--End Page Title and User eanrings overview-->

<!--Contents-->
<div id="content" >

<div class="gap20px">&nbsp;</div>

<!--Date Container-->
<div id="dateContainer">
<form action="reports.php" id="searchForm" method="post">
<table cellspacing="0" cellpadding="0" class="table table-bordered">

<tr>

    <td class="dslabel" style="text-align:center; vertical-align:middle">Start Date</td>
    <td class="dateCalc" ><img src="templates/images/calc.png" alt="" /></td>
    <td class="dtx"><input type="text" name="date1" id="date1" class="form-control" value="{$date_start}" /></td>
    <td class="dslabel2" style="text-align:center; vertical-align:middle">End Date</td>
    <td class="dateCalc"><img src="templates/images/calc.png" alt="" /></td>
    <td class="dtx"><input type="text" name="date2" id="date2" class="form-control" value="{$date_end}" /></td>
    <td class="upbtn"><input type="submit" class="btn btn-primary" value="Search" /></td>


</tr>
</table>
</form>

</div>
<!--End Date Container-->

<div class="clear">
<p class="stats_date">{if $date_start ne ""}Showing Reports  From | {$date_start} {/if}{if $date_end ne ""}- {$date_end}{/if} </p>
</div>


<!--Box Area-->
<div class="sub_section">

<div id="MSLine01Div" style="padding-top:10px; width:100%; margin:0 auto">Chart</div>
<script type="text/javascript" ><!--
	// Instantiate the Chart 
	{literal}
	if ( FusionCharts("MSLine01") && FusionCharts("MSLine01").dispose ) FusionCharts("MSLine01").dispose();
	var chart_MSLine01 = new FusionCharts( {  "swfUrl" : "Charts/v2_charts/MSLine.swf",  "width" : "100%",  "height" : "275",  "renderAt" : "MSLine01Div",  "dataFormat" : "xml",  "id" : "MSLine01",  "dataSource" : "<chart plotGradientColor='FFFFFF' showBorder='0' showValues='0' showLegend='0' showLabels='0'  bgColor='ffffff' canvasBgAlpha='0' bgAlpha='0' legendBgAlpha='0' canvasBorderThickness='1' connectNullData='1' showYAxisValues='0' canvasPadding='6'  >{/literal}{$categories}{$earnings}{literal}</chart>" } ).render();
// -->
    {/literal}
</script>

<br />


</div>
<!--End Box Area-->




<!--Detailed-->
<table cellpadding="0" cellspacing="0" border="0"  class="dataTable table table-bordered" id="dataGrid">

    <thead> 
        <tr style="text-align:center !important"> 
            <th>Date</th> 
            <th>Clicks</th> 
            <th>Leads</th> 
            <th>Revenue</th> 
            <th>Conv</th>            
            <th>Average CPA</th>
            <th>EPC</th>
        </tr> 
    </thead> 


  <tfoot> 
      <tr> 
          <th style='text-align: left'>Total/Average</th> 

          <th style='text-align: center'></th> 
          <th style='text-align: center'></th> 
          <th style='text-align: center'></th> 
          <th style='text-align: center'></th>
          <th style='text-align: center'></th>          
          <th style='text-align: center'></th>


      </tr> 
  </tfoot> 

</table>

<!--end Detailed-->




</div>




<br /><br />

{literal}
<script type="text/javascript">

$(document).ready(function(){


   $('#dataGrid').dataTable( {
   "fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {

			
			var clicks = 0;
			var downloads = 0;
			var conv = 0;
			var avgCPA = 0;
			var epc = 0;
			var revenue = 0;
			var conv_ = 0;

			
       
		   for ( var i=0 ; i<aaData.length ; i++ )
            {
                
				clicks += parseInt(aaData[i][1]);
				downloads += parseInt(aaData[i][2]);
				conv += parseFloat(aaData[i][4]);
				avgCPA += parseFloat(aaData[i][5].substring(1));
				epc += parseFloat(aaData[i][6].substring(1));
				revenue += parseFloat(aaData[i][3].substring(1));
				

            }
			
			revenue = Math.round(revenue*100)/100;
			conv_ = (clicks == 0) ? 0 : (downloads/clicks)*100;
            //conv = conv_.toString().match(/^\d+(?:\.\d{0,2})?/);
			conv = Math.round(conv_);
			avgCPA = (downloads == 0) ? 0 : Math.round((revenue/downloads)*100)/100;
			epc = (clicks == 0) ? 0 : Math.round((revenue/clicks)*100)/100;

			var nCells = nRow.getElementsByTagName('th');
			nCells[1].innerHTML = clicks;
			nCells[2].innerHTML = downloads;
			nCells[3].innerHTML = '$'+revenue;
			nCells[4].innerHTML = conv+'%';
			nCells[5].innerHTML =  '$'+avgCPA;
			nCells[6].innerHTML =  '$'+epc;
        },

	   {/literal}
	   "aaData": [{$data}]	 	 	 	 	 	
	   {literal}		  

   });
	  
	  
	  
	  
	  

	
});


</script>
{/literal}


<!--End Right Panel-->
{include file="footer.tpl.php"}