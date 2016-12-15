<?php /* Smarty version 2.6.26, created on 2016-12-14 10:48:52
         compiled from right_panel.tpl.php */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'strtolower', 'right_panel.tpl.php', 68, false),array('modifier', 'count', 'right_panel.tpl.php', 104, false),)), $this); ?>
<div id="dashboard_rightPanel">




<!--Latest Conv-->
<div class="clear">

<div class="panel panel-default">
  <div class="panel-heading">Quick Stats</div>
  <div class="panel-body">



   <table class="table table-condensed table-noborder">
   
   <tr class="qst_row">
       <td>Today:  </td><td class="qst_val">$<?php echo $this->_tpl_vars['today_earnings']; ?>
</td>
   </tr>

   <tr class="qst_row">
       <td>Yesterday:  </td><td class="qst_val">$<?php echo $this->_tpl_vars['yesterday_earnings']; ?>
</td>
   </tr>


   <tr class="qst_row">
       <td>Last 7 Days:  </td><td class="qst_val">$<?php echo $this->_tpl_vars['week_earnings']; ?>
</td>
   </tr>
   
   
   <tr class="qst_row">
       <td>This Month:  </td><td class="qst_val">$<?php echo $this->_tpl_vars['month_earnings']; ?>
</td>
   </tr>   

   <tr class="qst_row">
       <td>Last Month:  </td><td class="qst_val">$<?php echo $this->_tpl_vars['last_month_earnings']; ?>
</td>
   </tr>   


   
   </table>



  </div>
</div>


</div>
<!--End Latest Conv-->



<!--Latest Conv-->
<div class="clear">

<div class="panel panel-default">
  <div class="panel-heading">Latest Conversion</div>
  <div class="panel-body">
  
  
  
  <?php if ($this->_tpl_vars['recentConvs'] != ""): ?>
  
  <?php $_from = $this->_tpl_vars['recentConvs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['conv']):
?>
  
  
<div style="color:#333333; font-size:12px;"><div class="left" style="padding-left:4px;"><div class="dcf" style=" color:#666666; font-weight:bold"><img src="templates/flags/<?php echo strtolower($this->_tpl_vars['conv']['country']); ?>
.gif" alt="" /> [<?php echo $this->_tpl_vars['conv']['country']; ?>
] - <?php echo $this->_tpl_vars['conv']['offer']; ?>
</div><div class="ddt"><?php echo $this->_tpl_vars['conv']['date']; ?>
</div></div><div class="right dcp" style="padding-right:4px; color:#0000ff; font-weight:bold; ">$<?php echo $this->_tpl_vars['conv']['credits']; ?>
</div></div><div class="gap10px">&nbsp;</div>    
  
  
  <?php endforeach; endif; unset($_from); ?>
  
 
  
  <?php else: ?>
  
  <center>No Latest Leads</center>
  
  <?php endif; ?>
    
    
    
  </div>
</div>


</div>
<!--End Latest Conv-->



<!--News Feed-->
<div class="clear">

<div class="panel panel-default">
  <div class="panel-heading">News & Updates</div>
  <div class="panel-body">
    
    
    
<?php if ($this->_tpl_vars['news'] != ""): ?>
<?php $_from = $this->_tpl_vars['news']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['n'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['n']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['alert']):
        $this->_foreach['n']['iteration']++;
?>

    <div class="news_line" <?php if (($this->_foreach['n']['iteration']-1)+1 == count($this->_tpl_vars['news'])): ?>style="border:0"<?php endif; ?>><b><?php echo $this->_tpl_vars['alert']['date']; ?>
</b> - <?php echo $this->_tpl_vars['alert']['title']; ?>
<br /><?php echo $this->_tpl_vars['alert']['desc']; ?>
<br /><a href="news.php?nid=<?php echo $this->_tpl_vars['alert']['id']; ?>
">read more</a></div>


<?php endforeach; endif; unset($_from); ?>
<?php endif; ?>    
    
  </div>
</div>


</div>
<!--End News Feed-->



</div>