<br />


<b>Change Password For <?=$user?></b>
<br />

<form action="index.php?m=change_password&view=<?=$adminId?>" method="post">
<input type="hidden" name="ot" value="<?=$user?>" />

<table cellspacing="10" class="settings_table" >
<?php if(!empty($error)) {?>
<tr><td colspan="2"><div class="error"><span><?=$error?></span></div></td></tr>
<? } ?>
<?php if(!empty($msg)) {?>
<tr><td colspan="2"><div class="success"><span><?=$msg?></span></div></td></tr>
<? } ?>

<tr>

  <td style="width:30%">Change Pass</td> <td><input type="checkbox" name="changePass" value="yes" /></td>

</tr>
<tr><td>&nbsp;</td></tr>
<tr>

  <td style="width:30%">Password</td> <td><input type="password" value="" autocomplete="off" name="password" /></td>

</tr>
<tr>

  <td style="width:30%">Confirm Password</td> <td><input type="password" value="" autocomplete="off" name="password2" /></td>

</tr>


<td colspan="2" style="text-align:center"><input type="submit" onclick="if(!confirm('Are you sure you want to change admin password?')){ return false;}" name="updateAdmin" class="btn" value="Edit Account" /></td>

</tr>







</table>

</form>