<?php
error_reporting(0);
$settings_sql = mysql_query("SELECT * FROM settings WHERE `option` != 'admin_user' AND `option` != 'admin_password'") or die("Website isn't installed, Please run the installer first to install site.");
if(!mysql_num_rows($settings_sql))
{
    die("Website isn't installed, Please run the installer first to install site.");
}

while($setting = mysql_fetch_object($settings_sql))
{
    define(strtoupper($setting->option), $setting->value);
}





?>