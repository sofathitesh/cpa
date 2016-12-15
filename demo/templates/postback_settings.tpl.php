{include file="header.tpl.php"}


<!--Page Title and User earnings overview-->
<div id="page_header">

<div class="pageTitle">
Postback Settings
</div>


<div class="liveCounters">

{include file="live_counters.tpl.php"}

</div>


</div>
<!--End Page Title and User eanrings overview-->

<!--Contents-->
<div id="content" >
<div class="gap20px"></div>

<!--PB Documentation-->
<div class="alert alert-warning">

<p>You can set your global postback for server to server lead tracking, we will send you postback on every lead to your given url.</p>
<p>You can set your subids variable with your postback url, we automatically replace %variable% with appropriate value</p>
<p>Example:</p>
<p>www.yoursite.com/postback.php?campid=%CAMPID%&subid%SID%&status=%STATUS%&payout=%PAYOUT%</p>
<br />
<p>you can set upto 5 subids like subid=%SID%&subid2=%SID2%&subid3=%SID3% etc </p>

<br />


</div>
<!--End PB Documentation-->




<div class="clear">
<form action="postback_settings.php" method="post">
<input type="hidden" name="update" value="1" />



{if $error ne ""}
   <div class="alert alert-danger">{$error}</div>
{elseif $success ne ""}
   <div class="alert alert-success">{$success}</div>
{/if}



<div class="form-group" style="width:500px;">
<h6>Postback URL</h6>
<input type="text" name="postback_url" id="pburl"  class="form-control pb_url_field" placeholder="Ex. www.yoursite.com/tracker.php" value="" /> <input type="submit" name="addPostback" value="Set Postback" class="btn btn-primary" style="margin-top:0; vertical-align:top" />
</div>
</form>
</div>



<!--PB Info-->
{if $postback ne ""}
<div class="clear">
<div class="alert alert-info">

<table>

<tr>
<td style="width:95%; color:#333333" id="currentPB">{$postback}</td>
<td>

 <a href="#" class="editPB"><img src="templates/images/edit.png" alt="" /></a> 
 <a href="postback_settings.php?act=removePB" class="removePB"><img src="templates/images/remove.png" alt="" onclick="if(!confirm('Are you sure you want to remove postback ?')) return false;" /></a> 

</td>

</tr>

</table>

</div>
</div>
{/if}
<!--End PB Info-->






{literal}
<script type="text/javascript">

$('.editPB').click(function(e){

 e.preventDefault();
 $('#pburl').val($('#currentPB').text());
 
 	
});

</script>
{/literal}



    




</div>
<!--End Contents-->


{include file="footer.tpl.php"}