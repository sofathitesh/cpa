<?php /* Smarty version 2.6.26, created on 2016-12-16 01:37:22
         compiled from dashboard.tpl.php */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl.php", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<!--Page Title and User earnings overview-->
<div id="page_header">

<div class="pageTitle">
Dashboard
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



<!--Page Contents Wrapper-->
<div id="content">



<!--Left Panel-->
<div id="dashboard_leftPanel">
<div class="clear">

Welcome <b><?php echo $this->_tpl_vars['uloggedUser']; ?>
</b> | Today Earnings: <b>$<?php echo $this->_tpl_vars['today_earnings']; ?>
</b> | Last Payment: <b>$<?php echo $this->_tpl_vars['last_payment']; ?>
</b>
<hr />

<!--Stats + Feed-->
<div class="clear">

<!--Stats-->
<div class="">

<h4>Performance Stats</h4>

<table class="table table-hover table-condensed" style="font-size:13px; color:#666666">
<tr>
    <td>&nbsp;</td><td>Clicks</td><td>Leads</td><td>Earnings</td><td>EPC</td><td>CR</td>
</tr>


<tr>
    <td>Today</td><td><?php echo $this->_tpl_vars['today_clicks']; ?>
</td><td><?php echo $this->_tpl_vars['today_downloads']; ?>
</td><td>$<?php echo $this->_tpl_vars['today_earnings']; ?>
</td><td>$<?php echo $this->_tpl_vars['today_epc']; ?>
</td><td><?php echo $this->_tpl_vars['today_cr']; ?>
%</td>
</tr>
<tr>
    <td>Yesterday</td><td><?php echo $this->_tpl_vars['yesterday_clicks']; ?>
</td><td><?php echo $this->_tpl_vars['yesterday_downloads']; ?>
</td><td>$<?php echo $this->_tpl_vars['yesterday_earnings']; ?>
</td><td>$<?php echo $this->_tpl_vars['yesterday_epc']; ?>
</td><td><?php echo $this->_tpl_vars['yesterday_cr']; ?>
%</td>
</tr>

<tr>
    <td>This Month</td><td><?php echo $this->_tpl_vars['month_clicks']; ?>
</td><td><?php echo $this->_tpl_vars['month_downloads']; ?>
</td><td>$<?php echo $this->_tpl_vars['month_earnings']; ?>
</td><td>$<?php echo $this->_tpl_vars['month_epc']; ?>
</td><td><?php echo $this->_tpl_vars['month_cr']; ?>
%</td>
</tr>

<tr>
    <td>Last Month</td><td><?php echo $this->_tpl_vars['last_month_clicks']; ?>
</td><td><?php echo $this->_tpl_vars['last_month_downloads']; ?>
</td><td>$<?php echo $this->_tpl_vars['last_month_earnings']; ?>
</td><td>$<?php echo $this->_tpl_vars['last_month_epc']; ?>
</td><td><?php echo $this->_tpl_vars['last_month_cr']; ?>
%</td>
</tr>






</table>




</div>
<!--End Stats-->

<!--News Feed-->

<!--End News Feed-->



</div>
<!--End Stats+Feed-->




<!--Earnings Summmary -->
<div class="clear">
<div class="gap10px">&nbsp;</div>
<h4>Monthly Snapshot</h4>

<div class="clear">
    <iframe src="overview_graph.php" scrolling="no" style="width:700px; height:300px; border:0"></iframe>
</div>


</div>
<!--End Earnings Summary -->







<!--Offers Latest-->
<div class="clear">

<h4>Latest Campaigns</h4>
<div class="contents">



<table class="table table-hover table-condensed table-bordered" style="border-bottom:0 !important; margin-bottom:0; font-size:13px">
<tr>
    <th style="width:50%">Offer Name</th>
    <th>Payout</th>
    <th>EPC</th>     
    <th>Date Added</th>       
    
</tr>
<?php if ($this->_tpl_vars['latestOffers'] != ""): ?>

<?php $_from = $this->_tpl_vars['latestOffers']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['lf'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['lf']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['offer']):
        $this->_foreach['lf']['iteration']++;
?>


    <tr>
    <td><img src="<?php echo $this->_tpl_vars['offer']['flag']; ?>
" alt=""  />&nbsp; <?php echo $this->_tpl_vars['offer']['name']; ?>
</td>
    <td>$<?php echo $this->_tpl_vars['offer']['payout']; ?>
</td>
    <td ><?php echo $this->_tpl_vars['offer']['epc']; ?>
</td>
    <td><?php echo $this->_tpl_vars['offer']['date']; ?>
</td>
    </tr>           




<?php endforeach; endif; unset($_from); ?>

<?php else: ?>

<tr><td><center>No offer added recently</center></td></tr>

<?php endif; ?>


</table>

</div>



</div>
</div>
<!--End Latest Offers-->





</div>
<!--End Left Panel-->


<!--End Right Panel-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "right_panel.tpl.php", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!--End Right Panel-->


<div class="gap20px">&nbsp;</div>




</div>
<!--end Page content wrapper-->

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl.php", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>