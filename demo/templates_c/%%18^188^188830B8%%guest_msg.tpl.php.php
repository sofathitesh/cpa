<?php /* Smarty version 2.6.26, created on 2016-12-14 00:48:21
         compiled from guest_msg.tpl.php */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl.php", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>



<!--Contents-->
<div id="content" >
<div class="gap20px">&nbsp;</div>
<div class="gap20px">&nbsp;</div>
<h4 class="heading"></h4>

<?php if ($this->_tpl_vars['error'] != ""): ?>
<div class="alert alert-danger"><?php echo $this->_tpl_vars['error']; ?>
</div>

<?php elseif ($this->_tpl_vars['success_msg'] != ""): ?>

<div class="alert alert-success"><?php echo $this->_tpl_vars['success_msg']; ?>
</div>


<?php endif; ?>



<div class="gap20px">&nbsp;</div>
<div class="gap20px">&nbsp;</div>
<div class="gap20px">&nbsp;</div>
<div class="gap20px">&nbsp;</div>

<div class="gap20px">&nbsp;</div>
<div class="gap20px">&nbsp;</div>


</div>
<!--End Contents-->


<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl.php", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
