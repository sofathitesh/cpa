{include file="header.tpl.php"}


<!--Page Title and User earnings overview-->
<div id="page_header">

<div class="pageTitle">
Offers API
</div>


<div class="liveCounters">

{include file="live_counters.tpl.php"}

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
    <input type="text"  class="form-control api_field"  value="{$SITE_URL}offer_feed.php?pubid={$uid}"  /> 
    <input type="button" name="dwv" class="btn btn-default" onclick="window.location = '{$SITE_URL}offer_feed.php?pubid={$uid}&export=csv'" value="Download CSV" />
    </div>
    
    
    <div class="form-group">
    <h6>Your Offer Feed URL (with offer count limit)</h6>
    <input type="text"  class="form-control api_field"  value="{$SITE_URL}offer_feed.php?pubid={$uid}&limit=50" id="lmq"  />
    <input type="button" name="dwv" class="btn btn-default" onclick="window.location = $('#lmq').val()+'&export=csv';"  value="Download CSV" />
    </div>    


    <div class="form-group">
    <h6>Your Offer Feed URL (with country code)</h6>
    <input type="text"  class="form-control api_field"  value="{$SITE_URL}offer_feed.php?pubid={$uid}&country=US" id="ccqm"  />
    <input type="button" name="dwv" class="btn btn-default" value="Download CSV" onclick="window.location = $('#ccqm').val()+'&export=csv';"  />
    </div>  
    
    <div class="form-group">
    <h6>Your Offer Feed URL (with Device Target)</h6>
    <input type="text"  class="form-control api_field"  value="{$SITE_URL}offer_feed.php?pubid={$uid}&target=Android"  id="dvq"  />
    <input type="button" name="dwv" class="btn btn-default" value="Download CSV" onclick="window.location = $('#dvq').val()+'&export=csv';" />
    </div>      
    
    
           


   </div>

</div>



<div class="gap20px">&nbsp;</div>







{literal}
<script type="text/javascript">

$('.editPB').click(function(e){

 e.preventDefault();
 $('#pburl').val($('#currentPB').text());
 
 	
});

</script>
{/literal}



    






</div></div>
<!--End Contents-->


{include file="footer.tpl.php"}