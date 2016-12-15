<?php /* Smarty version 2.6.26, created on 2016-12-14 10:49:08
         compiled from reports.tpl.php */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl.php", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>


<!--Page Title and User earnings overview-->
<div id="page_header">

<div class="pageTitle">
Reports
</div>


<div class="liveCounters">

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "live_counters.tpl.php", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

</div>


</div>
<!--End Page Title and User eanrings overview-->

<!--Contents-->
<div id="content" >

<div class="gap20px">&nbsp;</div>

<!--Date Container-->
<div id="dateContainer">
<form action="reports.php" id="searchForm" method="post">
<table cellspacing="0" cellpadding="0" class="table table-bordered">

<tr>

    <td class="dslabel" style="text-align:center; vertical-align:middle">Start Date</td>
    <td class="dateCalc" ><img src="templates/images/calc.png" alt="" /></td>
    <td class="dtx"><input type="text" name="date1" id="date1" class="form-control" value="<?php echo $this->_tpl_vars['date_start']; ?>
" /></td>
    <td class="dslabel2" style="text-align:center; vertical-align:middle">End Date</td>
    <td class="dateCalc"><img src="templates/images/calc.png" alt="" /></td>
    <td class="dtx"><input type="text" name="date2" id="date2" class="form-control" value="<?php echo $this->_tpl_vars['date_end']; ?>
" /></td>
    <td class="upbtn"><input type="submit" class="btn btn-primary" value="Search" /></td>


</tr>
</table>
</form>

</div>
<!--End Date Container-->

<div class="clear">
<p class="stats_date"><?php if ($this->_tpl_vars['date_start'] != ""): ?>Showing Reports  From | <?php echo $this->_tpl_vars['date_start']; ?>
 <?php endif; ?><?php if ($this->_tpl_vars['date_end'] != ""): ?>- <?php echo $this->_tpl_vars['date_end']; ?>
<?php endif; ?> </p>
</div>


<!--Box Area-->
<div class="sub_section">

<div id="MSLine01Div" style="padding-top:10px; width:100%; margin:0 auto">Chart</div>
<script type="text/javascript" ><!--
	// Instantiate the Chart 
	<?php echo '
	if ( FusionCharts("MSLine01") && FusionCharts("MSLine01").dispose ) FusionCharts("MSLine01").dispose();
	var chart_MSLine01 = new FusionCharts( {  "swfUrl" : "Charts/v2_charts/MSLine.swf",  "width" : "100%",  "height" : "275",  "renderAt" : "MSLine01Div",  "dataFormat" : "xml",  "id" : "MSLine01",  "dataSource" : "<chart plotGradientColor=\'FFFFFF\' showBorder=\'0\' showValues=\'0\' showLegend=\'0\' showLabels=\'0\'  bgColor=\'ffffff\' canvasBgAlpha=\'0\' bgAlpha=\'0\' legendBgAlpha=\'0\' canvasBorderThickness=\'1\' connectNullData=\'1\' showYAxisValues=\'0\' canvasPadding=\'6\'  >'; ?>
<?php echo $this->_tpl_vars['categories']; ?>
<?php echo $this->_tpl_vars['earnings']; ?>
<?php echo '</chart>" } ).render();
// -->
    '; ?>

</script>

<br />


</div>
<!--End Box Area-->




<!--Detailed-->
<table cellpadding="0" cellspacing="0" border="0"  class="dataTable table table-bordered" id="dataGrid">

    <thead> 
        <tr style="text-align:center !important"> 
            <th>Date</th> 
            <th>Clicks</th> 
            <th>Leads</th> 
            <th>Revenue</th> 
            <th>Conv</th>            
            <th>Average CPA</th>
            <th>EPC</th>
        </tr> 
    </thead> 


  <tfoot> 
      <tr> 
          <th style='text-align: left'>Total/Average</th> 

          <th style='text-align: center'></th> 
          <th style='text-align: center'></th> 
          <th style='text-align: center'></th> 
          <th style='text-align: center'></th>
          <th style='text-align: center'></th>          
          <th style='text-align: center'></th>


      </tr> 
  </tfoot> 

</table>

<!--end Detailed-->




</div>




<br /><br />

<?php echo '
<script type="text/javascript">

$(document).ready(function(){


   $(\'#dataGrid\').dataTable( {
   "fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {

			
			var clicks = 0;
			var downloads = 0;
			var conv = 0;
			var avgCPA = 0;
			var epc = 0;
			var revenue = 0;
			var conv_ = 0;

			
       
		   for ( var i=0 ; i<aaData.length ; i++ )
            {
                
				clicks += parseInt(aaData[i][1]);
				downloads += parseInt(aaData[i][2]);
				conv += parseFloat(aaData[i][4]);
				avgCPA += parseFloat(aaData[i][5].substring(1));
				epc += parseFloat(aaData[i][6].substring(1));
				revenue += parseFloat(aaData[i][3].substring(1));
				

            }
			
			revenue = Math.round(revenue*100)/100;
			conv_ = (clicks == 0) ? 0 : (downloads/clicks)*100;
            //conv = conv_.toString().match(/^\\d+(?:\\.\\d{0,2})?/);
			conv = Math.round(conv_);
			avgCPA = (downloads == 0) ? 0 : Math.round((revenue/downloads)*100)/100;
			epc = (clicks == 0) ? 0 : Math.round((revenue/clicks)*100)/100;

			var nCells = nRow.getElementsByTagName(\'th\');
			nCells[1].innerHTML = clicks;
			nCells[2].innerHTML = downloads;
			nCells[3].innerHTML = \'$\'+revenue;
			nCells[4].innerHTML = conv+\'%\';
			nCells[5].innerHTML =  \'$\'+avgCPA;
			nCells[6].innerHTML =  \'$\'+epc;
        },

	   '; ?>

	   "aaData": [<?php echo $this->_tpl_vars['data']; ?>
]	 	 	 	 	 	
	   <?php echo '		  

   });
	  
	  
	  
	  
	  

	
});


</script>
'; ?>



<!--End Right Panel-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl.php", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>