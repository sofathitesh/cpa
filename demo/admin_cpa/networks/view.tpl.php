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
<h3><?=$name?></h3>

<div style="width:250px">


<form action="index.php?m=networks&view=<?=$id?>" method="post" class="formFormat">
<input type="hidden" name="id" value="<?=$id?>" />
<input type="hidden" name="oldname" value="<?=$name?>" />

<div class="form-group">
<label>Name</label><input type="text" name="network_name" value="<?=$name?>" class="form-control"  />
</div>

<div class="form-group">
<label>Status</label><select name="status" class="form-control"><?=selection($row->active)?></select>
</div>
<input type="submit" name="update" value="Update network" class="btn btn-primary" />  <a href="javascript:void(0)" class="btn btn-warning" onclick="deleteIt('index.php?m=networks&amp;delete=<?=$id?>', 'Are you sure you want to delete this network?')">Delete</a>

</form>
</div>