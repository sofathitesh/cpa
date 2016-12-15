<br />

<b>New Admin Account</b>

<br />

<form action="index.php?m=admins&add=1" method="post">


<table cellspacing="10" class="settings_table" >
<?php if(!empty($error)) {?>
<tr><td colspan="2"><div class="error"><span><?=$error?></span></div></td></tr>
<? } ?>
<?php if(!empty($msg)) {?>
<tr><td colspan="2"><div class="success"><span><?=$msg?></span></div></td></tr>
<? } ?>


<tr>

  <td style="width:30%">Admin Username</td> <td><input type="text" value="" autocomplete="off" name="user" /></td>

</tr>


<tr>

  <td style="width:30%">Password</td> <td><input type="password" value="" autocomplete="off" name="password" /></td>

</tr>
<tr>

  <td style="width:30%">Confirm Password</td> <td><input type="password" value="" autocomplete="off" name="password2" /></td>

</tr>


<td colspan="2" style="text-align:center"><input type="submit"  name="create" class="btn" value="Create Account" /></td>

</tr>







</table>

</form>