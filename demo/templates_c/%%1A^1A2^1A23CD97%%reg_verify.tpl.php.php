<?php /* Smarty version 2.6.26, created on 2016-12-14 10:48:23
         compiled from reg_verify.tpl.php */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl.php", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>




<!--Page Contents Wrapper-->
<div class="page_contents_wrapper">



<div class="form_layout" style="width:740px; padding-top:75px;">

    <div class="reg_success">
    <br />
    
    <p>
    <?php if ($this->_tpl_vars['success_msg'] != ""): ?>


     <div class="alert alert-success" ><img src="templates/images/tick.gif" alt="" /> &nbsp;<?php echo $this->_tpl_vars['success_msg']; ?>
</div>

    
    <?php elseif ($this->_tpl_vars['error_msg']): ?>
    
    <div class="alert alert-danger" ><img src="templates/images/cross.gif" alt="" /> &nbsp;<?php echo $this->_tpl_vars['error_msg']; ?>
</div>    
    
    <?php endif; ?>    
    <br />
   </p>

     </div>
     
     
<div class="gap20px">&nbsp;</div>
<div class="gap20px">&nbsp;</div>
<div class="gap20px">&nbsp;</div>
<div class="gap20px">&nbsp;</div>
<div class="gap20px">&nbsp;</div>
<div class="gap20px">&nbsp;</div>
<div class="gap20px">&nbsp;</div>
<div class="gap20px">&nbsp;</div>
<div class="gap20px">&nbsp;</div>
<div class="gap20px">&nbsp;</div>
<div class="gap20px">&nbsp;</div>
     




</div>





</div>
<!--End Contents-->



<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl.php", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>