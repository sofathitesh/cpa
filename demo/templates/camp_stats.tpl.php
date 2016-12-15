{include file="header.tpl.php"}


<!--Page Title and User earnings overview-->
<div id="page_header">

<div class="pageTitle">
Campaign Reports
</div>


<div class="liveCounters">

{include file="live_counters.tpl.php"}

</div>


</div>
<!--End Page Title and User eanrings overview-->



<!--Contents-->
<div id="content"  style="display:block" >
<div class="clear">

<div class="gap20px">&nbsp;</div>



<div class="clear">
<p class="stats_date">Showing Campaign Statistics </p>
</div>



<div class="gap20px">&nbsp;</div>


<!--Detailed-->
<div class="clear">
<table cellpadding="0" cellspacing="0" border="0"  class="dataTable table table-bordered" id="dataGrid">

    <thead> 
        <tr style="text-align:center !important"> 
            <th>Offer</th> 
            <th>Clicks</th> 
            <th>Leads</th>
            <th>Referrer</th>  
            <th>Payout</th>            
           
        
    
{if $recentConvs2 ne ""}
  
  {foreach item=conv from=$recentConvs2}  
   </tr>
<td><div style="color:#333333; font-size:12px;"><div class="left" style="padding-left:4px;"><div class="dcf" style=" color:#666666; font-weight:bold"><img src="templates/flags/{$conv.country|@strtolower}.gif" alt="" /> [{$conv.country}] - {$conv.offer}</div><div class="ddt">{$conv.date}</div></td><td>{$conv.clicks}</td><td>{$conv.leads}</td><td>{$conv.ref}</td><td><div class="right dcp" style="padding-right:4px; color:#0000ff; font-weight:bold; ">${$conv.credits}</div></div></td>    
  
  
  {/foreach}
  
 </thead> 

  
  {else}
  
  <center>No Latest Leads</center>
  
  {/if}

</table>
</div>

<!--end Detailed-->



</div>
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