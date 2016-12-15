<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="{$SITE_URL}templates/css/bootstrap_v3.css" rel="stylesheet" type="text/css" />
</head>

<body>

<div class="panel panel-default" style="margin:0">
<div class="panel-body">



<h3>{$offer_name}</h3> 
<br />
<p>{$offer_desc}</p>
<p>


<b>Tracking Link</b><br />
<input type="text" value="{$SITE_URL}click.php?camp={$offer_id}&pubid={$uid}&" class="form-control">
</p>


<br />

<p><b>Payout:</b> ${$payout}</p>
<p><b>EPC:</b> {$epc}</p>

<p><b>Platforms Supported:</b> {$browsers}</p>
<p><b>Category:</b> {$category}</p>





</div>

</div>


</body>

</html>