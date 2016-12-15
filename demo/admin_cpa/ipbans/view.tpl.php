<div style="margin-left:10px">
<?php
if(isset($_SESSION['error']) || isset($error))
{
    if(isset($_SESSION['error']) && !isset($error))
	{
	    $error = $_SESSION['error'];
	}
    echo "<div style=\"font-size:12px; color:#FF0000\">".$error."</div>";
	unset($_SESSION['error']);
}elseif(isset($_SESSION['msg']))
{
    echo "<div style=\"font-size:12px; color:#0000FF\">".$_SESSION['msg']."</div>";
	unset($_SESSION['msg']);

}
?>
</div>
<div style="margin-left:10px;"><b><?=$name?></b></div>
<form action="index.php?m=ipbans&view=<?=$ip?>" method="post" class="formFormat">
<input type="hidden" name="scope" value="Website" />
<table class="setting_table" cellspacing="10" style="width:100%">
<input type="hidden" name="oldip" value="<?=$ip?>" />
<tr><td>IP Address</td><td><input type="text" name="ip" value="<?=$ip?>"  /></td></tr>
<tr><td colspan="2" style="text-align:right; padding-top:8px"><input type="submit" name="update" value="Update IP Record" /> | <a href="index.php?m=ipbans">Go Back</a></tr>
</table>
</form>
