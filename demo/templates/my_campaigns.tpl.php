{include file="header.tpl.php"}


<!--Page Title and User earnings overview-->
<div id="page_header">

<div class="pageTitle">
My Campaigns
</div>


<div class="liveCounters">

{include file="live_counters.tpl.php"}

</div>


</div>
<!--End Page Title and User eanrings overview-->

<!--Contents-->
<div id="content" >



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
     
      <div class="alert alert-danger">
        <img src="templates/images/cross.gif" style="vertical-align:top" alt="" /> {$error_msg}
        </div>
     
{elseif $success_msg ne ""}

      
      <div  class="alert alert-success" >
        <img src="templates/images/tick.gif" style="vertical-align:top" alt="" /> {$success_msg}
      </div>
    
{/if}
</div>





 <form action="campaigns.php" method="post" id="form1">
 <div class="clear" style=" margin:0 auto; padding:20px 0;">
 
 
 <table id="offersTable" class="dataTable table table-bordertable-hover">
 <thead>
 <tr>
 <th>Name</th><th>Payout</th><th>Status</th><th>Clicks</th><th>Leads</th><th>EPC</th><th>Country</th><th>Category</th><th>&nbsp;&nbsp;&nbsp;</th>
 </tr>
 </thead>
 

 
 
 </table>
 


  
  

  </div>



<div class="gap10px">&nbsp;</div>





  </form>







</div>


{literal}
<script type="text/javascript">

$(document).ready(function(){


   $('#offersTable').dataTable( {
	  "aoColumnDefs": [
		   { "bSortable": false, "aTargets": [ 8 ] }
	   ],	   
	   
	   {/literal}
	   "aaData": [{$offers}]	 	 	 	 	 	
	   {literal}		  

   });
	  
	  
	  
	  
	  

	
});


</script>
{/literal}



<br /><br />

</div>

{include file="footer.tpl.php"}
