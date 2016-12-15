<?php /* Smarty version 2.6.26, created on 2016-12-14 10:48:55
         compiled from overview_graph.tpl.php */ ?>
<html>
<head>

<link href="<?php echo $this->_tpl_vars['SITE_URL']; ?>
templates/css/bootstrap_v3.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo $this->_tpl_vars['SITE_URL']; ?>
templates/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['SITE_URL']; ?>
templates/js/bootstrap.js"></script>
<script type="text/javascript" src="Charts/js/FusionCharts.js"></script>



</head>

<body>

<div style="font-size:12px;"> Quick Report: <a href="overview_graph.php?m=current" <?php if ($this->_tpl_vars['m'] == 'current'): ?> style="font-weight:bold" <?php endif; ?>>This Month</a> | <a href="overview_graph.php?m=last"  <?php if ($this->_tpl_vars['m'] == 'last'): ?> style="font-weight:bold" <?php endif; ?>>Last Month</a></div>
        
<div id="MSLine01Div" style="padding-top:0px; width:700px; margin:0">Chart</div>
      <script type="text/javascript" ><!--
          // Instantiate the Chart 
          <?php echo '
          if ( FusionCharts("MSLine01") && FusionCharts("MSLine01").dispose ) FusionCharts("MSLine01").dispose();
          var chart_MSLine01 = new FusionCharts( {  "swfUrl" : "Charts/v2_charts/MSLine.swf",  "width" : "700px",  "height" : "250",  "renderAt" : "MSLine01Div",  "dataFormat" : "xml",  "id" : "MSLine01",  "dataSource" : "<chart plotGradientColor=\'FFFFFF\' showBorder=\'0\' bgColor=\'ffffff\' showValues=\'0\' connectNullData=\'1\' showLegend=\'0\' canvasBgAlpha=\'0\' bgAlpha=\'0\' legendBgAlpha=\'0\'  showLabels=\'1\' canvasBorderThickness=\'0\' showYAxisValues=\'0\' canvasPadding=\'6\'  >'; ?>
<?php echo $this->_tpl_vars['categories']; ?>
<?php echo $this->_tpl_vars['earnings']; ?>
<?php echo '</chart>" } ).render();
      // -->
          '; ?>

      </script>

</body>
</html>