<?php /* Smarty version 2.6.26, created on 2016-12-15 13:42:32
         compiled from account.tpl.php */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl.php", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>


<!--Page Title and User earnings overview-->
<div id="page_header">

<div class="pageTitle">
Account Information
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
<?php if ($this->_tpl_vars['error'] != ""): ?>
<div class="alert alert-danger"> <img src="templates/images/cross.gif" alt="" />  <?php echo $this->_tpl_vars['error']; ?>
</div>
<?php elseif ($this->_tpl_vars['success'] != ""): ?>
<div class="alert alert-success"> <img src="templates/images/tick.gif"  alt="" />  <?php echo $this->_tpl_vars['success']; ?>
</div>
<?php endif; ?>

<style type="text/css">
<?php echo '
.labelField{width:200px;}
'; ?>

</style>

<form action="account.php" method="post">
<input type="hidden" name="update" value="1" />
<h4>Account Information</h4>

<div class="clear">
<table class="table">

<tr>
    <td class="labelField">First Name</td> <td><?php echo $this->_tpl_vars['firstname']; ?>
</td>

    <td class="labelField">Last Name</td> <td><?php echo $this->_tpl_vars['lastname']; ?>
</td>
</tr>


<tr>
    <td class="labelField">Email Address</td> <td colspan="3"><?php echo $this->_tpl_vars['email_address']; ?>
</td>
</tr>

<tr>
    <td class="labelField">Home Address</td> <td><?php echo $this->_tpl_vars['address']; ?>
</td>
    <td class="labelField">City/Town</td> <td><?php echo $this->_tpl_vars['city']; ?>
</td>
</tr>

<tr>
    <td class="labelField">State/Province</td> <td><?php echo $this->_tpl_vars['state']; ?>
</td>
    <td class="labelField">Zip/Postal Code</td> <td><?php echo $this->_tpl_vars['zip']; ?>
</td>
</tr>

<tr>
    <td class="labelField">Country</td> <td colspan="3"><?php echo $this->_tpl_vars['country']; ?>
</td>
</tr>


<tr>
    <td class="labelField">Website</td> <td colspan="3"><?php echo $this->_tpl_vars['websites']; ?>
</td>

</tr>


</table>
</div>

<div class="gap20px">&nbsp;</div>

<h4>Payment Information</h4>

<div class="clear">
<table class="table">

<tr>
    <td class="labelField">Payment Method</td> <td><?php echo $this->_tpl_vars['payment_method']; ?>
</td>

    <td class="labelField">Payment Cycle</td> <td><?php echo $this->_tpl_vars['pay_cycle']; ?>
</td>
</tr>

<tr>
    <td class="labelField">Payment Method Details</td> <td colspan="3"><?php echo $this->_tpl_vars['payment_method_details']; ?>
</td>


</tr>


</table>
</div>


<div class="gap20px">&nbsp;</div>

<h4>Password Change</h4>

<div class="clear">
<table class="table">

<tr>
    <td class="labelField">Old Password </td> <td colspan="3"><input type="password" name="oldpassword" autocomplete="off"  class="form-control" style="width:200px; height:20px;" /></td>
</tr>

<tr>
    <td class="labelField">New Password </td> <td><input type="password" name="newpassword"  class="form-control" style="width:200px; height:20px;" /></td>
    <td class="labelField">Confirm Password</td> <td><input type="password" name="confirm_password"  class="form-control" style="width:200px; height:20px;"  /></td>
</tr>

</tr>


</table>
</div>

<div class="right" style="margin-right:150px">
<input type="submit" class="btn btn-default" name="update_btn" onclick="if(!confirm('Are you sure you want to update account?')) return false;" value="Update Account" />
</div>


</form>


    
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