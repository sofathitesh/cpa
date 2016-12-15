<div style="font-size:14px; font-weight:bold;">Add a Offer</div>
<?php
if (eregi("addoffer_layout.php",$HTTP_SERVER_VARS['PHP_SELF']) || eregi("addoffer_layout.php",$_SERVER['PHP_SELF'])) {
	echo "<html>\r\n<head>\r\n<title>Invalid Access</title>\r\n</head>\r\n<body><h3>Invalid Access</h3>\r\nInvalid Access of this file is forbidden.\r\n</body>\r\n</html>";
	exit;
}
if(isset($_SESSION['error']) || isset($error))
{
    if(isset($_SESSION['error']) && !isset($error))
	{
	    $error = $_SESSION['error'];
	}
    echo "<div class=\"alert alert-danger\">".$error."</div>";
	unset($_SESSION['error']);
}elseif(isset($_SESSION['msg']))
{
    echo "<div class=\"alert alert-success\">".$_SESSION['msg']."</div>";
	unset($_SESSION['msg']);

}
?>
<form action="index.php?m=offers&add=1" method="post" enctype="multipart/form-data">
<table cellspacing="5" class="table table-noborder" style="width:600px;">
<tr><td>Offer Name</td><td><input type="text" name="oname" class="form-control" value="<?=stripslashes($name)?>"  /></td></tr>
<tr><td>Description</td><td><textarea name="desc" class="form-control"  ><?=stripslashes($desc)?></textarea></td></tr>
<tr><td>Link</td><td><input type="text" name="link" class="form-control"  value="<?=$link?>"  /></td></tr>
<tr><td>Submission Limit</td><td><input type="text" class="form-control"  name="limit" value="<?=$limit?>"  /></td></tr>

<tr><td>Payout</td><td> <input type="text" name="reward" value="<?=$credits?>" class="form-control"   /></td></tr>
<tr><td>Countries</td><td><select name="countries[]" multiple="multiple" class="form-control" style="height:200px" ><option value="0">All Countries</option><?=getCountries($countries)?></select></td></tr>
<tr><td>Network</td><td><select name="network" class="form-control" ><option value="0">Select Network</option><?=getNetworks($network)?></select></td></tr>
<tr><td>Network Campaign ID</td><td><input type="text" name="camp_id" class="form-control"  value="<?=$campaignId?>"  /></td></tr>
<tr><td>Status</td><td><select name="status" class="form-control" ><?=selection($status)?></select></td></tr>

<tr><td>UA Target</td><td><input type="checkbox" name="ua[Windows]" <?php if(isset($ua['Windows'])) echo "checked=\"checked\""; ?> value="Windows" /> Windows &nbsp; <input type="checkbox" name="ua[Android]" <?php if(isset($ua['Android'])) echo "checked=\"checked\""; ?> value="Android" /> Android &nbsp; <input type="checkbox" name="ua[iPhone]" <?php if(isset($ua['iPhone'])) echo "checked=\"checked\""; ?> value="iPhone" /> iPhone &nbsp; <input type="checkbox" name="ua[iPad]" <?php if(isset($ua['iPad'])) echo "checked=\"checked\""; ?> value="iPad" /> iPad &nbsp; <input type="checkbox" name="ua[All All]" <?php if(isset($ua['All'])) echo "checked=\"checked\""; ?> value="All" /> All   </td></tr>


<tr><td>Category / Categories</td><td> <input type="text" name="category"  class="form-control"  value="<?=$category?>"  /></td></tr>


<tr><td>Epc</td><td><input type="text" name="epc" value="<?=$epc?>" class="form-control"  /></td></tr>
<tr><td>Clicks</td><td><input type="text" name="hits" value="<?=$hits?>" class="form-control"  /></td></tr>
<tr><td>Leads</td><td><input type="text" name="leads" value="<?=$leads?>" class="form-control"  /></td></tr>
<tr><td colspan="2" style="text-align:right; padding-top:8px"><input type="submit" class="btn btn-default" name="addOffer" value="Add Offer" /></td></tr>
</table>
</form>