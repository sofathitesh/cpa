{include file="header.tpl.php"}


<!--Page Title and User earnings overview-->
<div id="page_header">

<div class="pageTitle">
Campaigns
</div>


<div class="liveCounters">

{include file="live_counters.tpl.php"}

</div>


</div>
<!--End Page Title and User eanrings overview-->

<!--Contents-->
<div id="content" >




<link href="templates/css/jquery.dataTables.css" rel="stylesheet" type="text/css"/>
<link href="templates/css/buttons.css" rel="stylesheet" type="text/css"/>
<script type='text/javascript' src='templates/js/offers.js'></script>	
<script type='text/javascript' src='templates/js/jquery.dataTables.js'></script>	



<style type="text/css">
{literal}

table.dataTable td {
	padding: 3px 10px;
	text-align:left;
	vertical-align:middle
	
	
}
.dataTables_length {
	float: left;
	margin-left:5px
}
.dataTables_filter {
	float: right;
	text-align: right;
	margin-right:5px;
}

.dataTables_info {
	clear: both;
	float: left;
	margin-left:5px	
}

.dataTables_paginate {
	float: right;
	text-align: right;
	margin-right:5px;
}



{/literal}
</style>




<div class="box">

<br />

    

<br />

<div style="margin-left:14px;">
{if $error_msg ne ""}
     
      <div class="inline_reg_error">
        <img src="templates/images/cross.gif" style="vertical-align:top" alt="" /> {$error_msg}
        </div>
     
{elseif $success_msg ne ""}

      
      <div  class="inline_success_msg" >
        <img src="templates/images/tick.gif" style="vertical-align:top" alt="" /> {$success_msg}
      </div>
    
{/if}
</div>





 <form action="campaigns.php" method="post" id="form1">
 <div class="clear" style=" margin:0 auto; padding:20px 0;">
 
 
 <table style="width:700px">
 
 
 <tr id="cc-select">
 <td>&nbsp;Select Country</td><td>
 <div class="clear">
 <div class="left"><select name="country" id="op_countries" class="form-control"><option value="">All Countries</option>{$countries}</select>
 </div>
 </div></td>
 </tr>



 
 
 </table>
 
 <div style="height:20px;"></div>
 
 <table id="offersTable" {if $isManual eq '0'} style="display:none; width:100%"{/if} class="dataTable table table-border table-condensed table-hover offersTable">
 <thead>
 <tr>
 <th>&nbsp;</th><th>ID</th><th>Country</th><th>Name</th><th>Payout</th><th>Conv(%)</th><th>EPC</th><th>Category</th><th>&nbsp;&nbsp;&nbsp;</th>
 </tr>
 </thead>
 
 <tbody id="cc_offers"></tbody>
 

 
 
 </table>
 


  
  

  </div>



<div class="gap10px">&nbsp;</div>





  </form>







</div>

<!--End Box Area-->

<script type="text/javascript">
var fid = '{$fid}';
{literal}
$(document).ready(function(){



	
	
	

	
	
	
  	$('#offersTable').dataTable({
	

			    "oLanguage" : {
				"sProcessing": "Processing...",
				"sLengthMenu": "Show _MENU_ Offers",
				"sZeroRecords": "No matching offers found",
				"sEmptyTable": "No offers available in table",
				"sLoadingRecords": "Loading...",
				"sInfo": "Showing _START_ to _END_ of _TOTAL_ offers",
				"sInfoEmpty": "Showing 0 to 0 of 0 offers",
				"sInfoFiltered": "(filtered from _MAX_ total offers)",
				"sSearch": "Search:"
				},

				
       "aoColumnDefs": [
          { 
		    'bSortable': false, 'aTargets': [ 0 , 1, 2,  8 ]
            
		  }
       ],
	   
	   
  "fnInfoCallback": function( oSettings, iStart, iEnd, iMax, iTotal, sPre ) {
	  
    return "Showing from "+iStart +" to "+ iEnd +" of "+iTotal+" Offers";
  }	   				
							
			
			
					
	});



	
$('#op_countries').change(function(){
	
    loadCampaigns();	
	
});

$('#op_ua').change(function(){
	
    loadCampaigns();	
	
});



 loadCampaigns();	






});
{/literal}
</script>

<br />




<br /><br />

</div>

{include file="footer.tpl.php"}
