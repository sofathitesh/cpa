<?php /* Smarty version 2.6.26, created on 2016-12-14 10:49:12
         compiled from payments.tpl.php */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl.php", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>


<!--Page Title and User earnings overview-->
<div id="page_header">

<div class="pageTitle">
Payments History
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


<!--Left-->
<div id="dashboard_leftPanel">


<div class="gap20px">&nbsp;</div>



<!--Listing Container-->

<div class="clear">


<table cellspacing="0"  class="table table-bordered table-hover table-condensed">

  <tr>
      <th>&nbsp;Date</th><th>Amount</th><th>Method</th><th>Status</th><th>Payment Cycle</th>
  </tr>

  

	  
  <?php if ($this->_tpl_vars['payments'] != ""): ?>
	  <?php $_from = $this->_tpl_vars['payments']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['payment']):
?>
	  
	  <tr><td>&nbsp;<?php echo $this->_tpl_vars['payment']['date']; ?>
</td><td>$<?php echo $this->_tpl_vars['payment']['amount']; ?>
</td><td><?php echo $this->_tpl_vars['payment']['method']; ?>
</td><td><?php echo $this->_tpl_vars['payment']['status']; ?>
</td><td><?php echo $this->_tpl_vars['payment']['cycle']; ?>
</td></tr>
	  <?php endforeach; endif; unset($_from); ?>
      
      
      
  <?php endif; ?>
 </table>
 

 




<br />
  

</div>
  <?php if ($this->_tpl_vars['pages'] > 1): ?>
 <div style="width:660px; margin:0px; clear:both; " >
 <div style="float:left" class="listing_paging">Page <?php echo $this->_tpl_vars['page']; ?>
 of <?php echo $this->_tpl_vars['pages']; ?>
</div> <div style="float:right" class="listing_paging"> <?php echo $this->_tpl_vars['previous']; ?>
 <?php echo $this->_tpl_vars['next']; ?>
</div>
 </div>
<?php endif; ?>
  


<br  />






</div>
<!-- End Left Panel-->


<!--Right Panel-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "right_panel.tpl.php", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!--Right Panel-->



</div>



<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl.php", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>