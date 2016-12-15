<?php
include("includes/functions.php");
if(isset($_POST['date']) && isset($_POST['month']))
{
$date = (int) htmlentities($_POST['date']);
$month = (int) htmlentities($_POST['month']);
$prefix = htmlentities($_POST['prefix']);

if(empty($prefix))
{
  $prefix = 'expiry';
}


$dateArr = datePicker($date, $month);


?>

Day: 
<select name="<?=$prefix?>_d">
<?=$dateArr['days']?>
</select>

Month:
<select name="<?=$prefix?>_m" onchange="dateChange('<?=strtotime('now')?>',this.value);">
<?=$dateArr['months']?>
</select>


<?php

}

?>