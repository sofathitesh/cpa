<?php /* Smarty version 2.6.26, created on 2016-12-14 10:49:10
         compiled from referrals.tpl.php */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'urldecode', 'referrals.tpl.php', 43, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl.php", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>


<!--Page Title and User earnings overview-->
<div id="page_header">

<div class="pageTitle">
Affiliate Program
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


<h4><?php echo $this->_tpl_vars['SITE_NAME']; ?>
 Affiliate Program</h4>

<p>Refer new publishers to <?php echo $this->_tpl_vars['SITE_NAME']; ?>
 and earn <?php echo $this->_tpl_vars['REFERRAL_RATE']; ?>
% of their earnings. We utilize cookie tracking so users do not need to directly signup after visiting the referral link. This allows potential publishers to browse our site/features and sign up at a later time, while still giving your account credit.</p>


<p>Total Referral Earnings (This Month): <b>$<?php echo $this->_tpl_vars['month_referrals_earnings']; ?>
</b></p>



<form action="#" class="form form-inline">
<div class="ref_link">Your Referral Link: <input type="text" class="form-control" style="width:450px; padding:4px; height:20px" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['SITE_URL'])) ? $this->_run_mod_handler('urldecode', true, $_tmp) : urldecode($_tmp)); ?>
?ref=<?php echo $this->_tpl_vars['uloggedId']; ?>
" /></div>
</form>

<div class="gap20px">&nbsp;</div>

<!--Listing Container-->



<div class="clear">
<h4>Current Referrals</h4>
<form action="referrals.php" method="get">
<table cellspacing="0"  class="table">

  <tr>
      <th>&nbsp;Date</th><th>Affiliate</th><th>Today</th><th>Month</th><th>Total</th>
  </tr>

  

	  
  <?php if ($this->_tpl_vars['referrals'] != ""): ?>
	  <?php $_from = $this->_tpl_vars['referrals']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['referral']):
?>
	  
	  <tr class="listing_row"><td>&nbsp;<?php echo $this->_tpl_vars['referral']['date']; ?>
</td><td><?php echo $this->_tpl_vars['referral']['username']; ?>
</td><td>$<?php if ($this->_tpl_vars['referral']['today_ref_income'] > 0): ?><?php echo $this->_tpl_vars['referral']['today_ref_income']; ?>
<?php else: ?>0.00<?php endif; ?></td><td>$<?php if ($this->_tpl_vars['referral']['month_ref_income'] > 0): ?><?php echo $this->_tpl_vars['referral']['month_ref_income']; ?>
<?php else: ?>0.00<?php endif; ?></td><td>$<?php if ($this->_tpl_vars['referral']['income'] > 0): ?><?php echo $this->_tpl_vars['referral']['income']; ?>
<?php else: ?>0.00<?php endif; ?></td></tr>
	  
	  <tr><td colspan="5"><div class="line_separator1">&nbsp;</div></td></tr>
      
	  <?php endforeach; endif; unset($_from); ?>
      
      
      
  <?php endif; ?>
 </table>
 
 </form>
 




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