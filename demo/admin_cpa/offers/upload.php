<br />
<div style="font-size:14px; margin-left:10px; font-weight:bold;">Parse Adscendmedia CSV File</div>
<?php

if(isset($_SESSION['error']) || isset($error))
{
    if(isset($_SESSION['error']) && !isset($error))
	{
	    $error = $_SESSION['error'];
	}
    echo "<div style=\"font-size:12px; margin-left:10px; color:#FF0000\">".$error."</div>";
	unset($_SESSION['error']);
}elseif(isset($_SESSION['msg']))
{
    echo "<div style=\"font-size:12px; margin-left:10px; color:#0000FF\">".$_SESSION['msg']."</div>";
	unset($_SESSION['msg']);

}
?>


<form action="index.php?m=offers&parseCsv=1" enctype="multipart/form-data" method="post">
<input type="hidden" name="m" value="offers" />
<input type="hidden" name="parseCsv" value="1" />
<table cellspacing="10">
<tr><td>Upload CSV </td><td><input type="file" name="csv"  /> </td></tr>
<tr><td>&nbsp;</td><td><input type="submit" name="parse" value="Parse Now" /></td></tr>
</table>
</form>

<br /><br /><br /><br /><br /><br />