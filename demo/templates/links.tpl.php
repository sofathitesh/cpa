{include file="header.tpl.php"}


<!--Page Title and User earnings overview-->
<div id="page_header">

<div class="pageTitle">
Links Manager
</div>


<div class="liveCounters">

{include file="live_counters.tpl.php"}

</div>


</div>
<!--End Page Title and User eanrings overview-->

<!--Contents-->
<div id="content" >
<br />

<a href="upload_link.php" class="btn btn-info">Create New Link</a>
<br />


<br />


<div class="listing">

 <form action="links.php" method="post" id="form1" >
 <div class="clear">
  <table cellspacing="0" style="width:900px;" class="table table-bordered table-hovere table-condensed">
  <tr>
      <th style="width:25px; text-align:center"><input style="margin-top:2px;" type="checkbox" id="checkAll" onclick="CheckAll('form1')" /></th> <th>Link Destination</th><th>Download Link</th><th style="width:50px">Clicks</th><th style="width:50px">Leads</th><th style="text-align:right;  padding-right:0;">&nbsp;</th>
  </tr>
  {if $files ne ""}
  {foreach item=file from=$files}
	  
	  <tr style="background: {cycle name=rows values="#ffffff, #f6f6f6"}; height:22px; border-bottom:1px solid #eee;"><td style="text-align:center"><input type="checkbox" name="ids[]" value="{$file.id}" style="vertical-align:middle" onclick="uncheckCheckAllbox(this)" /></td><td>{$file.full_link}</td> <td>{$SITE_URL|@urldecode}lnk/{$file.fcode}</td>                      
      
      </td><td>{$file.hits}</td><td>{$file.downloads}</td><td style="text-align:center"><a href="links.php?link={$file.id}" class="btn btn-info btn-sm">Details</a></td></tr>
	  
	  {/foreach}
  {/if}
  



</table>
</div>



<div style="width:900px; clear:both;">
<div class="left"><div style="margin-top:7px;">{if $records ne "" }&nbsp;<b>{$records}</b> Link(s), page <b>{$page}</b> of <b>{$pages}</b> {else} No link uploaded. {/if}{$firstpage} {$previouspage} {$nextpage} {$lastpage}&nbsp;</div></div>

<div class="right"><input type="submit" name="delete" value="Delete" class="btn btn-primary" style="margin-top:7px;" onclick="if(!confirm('Are you sure you want to delete selected links?')) return false;" /></div>
</div>
</form>


  


{literal}
<script type="text/javascript">
$(document).ready(function(){

$('.listing_row').hover(function(){ $(this).css('background-color', '#f6f6f6'); }, function(){ $(this).css('background-color', '#ffffff'); });
  $('#cboxClose').remove();
	 
   $('.file_d').colorbox({iframe:true, innerWidth:600, innerHeight:550, scrolling: false});	 

});
</script>
{/literal}



</div>
<!--End Files Container-->



</div>
<!--End Right Contents-->


<div class="gap20px">&nbsp;</div>
<div class="gap20px">&nbsp;</div>
<div class="gap20px">&nbsp;</div>


</div>
<!--End Contents-->


{include file="footer.tpl.php"}