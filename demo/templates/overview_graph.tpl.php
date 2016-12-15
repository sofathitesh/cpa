<html>
<head>

<link href="{$SITE_URL}templates/css/bootstrap_v3.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{$SITE_URL}templates/js/jquery.js"></script>
<script type="text/javascript" src="{$SITE_URL}templates/js/bootstrap.js"></script>
<script type="text/javascript" src="Charts/js/FusionCharts.js"></script>



</head>

<body>

<div style="font-size:12px;"> Quick Report: <a href="overview_graph.php?m=current" {if $m eq "current"} style="font-weight:bold" {/if}>This Month</a> | <a href="overview_graph.php?m=last"  {if $m eq "last"} style="font-weight:bold" {/if}>Last Month</a></div>
        
<div id="MSLine01Div" style="padding-top:0px; width:700px; margin:0">Chart</div>
      <script type="text/javascript" ><!--
          // Instantiate the Chart 
          {literal}
          if ( FusionCharts("MSLine01") && FusionCharts("MSLine01").dispose ) FusionCharts("MSLine01").dispose();
          var chart_MSLine01 = new FusionCharts( {  "swfUrl" : "Charts/v2_charts/MSLine.swf",  "width" : "700px",  "height" : "250",  "renderAt" : "MSLine01Div",  "dataFormat" : "xml",  "id" : "MSLine01",  "dataSource" : "<chart plotGradientColor='FFFFFF' showBorder='0' bgColor='ffffff' showValues='0' connectNullData='1' showLegend='0' canvasBgAlpha='0' bgAlpha='0' legendBgAlpha='0'  showLabels='1' canvasBorderThickness='0' showYAxisValues='0' canvasPadding='6'  >{/literal}{$categories}{$earnings}{literal}</chart>" } ).render();
      // -->
          {/literal}
      </script>

</body>
</html>