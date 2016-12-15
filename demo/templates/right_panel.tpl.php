<div id="dashboard_rightPanel">




<!--Latest Conv-->
<div class="clear">

<div class="panel panel-default">
  <div class="panel-heading">Quick Stats</div>
  <div class="panel-body">



   <table class="table table-condensed table-noborder">
   
   <tr class="qst_row">
       <td>Today:  </td><td class="qst_val">${$today_earnings}</td>
   </tr>

   <tr class="qst_row">
       <td>Yesterday:  </td><td class="qst_val">${$yesterday_earnings}</td>
   </tr>


   <tr class="qst_row">
       <td>Last 7 Days:  </td><td class="qst_val">${$week_earnings}</td>
   </tr>
   
   
   <tr class="qst_row">
       <td>This Month:  </td><td class="qst_val">${$month_earnings}</td>
   </tr>   

   <tr class="qst_row">
       <td>Last Month:  </td><td class="qst_val">${$last_month_earnings}</td>
   </tr>   


   
   </table>



  </div>
</div>


</div>
<!--End Latest Conv-->



<!--Latest Conv-->
<div class="clear">

<div class="panel panel-default">
  <div class="panel-heading">Latest Conversion</div>
  <div class="panel-body">
  
  
  
  {if $recentConvs ne ""}
  
  {foreach item=conv from=$recentConvs}
  
  
<div style="color:#333333; font-size:12px;"><div class="left" style="padding-left:4px;"><div class="dcf" style=" color:#666666; font-weight:bold"><img src="templates/flags/{$conv.country|@strtolower}.gif" alt="" /> [{$conv.country}] - {$conv.offer}</div><div class="ddt">{$conv.date}</div></div><div class="right dcp" style="padding-right:4px; color:#0000ff; font-weight:bold; ">${$conv.credits}</div></div><div class="gap10px">&nbsp;</div>    
  
  
  {/foreach}
  
 
  
  {else}
  
  <center>No Latest Leads</center>
  
  {/if}
    
    
    
  </div>
</div>


</div>
<!--End Latest Conv-->



<!--News Feed-->
<div class="clear">

<div class="panel panel-default">
  <div class="panel-heading">News & Updates</div>
  <div class="panel-body">
    
    
    
{if $news ne ""}
{foreach item=alert from=$news name=n}

    <div class="news_line" {if $smarty.foreach.n.index+1 eq $news|@count}style="border:0"{/if}><b>{$alert.date}</b> - {$alert.title}<br />{$alert.desc}<br /><a href="news.php?nid={$alert.id}">read more</a></div>


{/foreach}
{/if}    
    
  </div>
</div>


</div>
<!--End News Feed-->



</div>