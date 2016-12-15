<?php /* Smarty version 2.6.26, created on 2016-12-15 23:12:54
         compiled from compose.tpl.php */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl.php", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>


<!--Page Title and User earnings overview-->
<div id="page_header">

<div class="pageTitle">
Write to Admin
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



<div class="clear">
<br />



<form action="sendmessage.php" method="post">
<table cellspacing="10" class="table table-noborder" style="width:450px">

<?php if ($this->_tpl_vars['error_msg'] != ""): ?>
<tr><td ><div class="alert alert-danger"><?php echo $this->_tpl_vars['error_msg']; ?>
</div></td></tr>
<?php elseif ($this->_tpl_vars['success_msg'] != ""): ?>
<tr><td ><div class="alert alert-success"><?php echo $this->_tpl_vars['success_msg']; ?>
</div></td></tr>
<?php endif; ?>



<tr><td><h6>Subject</h6></td></tr>
<tr><td><input type="text" name="subject" maxlength="250" value="<?php echo $this->_tpl_vars['subject']; ?>
" class="form-control"  style="width:250px;" /></td></tr>
<tr><td><h6>Message</h6></td></tr>
<tr><td><textarea name="message" class="form-control" style="width:370px; resize:none; height:180px;"><?php echo $this->_tpl_vars['message']; ?>
</textarea></td></tr>
<tr><td><input type="button" onclick="window.location = 'messages.php'" name="cancel" class="btn btn-default" value="Cancel" /> &nbsp; <input type="submit" name="send"  class="btn btn-primary" value="Send" /></td></tr>







</table>
</form>




<br />





</div>
<!--End Contents-->

</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl.php", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>