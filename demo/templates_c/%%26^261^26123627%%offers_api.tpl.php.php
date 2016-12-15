<?php /* Smarty version 2.6.26, created on 2016-12-14 10:51:36
         compiled from offers_api.tpl.php */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl.php", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>


<!--Page Title and User earnings overview-->
<div id="page_header">

<div class="pageTitle">
Offers API
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


<div class="widget-body">





<div class="clear">
    <div class="gap20px"></div>
<div class="alert alert-info">

<p>Here you can see your offers API urls, you can use these urls in your scripts to fetch offer feed, or download CSV files.</p>


</div>


    <div class="gap20px"></div>
    <div class="api_form">
 
 
    <div class="form-group clear">
    <h6>Your Offer Feed URL </h6>
    <input type="text"  class="form-control api_field"  value="<?php echo $this->_tpl_vars['SITE_URL']; ?>
offer_feed.php?pubid=<?php echo $this->_tpl_vars['uid']; ?>
"  /> 
    <input type="button" name="dwv" class="btn btn-default" onclick="window.location = '<?php echo $this->_tpl_vars['SITE_URL']; ?>
offer_feed.php?pubid=<?php echo $this->_tpl_vars['uid']; ?>
&export=csv'" value="Download CSV" />
    </div>
    
    
    <div class="form-group">
    <h6>Your Offer Feed URL (with offer count limit)</h6>
    <input type="text"  class="form-control api_field"  value="<?php echo $this->_tpl_vars['SITE_URL']; ?>
offer_feed.php?pubid=<?php echo $this->_tpl_vars['uid']; ?>
&limit=50" id="lmq"  />
    <input type="button" name="dwv" class="btn btn-default" onclick="window.location = $('#lmq').val()+'&export=csv';"  value="Download CSV" />
    </div>    


    <div class="form-group">
    <h6>Your Offer Feed URL (with country code)</h6>
    <input type="text"  class="form-control api_field"  value="<?php echo $this->_tpl_vars['SITE_URL']; ?>
offer_feed.php?pubid=<?php echo $this->_tpl_vars['uid']; ?>
&country=US" id="ccqm"  />
    <input type="button" name="dwv" class="btn btn-default" value="Download CSV" onclick="window.location = $('#ccqm').val()+'&export=csv';"  />
    </div>  
    
    <div class="form-group">
    <h6>Your Offer Feed URL (with Device Target)</h6>
    <input type="text"  class="form-control api_field"  value="<?php echo $this->_tpl_vars['SITE_URL']; ?>
offer_feed.php?pubid=<?php echo $this->_tpl_vars['uid']; ?>
&target=Android"  id="dvq"  />
    <input type="button" name="dwv" class="btn btn-default" value="Download CSV" onclick="window.location = $('#dvq').val()+'&export=csv';" />
    </div>      
    
    
           


   </div>

</div>



<div class="gap20px">&nbsp;</div>







<?php echo '
<script type="text/javascript">

$(\'.editPB\').click(function(e){

 e.preventDefault();
 $(\'#pburl\').val($(\'#currentPB\').text());
 
 	
});

</script>
'; ?>




    






</div></div>
<!--End Contents-->


<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl.php", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>