<?php
if (eregi("view.php",$HTTP_SERVER_VARS['PHP_SELF']) || eregi("view.php",$_SERVER['PHP_SELF'])) {
	echo "<html>\r\n<head>\r\n<title>Invalid Access</title>\r\n</head>\r\n<body><h3>Invalid Access</h3>\r\nInvalid Access of this file is forbidden.\r\n</body>\r\n</html>";
	exit;
}
if(!isset($_GET['view']))
{
    echo "Invalid Link Id";
	return;
}

if(isset($_SESSION['error']))
{
    echo "<div style=\"font-size:12px; margin-left:10px; color:#FF0000\">".$_SESSION['error']."</div>";
	unset($_SESSION['error']);
}elseif(isset($_SESSION['msg']))
{
    echo "<div style=\"font-size:12px; margin-left:10px; color:#0000FF\">".$_SESSION['msg']."</div>";
	unset($_SESSION['msg']);

}


$id = makesafe($_GET['view']);
$sql = mysql_query("SELECT * FROM links WHERE id = '$id'  ");
if(!mysql_num_rows($sql))
{
    echo "Invalid Link";
	return;
}

$row = mysql_fetch_object($sql);
$fid = $row->id;
$link = stripslashes($row->url);
$link_desc = stripslashes($row->description);
$leads = stripslashes($row->downloads);
$last_download_date = stripslashes($row->last_download_date);
$uniqid = stripslashes($row->uniqid);
$date = date('d M, Y',strtotime($row->dateadded));
$hits = $row->hits;
$user = getUserById($row->uid);



?>



<table class="setting_table" cellspacing="10" style="width:500px">
<tr><td colspan="2"><h2>Link Details</h2></td></tr>
<tr><td>Link Url</td><td><?=$link?> [<a href="javascript:void(0)" onclick="deleteIt('index.php?m=links&amp;delete=<?=$fid?>', 'Are you sure you want to delete this link?')">Delete Link</a>]</td></tr>
<tr><td>Description</td><td><?=$link_desc?></td></tr>
<tr><td>Uploader</td><td><?=$user?></td></tr>
<tr><td>Uploaded On</td><td><?=$date?></td></tr>
<tr><td>Views</td><td><?=$hits?></td></tr>
<tr><td>Unlocks</td><td><?=$leads?></td></tr>
<tr><td>Last Time Unlocked On</td><td><?=$last_download_date?></td></tr>
</table>

