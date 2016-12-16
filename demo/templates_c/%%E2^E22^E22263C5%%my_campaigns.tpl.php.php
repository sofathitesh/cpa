<?php /* Smarty version 2.6.26, created on 2016-12-15 23:29:18
         compiled from my_campaigns.tpl.php */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl.php", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>


<!--Page Title and User earnings overview-->
<div id="page_header">

<div class="pageTitle">
My Campaigns
</div>


<div class="liveCounters">

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "live_counters.tpl.php", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

</div>


</div>
<!--End Page Title and User eanrings overview-->

<!--Contents-->
<div id="content" >



<style type="text/css">
<?php echo '

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



'; ?>

</style>




<div class="box">

<br />

    

<br />

<div style="margin-left:14px;">
<?php if ($this->_tpl_vars['error_msg'] != ""): ?>
     
      <div class="alert alert-danger">
        <img src="templates/images/cross.gif" style="vertical-align:top" alt="" /> <?php echo $this->_tpl_vars['error_msg']; ?>

        </div>
     
<?php elseif ($this->_tpl_vars['success_msg'] != ""): ?>

      
      <div  class="alert alert-success" >
        <img src="templates/images/tick.gif" style="vertical-align:top" alt="" /> <?php echo $this->_tpl_vars['success_msg']; ?>

      </div>
    
<?php endif; ?>
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


<?php echo '
<script type="text/javascript">

$(document).ready(function(){


   $(\'#offersTable\').dataTable( {
	  "aoColumnDefs": [
		   { "bSortable": false, "aTargets": [ 8 ] }
	   ],	   
	   
	   '; ?>

	   "aaData": [<?php echo $this->_tpl_vars['offers']; ?>
]	 	 	 	 	 	
	   <?php echo '		  

   });
	  
	  
	  
	  
	  

	
});


</script>
'; ?>




<br /><br />

</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl.php", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>