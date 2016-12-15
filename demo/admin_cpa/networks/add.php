<h3>Add a network</h3>
<?php
if (eregi("add.php",$HTTP_SERVER_VARS['PHP_SELF']) || eregi("add.php",$_SERVER['PHP_SELF'])) {
	echo "<html>\r\n<head>\r\n<title>Invalid Access</title>\r\n</head>\r\n<body><h3>Invalid Access</h3>\r\nInvalid Access of this file is forbidden.\r\n</body>\r\n</html>";
	exit;
}
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
<div style="width:250px">
<form action="index.php?m=networks&add=1" method="post">
<div class="form-group">
<label>Name</label><input type="text" name="network_name" value="<?=$name?>" class="form-control"  />
</div>

<div class="form-group">
<label>Status</label><select name="status" class="form-control"><?=selection()?></select>
</div>
<input type="submit" name="addnetwork" value="Add Network" class="btn btn-primary" />
</form>

	
</div>