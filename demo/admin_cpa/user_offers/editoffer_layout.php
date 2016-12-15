<?php
if(!empty($error))
{
    echo "<div style=\"font-size:12px; color:#FF0000\">".$error."</div>";
	$error = '';
}
?>
<br />

<b><?=$name?></b>



<form action="index.php?m=u_offers&view=<?=$oid?>" method="post" enctype="multipart/form-data">
<input type="hidden" name="oid" value="<?=$oid?>" />
<table cellspacing="5">
<tr><td>UID</td><td><?=$uid?></td></tr>
<tr><td>Offer Name</td><td><input type="text" name="oname" value="<?=stripslashes($name)?>"  /></td></tr>
<tr><td>Description</td><td><textarea name="desc" style="width:200px; height:60px"><?=stripslashes($desc)?></textarea></td></tr>
<tr><td>Link</td><td><input type="text" name="link" value="<?=$link?>"  /></td></tr>
<tr><td>Submission Limit</td><td><input type="text" name="limit" value="<?=$limit?>"  /></td></tr>

<tr><td>Payout</td><td> <input type="text" name="reward" value="<?=$reward?>"  /></td></tr>
<tr><td>Countries</td><td><select name="countries[]" multiple="multiple" size="10" style="height:200px" ><option value="0">All Countries</option><?=getCountries($countries)?></select></td></tr>
<tr><td>Network</td><td>User</td></tr>
<tr><td>Network Campaign ID</td><td><?=$campaignId?></td></tr>
<tr><td>Status</td><td><select name="status"><?=selection($status)?></select></td></tr>
<tr><td>UA Target</td><td><input type="checkbox" name="ua[Windows All]" <?php if(isset($ua['Windows'])) echo "checked=\"checked\""; ?> value="Windows" /> Windows &nbsp; <input type="checkbox" name="ua[Android]" <?php if(isset($ua['Android'])) echo "checked=\"checked\""; ?> value="Android" /> Android &nbsp; <input type="checkbox" name="ua[iPhone]" <?php if(isset($ua['iPhone'])) echo "checked=\"checked\""; ?> value="iPhone" /> iPhone &nbsp; <input type="checkbox" name="ua[iPad]" <?php if(isset($ua['iPad'])) echo "checked=\"checked\""; ?> value="iPad" /> iPad &nbsp; <input type="checkbox" name="ua[All]" <?php if(isset($ua['All'])) echo "checked=\"checked\""; ?> value="All" /> All   </td></tr>


<tr><td>Category / Categories</td><td> <input type="text" name="category" value="<?=$category?>"  /></td></tr>


<tr><td>Epc</td><td><input type="text" name="epc" value="<?=$epc?>" /></td></tr>
<tr><td>Clicks</td><td><input type="text" name="hits" value="<?=$hits?>" /></td></tr>
<tr><td>Leads</td><td><input type="text" name="leads" value="<?=$leads?>" /></td></tr>
<tr><td colspan="2" style="text-align:right; padding-top:8px"><input type="submit" name="update" value="Update offers" /></td></tr>
</table>
</form>
