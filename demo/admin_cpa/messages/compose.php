
<?php

if(empty($receivers))
{

?>

<form action="index.php?m=messages&action=send&receiver=<?=$receiver?>" method="post">

<table cellspacing="10" style="width:650px" class="table">

<?php

 if($receiver == "all"){

?>
<input type="hidden" name="receiver" value="<?=$receiver?>" />
<tr><td>Receiver Email</td><td><?=$receiver?></td></tr>

<? }else{ ?>

<tr><td>Receiver Email</td><td><input type="text" name="receiver" value="<?=$receiver?>" /></td></tr>

<? } ?>

<tr><td>Subject</td><td><input type="text" name="subject" maxlength="250" value="<?=$subj?>" style="width:250px;" /></td></tr>
<tr><td>Message</td><td><textarea name="message" style="width:400px; height:250px;"><?=$_POST['message']?></textarea></td></tr>
<tr><td colspan="2" style="text-align:right"><input type="submit" name="send" class="btn btn-info" value="Send" /></td></tr>

</table>
</form>

<?php

}else{
	
	?>
	
 
<form action="index.php?m=messages&action=send" method="post">
<?php

foreach($receivers as $usr)
{
?>
     <input type="hidden" name="receivers[]" value="<?=$usr?>" />
<?php
}

?>

<table cellspacing="10" class="table">
<tr><td>Receiver Email</td><td>Selected Users</td></tr>
<tr><td>Subject</td><td><input type="text" name="subject" maxlength="250" value="<?=$subj?>" style="width:250px;" /></td></tr>
<tr><td>Message</td><td><textarea name="message" style="width:400px; height:250px;"><?=$_POST['message']?></textarea></td></tr>
<tr><td colspan="2" style="text-align:right"><input type="submit" class="btn btn-info" name="send" value="Send" /></td></tr>

</table>
</form> 
 
<?php
	
}

?>