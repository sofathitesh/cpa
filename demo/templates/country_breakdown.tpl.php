{include file="header.tpl.php"}


<!--Page Title and User earnings overview-->
<div id="page_header">

<div class="pageTitle">
Country Breakdowns
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
<form action="country_breakdown.php" id="searchForm" method="post">
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
<p class="stats_date">{if $date_start ne ""}Showing Country Reports  From | {$date_start} {/if}{if $date_end ne ""}- {$date_end}{/if} </p>
</div>






<!--Graph Container-->
<div class="clear">
  
<div id="wmp" style="width:100%; border:1px solid #cccccc; height:400px; margin:0px auto; padding:10px 0">

{if $history eq "" || $history|@count lt 1}
<br />
<center>You have no lead in this time range</center>
{/if}

</div>


</div>



<!--End Graph Container-->



<!--Table Container-->
<div class="gap20px">&nbsp;</div>
<div class="contents">
<div class="grid1">



<table cellpadding="0" cellspacing="0" border="0"  class="dataTable summaryEarnTab table table-bordered"  id="dataGrid">
    <thead> 
        <tr> 
            <th style="text-align:left">Country</th> 
            <th>Clicks</th> 
            <th>Leads</th> 

            <th>CR%</th>            
            <th>AvgCPA</th>
            <th>EPC</th>
            <th>Earnings</th>             
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


</div></div>
<!--End Table Container-->


<div class="gap20px">&nbsp;</div>
<div class="gap20px">&nbsp;</div>

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
				revenue += parseFloat(aaData[i][6].substring(1));
				conv += parseFloat(aaData[i][3]);
				avgCPA += parseFloat(aaData[i][4].substring(1));
				epc += parseFloat(aaData[i][5].substring(1));
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
			nCells[3].innerHTML = conv+'%';
			nCells[4].innerHTML =  '$'+avgCPA;
			nCells[5].innerHTML =  '$'+epc;
			nCells[6].innerHTML = '$'+revenue;			
        },

	   {/literal}
	   "aaData": [{$history}]	 	 	 	 	 	
	   {literal}		  

   });
	  
	  

	  

	
});


</script>
{/literal}





</div>
<!--End Right Contents-->


{include file="footer.tpl.php"}