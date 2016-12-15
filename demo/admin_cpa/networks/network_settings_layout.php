<form  action="index.php?m=networks&m2=settings" method="post">

<h3>Auto APIs / Offer Feeds Setup</h3>
<br />

<table class="table">



<?php
if(!empty($success))
{

?>
<tr>
<td colspan="2" style="font-size:12px; color:#0000FF"><?=$success?></td>
</tr>
<?
}elseif(!empty($error))
{
?>
<tr>
<td colspan="2" style="font-size:12px; color:#FF0000"><?=$error?></td>
</tr>
<?  
}
?>

<tr>
<td colspan="2"><b>Adscendmedia Settings</b></td>
</tr>
<tr>
<td>Publisher ID</td><td><input type="text" name="adscend_pub_id" value="<?=$adscend_pub_id?>" style="width:250px; height:23px; font-weight:bold; padding:2px;" /></td></tr>
<tr><td>API Key</td><td><input type="text" name="adscend_key" value="<?=$adscend_key?>"  style="width:250px; height:23px; font-weight:bold; padding:2px;" /></td>
</tr>


<tr>
<td colspan="2"><b>Adworkmedia Settings</b></td>
</tr>
<tr>
<td>Offer Feed URL<br /><span style="font-size:11px;">(including your pub id and api id.)</span></td><td><input type="text" name="adwork_url" value="<?=$adwork_url?>"  style="width:250px; height:23px; font-weight:bold; padding:2px;" /></td>
</tr>


<tr>
<td colspan="2"><b>Adgatemedia Settings</b></td>
</tr>
<tr>
<td>Offer Feed URL<br /><span style="font-size:11px;">(including your api id.)</span></td><td><input type="text" name="adgate_url" value="<?=$adgate_url?>"  style="width:250px; height:23px; font-weight:bold; padding:2px;" /></td>
</tr>

<tr>
<td colspan="2"><b>CPALead Settings</b></td>
</tr>
<tr>
<td>Offer Feed URL</td><td><input type="text" name="cpalead_url" value="<?=$cpalead_url?>"  style="width:250px; height:23px; font-weight:bold; padding:2px;" /></td>
</tr>


<tr>
<td colspan="2"><b>CPAGrip Settings</b></td>
</tr>
<tr>
<td>Offer Feed URL</td><td><input type="text" name="cpagrip_url" value="<?=$cpagrip_url?>"  style="width:250px; height:23px; font-weight:bold; padding:2px;" /></td>
</tr>


<tr>
<td colspan="2"><b>BlueTrackMedia Settings</b></td>
</tr>
<tr>
<td>Offer Feed URL</td><td><input type="text" name="bluetrackmedia_url" value="<?=$bluetrackmedia_url?>"  style="width:250px; height:23px; font-weight:bold; padding:2px;" /></td>
</tr>


<tr>
<td colspan="2"><b>FiralMedia Settings</b></td>
</tr>
<tr>
<td>Offer API Key</td><td><input type="text" name="firalmedia_url" value="<?=$firalmedia_url?>"  style="width:250px; height:23px; font-weight:bold; padding:2px;" /></td>
</tr>





<tr>
<td colspan="2"><input type="submit" name="save" class="btn btn-primary" value="Save Settings" /> <a class="btn btn-info" href="index.php?m=networks">Back to Networks</a></td>
</tr>

</table>

</form>