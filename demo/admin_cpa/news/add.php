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
if(isset($_GET['id']))
{
  $id = makesafe($_GET['id']);
}


if(isset($_POST['addNews']))
{

		$title = makesafe($_POST['title']);
		$desc = makesafe($_POST['desc']);
		$author = makesafe($_POST['author']);
		$img = makesafe($_POST['img']);		
		
		
		if(empty($title) || empty($desc))
		{
		    
			$error = "all fields required.";
			
			include("add.php");
			return;			
		}
		


	

		if(mysql_query("INSERT INTO news VALUES(NULL, '$title', '$author',  '$desc', NOW(), '$img')"))
		{
			$_SESSION['msg'] = '<div class="well">News added successfully</div>';
			header("location: index.php?m=news");
			exit;
		}else
		{
			$_SESSION['error'] = "Error occured while adding news.";
			header("location: index.php?m=news");
			exit;
		}

}

?>
<form action="index.php?m=news&action=add" method="post">

<table class="table">
<tr><td>Title</td><td><input type="text" name="title" value="<?=$title?>"  maxlength="250" /></td></tr>
<!--<tr><td>Writter Name</td><td><input type="text" name="author" value="<?=$author?>"  maxlength="250" /></td></tr>
<tr><td>Image URL:</td><td><input type="text" name="img" value="<?=$img?>"  maxlength="250" /></td></tr>-->
<tr><td>News Description</td><td><textarea name="desc" style="width:305px; height:200px;"><?=$desc?></textarea></td></tr>

<tr><td colspan="2" style="text-align:right; padding-top:8px"><input type="submit" name="addNews" class="btn btn-danger" value="Create News" /></td></tr>
</table>
</form>

	
