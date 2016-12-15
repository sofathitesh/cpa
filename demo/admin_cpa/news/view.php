<?php
if(!isset($_GET['view']))
{
    echo "Invalid news Id";
	return;
}

if(isset($_SESSION['error']))
{
    echo "<div style=\"font-size:12px; color:#FF0000\">".$_SESSION['error']."</div>";
	unset($_SESSION['error']);
}elseif(isset($_SESSION['msg']))
{
    echo "<div style=\"font-size:12px; color:#0000FF\">".$_SESSION['msg']."</div>";
	unset($_SESSION['msg']);

}


if(isset($_POST['editNews']))
{

    $title = makesafe($_POST['title']);	
	$desc =  makesafe($_POST['desc']);	
    $author = makesafe($_POST['author']);
	$img = makesafe($_POST['img']);
	
	
	if($_GET['view'] != $_POST['id'])
	{
	   die("Invalid Actions");
	}
	
	$id = makesafe($_POST['id']);
	

	if(empty($title) || empty($desc))
	{
	    $_SESSION['error'] = "All fields are required.";
		header("location: index.php?m=news&view=$id");
		exit;	
	}
	

	$update = mysql_query("UPDATE news SET title = '$title', description = '$desc', written_by = '$author', img = '$img' WHERE id = $id");
	if($update)
	{
	    $_SESSION['msg'] = "News updated successfully.";
		header("location: index.php?m=news&view=$id");
		exit;
	}else
	{
	    $_SESSION['error'] = "Error occured while updating news.";
		header("location: index.php?m=news&view=$id");
		exit;
	
	}
	
    return;
}

$id = makesafe($_GET['view']);
$sql = mysql_query("SELECT * FROM news WHERE id = $id");
if(!mysql_num_rows($sql))
{
    echo "Invalid News";
	return;
}

$row = mysql_fetch_object($sql);
$title = stripslashes($row->title);
$desc = stripslashes($row->description);
$img = stripslashes($row->img);
$author = stripslashes($row->written_by);

?>

<form action="index.php?m=news&view=<?=$id?>" method="post">
<input type="hidden" name="id" value="<?=$id?>" />
<table class="settings_table" cellspacing="10">
<tr><td>Title</td><td><input type="text" name="title" value="<?=$title?>"  /></td></tr>
<!--<tr><td>Writter Name</td><td><input type="text" name="author" value="<?=$author?>"  maxlength="250" /></td></tr>
<tr><td>Image URL:</td><td><input type="text" name="img" value="<?=$img?>"  maxlength="250" /></td></tr>-->
<tr><td>Description</td><td><textarea name="desc" style="width:305px; height:200px;"><?=$desc?></textarea></td></tr>
<tr><td colspan="2" style="text-align:right; padding-top:8px"><input type="submit" name="editNews" value="Edit News" /> | <a href="index.php?m=news">Go Back</a></td></tr>
</table>
</form>
