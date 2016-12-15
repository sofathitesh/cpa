<?php /* Smarty version 2.6.26, created on 2016-12-13 12:40:49
         compiled from contact.tpl.php */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl.php", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>



<!--Contents-->
<div style="width:1000px; margin:0 auto; display:table; clear:both">
<div id="contents">

<h3>Contact Us</h3>




<div class="widget-body">
<form action="contact.php" method="post">
<input type="hidden" name="register" value="register" />
<table cellspacing="10" class="table table-noborder" style="width:450px;">

<?php if ($this->_tpl_vars['error_msg'] != ""): ?>
<tr>
    <td colspan="2"><div class="alert alert-danger"><img src="<?php echo $this->_tpl_vars['SITE_URL']; ?>
templates/images/cross.gif" /> <?php echo $this->_tpl_vars['error_msg']; ?>
</div></td>
</tr>
<?php endif; ?>




<tr><td><h6>Your Name</h6></td></tr>
<tr><td><input type="text" name="name" class="form-control"  value="<?php echo $this->_tpl_vars['name']; ?>
" /></td></tr>
<tr><td><h6>Your Email </h6></td></tr>
<tr><td><input type="text" name="email"  class="form-control" value="<?php echo $this->_tpl_vars['email']; ?>
" /></td></tr>
<tr><td><h6>Subject </h6></td></tr>
<tr><td><input type="text" name="subject"  class="form-control" value="<?php echo $this->_tpl_vars['subject']; ?>
" /></td></tr>
<tr><td><h6>Message </h6></td></tr>
<tr><td><textarea name="message" class="form-control" style=" height:150px;"><?php echo $this->_tpl_vars['msg']; ?>
</textarea></td></tr>

<tr><td><img  src="includes/captcha.php" alt="" style="vertical-align:middle" /></td></tr>                      
<tr><td><h6>Security Code: </h6></td></tr>
<tr><td><input type="text"  maxlength="6" style="vertical-align:middle" name="code" class="form-control" id="code" /></td></tr>                    
<input type="hidden" name="contactSend" value="1" />
<tr><td style="text-align:left"><input type="submit" name="contactSend_btn" class="btn btn-primary" value="Send Message"  /></td></tr>





</table>
</form>

</div>

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