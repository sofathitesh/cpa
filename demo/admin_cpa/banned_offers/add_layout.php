<h3>Ban Campaign</h3>
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

if(isset($_GET['camp']))
{
	$campaignId = safeGet($_GET['camp']);
}

if(isset($_GET['network']))
{
	$network = safeGet($_GET['network']);
}

?>

<div style="width:200px">
<form action="index.php?m=banned_offers&add=1" method="post">
<div class="form-group">
<label>Network</label>
<select name="network" class="form-control"><option value="0">Select Network</option><?=getNetworks($network)?></select>
</div>

<div class="form-group">
<label>Network Campaign ID</label>
<input type="text" name="camp_id" value="<?=$campaignId?>" class="form-control"  />
</div>
<input type="submit" name="addOffer" value="Ban Offer" class="btn btn-primary" />
</form>
</div>