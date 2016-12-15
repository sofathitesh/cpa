
<?php
if (eregi("settings_layout.php",$HTTP_SERVER_VARS['PHP_SELF']) || eregi("settings_layout.php",$_SERVER['PHP_SELF'])) {
	echo "<html>\r\n<head>\r\n<title>Invalid Access</title>\r\n</head>\r\n<body><h3>Invalid Access</h3>\r\nInvalid Access of this file is forbidden.\r\n</body>\r\n</html>";
	exit;
}

?>
<?php
if(isset($_SESSION['error']))
{
    echo "<div style=\"font-size:12px;  margin-left:7px; color:#FF0000\">".$_SESSION['error']."</div>";
	unset($_SESSION['error']);
}elseif(isset($_SESSION['msg']))
{
    echo "<div style=\"font-size:12px; margin-left:7px; color:#0000FF\">".$_SESSION['msg']."</div>";
	unset($_SESSION['msg']);

}
?>
<div class="row">
            <div class="col-xs-12">
              <ol class="breadcrumb">
                <li>
                  <a href="index.php">Dashboard</a>
                </li>
                <li class="active">
                  <a href="#">Site Configurations</a>
                </li>
              </ol>
            </div>
          </div>

<div class="row">
            <div class="col-md-6">
              <h1>
                <span aria-hidden="true" class="icon icon-grid-big"></span>
                <span class="main-text">
                  Site Configurations
                </span>
              </h1>
            </div>
            <div class="col-md-6">
            </div>
          </div>
<form action="index.php?m=settings" method="post" class="form-inline">
<table class="table">
<tr><td style="width:350px;">&nbsp;</td><td><b><a href="index.php?m=change_password" class="btn btn-primary btn-sm">Change Admin Password</a></b></td></tr>

<tr><td>SITE NAME <div style="font-size:12px; font-style:italic; color:#999">(Only Letters, Numbers, Hyphen(-) & underscore(_)<br /> dont use Spaces. e.g: CPANetwork)</div></td><td><input type="text" class="form-control" name="site_name" value="<?=SITE_NAME?>"></td></tr>
<tr><td>SITE URL <div style="font-size:12px; font-style:italic; color:#999">Website url including http:// and end trailing slash like http://www.yoursite.com/</div></td><td><input type="text" class="form-control"  name="site_url" value="<?=SITE_URL?>" /> </td></tr>
<tr><td>SITE DESCRIPTION</td><td><input type="text" name="site_description" value="<?=SITE_DESCRIPTION?>" class="form-control"  /></td></tr>
<tr><td>SITE KEYWORDS <br />(separated by commer i.e word1, word2, word3)</td><td><input type="text" name="site_keywords" value="<?=SITE_KEYWORDS?>" class="form-control"  /></td></tr>
<tr><td>NOTIFICATION EMAIL <br />(this would be used for all notification send to users)</td><td><input type="text" name="notification_email" value="<?=NOTIFICATION_EMAIL?>" class="form-control" /></td></tr>
<tr><td>ADMIN EMAIL <br />(this would be used to send message to Admin)</td><td><input type="text" name="admin_email" value="<?=ADMIN_EMAIL?>" class="form-control" /></td></tr>


<tr><td>SIGNUPS AUTO APPROVE <div style="font-size:12px; font-style:italic; color:#999">(if you uncheck this option, you will need to approve user accounts manually)</div></td><td><input type="checkbox" name="auto_approve" value="1" <?php if(AUTO_APPROVE == 1) echo 'checked="checked"' ?>  class="form-control" style="width:auto" /></td></tr>


<tr><td>MINIMUM CASHOUT LIMIT </td><td><input type="text" name="min_cashout_limit" value="<?=MIN_CASHOUT_LIMIT?>" class="form-control" ></td></tr>




<tr><td>OFFER PAYOUT RATE <div style="font-size:12px; font-style:italic; color:#999">(How much % user will earn from each lead)</div></td><td><input type="text" name="offer_rate" value="<?=OFFER_RATE?>"  class="form-control" ></td></tr>
<tr><td>REFERRAL RATE <div style="font-size:12px; font-style:italic; color:#999">(How much % user will earn from each referral)</div></td><td><input type="text" name="referral_rate" value="<?=REFERRAL_RATE?>" class="form-control"></td></tr>

<tr><td colspan="2" style="text-align:right; padding-top:5px;"><input type="submit" name="update" class="btn btn-primary" value="UPDATE SETTINGS" /></td></tr>
</table>

</form>