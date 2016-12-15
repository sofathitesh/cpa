{include file="header.tpl.php"}


<!--Page Title and User earnings overview-->
<div id="page_header">

<div class="pageTitle">
Postback Tester
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
<div class="alert alert-info">

<p>You can test your global postback by filling the lead data below.</p>

</div>
<!--End PB Documentation-->




<div class="clear">
<form action="postback_tester.php" method="post">
<input type="hidden" name="test" value="1" />



{if $error_msg ne ""}
   <div class="alert alert-danger">{$error_msg}</div>
{elseif $success_msg ne ""}
   <div class="alert alert-success">{$success_msg}</div>
{/if}



<table class="table table-bordered">

<tr>
    <td>Campaign Id</td><td><input type="text" name="campid" value="" class="form-control pbt_field" /></td>
</tr>

<tr>
    <td>Subid</td><td><input type="text" name="sid" value="" class="form-control pbt_field" /></td>
</tr>


<tr>
    <td>Subid2</td><td><input type="text" name="sid2" value="" class="form-control pbt_field" /></td>
</tr>

<tr>
    <td>Subid3</td><td><input type="text" name="sid3" value="" class="form-control pbt_field" /></td>
</tr>

<tr>
    <td>Subid4</td><td><input type="text" name="sid4" value="" class="form-control pbt_field" /></td>
</tr>

<tr>
    <td>Subid5</td><td><input type="text" name="sid5" value="" class="form-control pbt_field" /></td>
</tr>


<tr>
    <td>Payout</td><td><input type="text" name="payout" value="" class="form-control pbt_field" /></td>
</tr>

<tr>
    <td>Status</td><td><input type="text" name="status" value="" class="form-control pbt_field" /><br /> 1 = Success, 2 = Reversed</td>
</tr>


<tr>
    <td></td><td><input type="submit" name="testNow" value="Send Postback" class="btn btn-primary" /></td>
</tr>


</table>


</form>


<br />


{if $output ne ""}
<h6>Postback Output</h6>
<div class="alert alert-success" style="background:#ffffff">

{$output}

</div>
{/if}

</div>










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