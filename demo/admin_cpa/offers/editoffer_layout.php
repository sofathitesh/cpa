<?php
if(!empty($error))
{
    echo "<div style=\"font-size:12px; color:#FF0000\">".$error."</div>";
	$error = '';
}
?>
<br />

<b><?=$name?></b>



<form action="index.php?m=offers&view=<?=$oid?>" method="post" enctype="multipart/form-data">
<input type="hidden" name="oid" value="<?=$oid?>" />
<table cellspacing="5" class="table table-noborder" style="width:600px;">
<tr><td>Offer Name</td><td><input type="text" name="oname" class="form-control" value="<?=stripslashes($name)?>"  /></td></tr>
<tr><td>Description</td><td><textarea name="desc" class="form-control"  ><?=stripslashes($desc)?></textarea></td></tr>
<tr><td>Link</td><td><input type="text" name="link" class="form-control"  value="<?=$link?>"  /></td></tr>
<tr><td>Submission Limit</td><td><input type="text" class="form-control"  name="limit" value="<?=$limit?>"  /></td></tr>

<tr><td>Payout</td><td> <input type="text" name="reward" value="<?=$reward?>" class="form-control"   /></td></tr>
<tr><td>Countries</td><td><select name="countries[]" multiple="multiple" class="form-control" style="height:200px" ><option value="0">All Countries</option><?=getCountries($countries)?></select></td></tr>
<tr><td>Network</td><td><select name="network" class="form-control" ><option value="0">Select Network</option><?=getNetworks($network)?></select></td></tr>
<tr><td>Network Campaign ID</td><td><input type="text" name="camp_id" class="form-control"  value="<?=$campaignId?>"  /></td></tr>
<tr><td>Status</td><td><select name="status" class="form-control" ><?=selection($status)?></select></td></tr>

<tr><td>UA Target</td><td><input type="checkbox" name="ua[Windows]" <?php if(isset($ua['Windows'])) echo "checked=\"checked\""; ?> value="Windows" /> Windows &nbsp; <input type="checkbox" name="ua[Android]" <?php if(isset($ua['Android'])) echo "checked=\"checked\""; ?> value="Android" /> Android &nbsp; <input type="checkbox" name="ua[iPhone]" <?php if(isset($ua['iPhone'])) echo "checked=\"checked\""; ?> value="iPhone" /> iPhone &nbsp; <input type="checkbox" name="ua[iPad]" <?php if(isset($ua['iPad'])) echo "checked=\"checked\""; ?> value="iPad" /> iPad &nbsp; <input type="checkbox" name="ua[All All]" <?php if(isset($ua['All'])) echo "checked=\"checked\""; ?> value="All" /> All   </td></tr>


<tr><td>Category / Categories</td><td> <input type="text" name="category"  class="form-control"  value="<?=$category?>"  /></td></tr>


<tr><td>Epc</td><td><input type="text" name="epc" value="<?=$epc?>" class="form-control"  /></td></tr>
<tr><td>Clicks</td><td><input type="text" name="hits" value="<?=$hits?>" class="form-control"  /></td></tr>
<tr><td>Leads</td><td><input type="text" name="leads" value="<?=$leads?>" class="form-control"  /></td></tr>
<tr><td colspan="2" style="text-align:right; padding-top:8px"><input type="submit" name="update" value="Update offers" /></td></tr>
</table>
</form>
