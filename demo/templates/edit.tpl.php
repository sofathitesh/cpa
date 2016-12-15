{include file="header.tpl.php"}


<!--Page Title and User earnings overview-->
<div id="page_header">

<div class="pageTitle">
Edit Content Locker
</div>


<div class="liveCounters">

{include file="live_counters.tpl.php"}

</div>


</div>
<!--End Page Title and User eanrings overview-->

<!--Contents-->
<div id="content" >
<br />

<!--Box Area-->
<form action="edit.php?gid={$gid}" method="post">
<input type="hidden" name="wid" id="wid" value="{$wid}" />
<div class="clear">

<br /><br />




<!--GW Editor-->
<div id="gw_editor">
<div id="gw_tabs">

<div class="tabs">
    <div class="active_tab" id="gw_basic"><p>Basic Appearance</p></div>
    <div class="tab" id="gw_advance"><p>Advanced Appearance</p></div>
    <div class="tab" id="gw_general"><p>General Settings</p></div>        
</div>

</div>
<div class="top">&nbsp;</div>

<div class="mid">
<!--Form Contents-->


{if $error_msg ne ""}
     

        
        <div class="gw_field_row" style="padding:0">
        <div style="clear:both; width:400px; color:#ff0000">
        <img src="templates/images/cross.gif" style="vertical-align:top" alt="" /> {$error_msg}
        </div>
        </div>
        
               
{elseif $success_msg ne ""}

          <div class="gw_field_row" style="padding:0">
        <div style="clear:both; width:400px; color:#0000ff">
        <img src="templates/images/tick.gif" style="vertical-align:top" alt="" /> {$success_msg}
        </div>
        </div>      
        
{/if}        

<!--Step1-->
<div id="gw_step1">

<!--Form-->
<!--Element-->
<div class="gw_field_row" style="padding:0">
<div class="gw_label">Background Image <span class="hint ec-tip-twitter" title="Select Background Image">(?)</span></div>
<div class="gw_field">

    <div class="clear">
    <div class="gw_bigger_input"><input type="text" name="bg_img" id="bg_img" value="{$bg_img}" class="input" /></div>
    <div class="left" style="margin-top:1px;"><a href="template_chooser.php?wid={$wid}" id="chooseTemplate" class="btn btn-default btn-sm">Choose Background</a></div>
    </div>

</div>
</div>
<!--End Element-->


<!--Element-->
<div class="gw_field_row">
<div class="gw_label">... or Color <span class="hint ec-tip-twitter" title="Or you can select background color">(?)</span></div>
<div class="gw_field">

    <div class="clear">
    <div class="gw_med_input"><input type="text" name="bg_color" value="{$bg_color}" id="bg_color" class="input" /></div>
    <div id="bg_color_selector" class="color-picker">
     <div>
     </div>
    </div>
    </div>

</div>
</div>
<!--End Element-->



<!--Element-->
<div class="gw_field_row">
<div class="gw_label">Size <span class="hint ec-tip-twitter" title="Dimension of your content locker widget">(?)</span></div>
<div class="gw_field">

    <div class="clear">
    <div class="gw_small_input"><input type="text" name="gw_width" value="{if $gw_width eq ""}650{else}{$gw_width}{/if}" id="gw_width" class="input" /> &nbsp; Width</div>
    <div class="gw_small_input"><input type="text" name="gw_height" value="{if $gw_height eq ""}420{else}{$gw_height}{/if}" id="gw_height" class="input" /> &nbsp; Height</div>
    </div>

</div>
</div>
<!--End Element-->



<!--Element-->
<div class="gw_field_row">
<div class="gw_label">Header Text <span class="hint ec-tip-twitter" title="Enter your content locker title text">(?)</span></div>
<div class="gw_field">

    <div class="clear">
    <div class="gw_txtarea"><textarea  name="gw_title" onkeyup="countChars('title')" id="gw_title" class="input" >{$gw_title}</textarea></div>
     <div style="font-size:10px; color:#999999;  clear:both; padding-top:5px;" id="title_counter"></div>
    </div>

</div>
</div>
<!--End Element-->


<!--Element-->
<div class="gw_field_row">
<div class="gw_label">Instructions <span class="hint ec-tip-twitter" title="You can also add instructions to unlock contents">(?)</span></div>
<div class="gw_field">

    <div class="clear">
    <div class="gw_txtarea"><textarea  name="instructions" onkeyup="countChars('instructions')" id="instructions" class="input" >{$instructions}</textarea></div>
    <div style="font-size:10px; clear:both; color:#999999; padding-top:5px;" id="instructions_counter"></div>
    </div>

</div>
</div>
<!--End Element-->

<script type="text/javascript">
countChars('title');
countChars('instructions');
</script>


<!--End Form-->



</div>
<!--End Step1-->

<!--Step1-->
<div id="gw_step2">



<!--Element-->
<div class="gw_field_row">
<div class="gw_label">Header Color <span class="hint ec-tip-twitter" title="Choose color for your content locker title text">(?)</span></div>
<div class="gw_field">

    <div class="clear">
    <div class="gw_med_input"><input type="text" name="title_color" id="title_color" value="{$title_color}" class="input" /></div>
    <div id="title_color_selector" class="color-picker">
        <div></div>
    </div>
    </div>

</div>
</div>
<!--End Element-->


<!--Element-->
<div class="gw_field_row">
<div class="gw_label">Header Font Size<span class="hint ec-tip-twitter" title="Enter font size for your title text.">(?)</span></div>
<div class="gw_field">

    <div class="clear">
    <div class="gw_small_input2"><input type="text" name="title_size" value="{$title_size}"  class="input" maxlength="2" /> &nbsp;px</div>
    </div>

</div>
</div>
<!--End Element-->




<div class="clear_row">&nbsp;</div>

<!--Element-->
<div class="gw_field_row">
<div class="gw_label">Offer Color <span class="hint ec-tip-twitter" title="Choose color for your cotent locker offers">(?)</span></div>
<div class="gw_field">

    <div class="clear">
    <div class="gw_med_input"><input type="text" name="offer_color" id="offer_color" value="{$offer_color}" class="input" /></div>
    <div id="offer_color_selector" class="color-picker">
    
        <div></div>
    
    </div>
    </div>

</div>
</div>
<!--End Element-->

<!--Element-->
<div class="gw_field_row">
<div class="gw_label">Offer Font Size<span class="hint ec-tip-twitter" title="Enter font size for your offers.">(?)</span></div>
<div class="gw_field">

    <div class="clear">
    <div class="gw_small_input2"><input type="text" name="offer_size" value="{$offer_size}"  class="input" maxlength="2" /> &nbsp;px</div>
    </div>

</div>
</div>
<!--End Element-->
<!--Element-->
<div class="gw_field_row">
<div class="gw_label">Offer Bold <span class="hint ec-tip-twitter" title="Check the box to make your offers bold">(?)</span></div>
<div class="gw_field">

    <div class="clear">
    <input type="checkbox" name="offer_bold" value="1" {if $offer_bold eq "1"} checked="checked" {/if} class="gw_chkbox" />
    </div>

</div>
</div>
<!--End Element-->



<div class="clear_row">&nbsp;</div>

<!--Element-->
<div class="gw_field_row">
<div class="gw_label">Instructions Color <span class="hint ec-tip-twitter" title="Choose color for instructions text">(?)</span></div>
<div class="gw_field">

    <div class="clear">
    <div class="gw_med_input"><input type="text" name="instructions_color" id="instructions_color" value="{$instructions_color}" class="input" /></div>
    <div id="instructions_color_selector" class="color-picker">
    
        <div></div>
    
    </div>
    </div>

</div>
</div>
<!--End Element-->

<!--Element-->
<div class="gw_field_row">
<div class="gw_label">Instructions Font Size<span class="hint ec-tip-twitter" title="Enter font size for instructions text.">(?)</span></div>
<div class="gw_field">

    <div class="clear">
    <div class="gw_small_input2"><input type="text" name="instructions_size" value="{$instructions_size}"  class="input" maxlength="2" /> &nbsp;px</div>
    </div>

</div>
</div>
<!--End Element-->



<div class="clear_row">&nbsp;</div>

<!--Element-->
<div class="gw_field_row">
<div class="gw_label">Overlay Color <span class="hint ec-tip-twitter" title="Choose color for your content locker's overlay">(?)</span></div>
<div class="gw_field">

    <div class="clear">
    <div class="gw_med_input"><input type="text" name="overlay_color" id="overlay_color" value="{$overlay_color}" class="input" /></div>
    <div id="overlay_color_selector" class="color-picker"><div></div></div>
    </div>

</div>
</div>
<!--End Element-->
<!--Element-->
<div class="gw_field_row">
<div class="gw_label">Overlay Opacity <span class="hint ec-tip-twitter" title="Enter opacity for your content locker's overlay, value should be between 0 - 100">(?)</span></div>
<div class="gw_field">

    <div class="clear">
    <div class="gw_med_input" style="width:125px;"><input type="text" name="overlay_opacity" value="{$overlay_opacity}" class="input" />&nbsp;&nbsp;&nbsp;&nbsp;%</div>
    </div>

</div>
</div>
<!--End Element-->




<div class="clear_row"></div>


<!--Element-->
<div class="gw_field_row">
<div class="gw_label">Border Color <span class="hint ec-tip-twitter" title="Choose color for content locker's border">(?)</span></div>
<div class="gw_field">

    <div class="clear">
    <div class="gw_med_input"><input type="text" name="border_color" value="{$border_color}" id="border_color" class="input" /></div>
    <div id="border_color_selector" class="color-picker">
    
        <div></div>
    
    </div>
    </div>

</div>
</div>
<!--End Element-->
<div class="clear_row"></div>

<!--Element-->
<div class="gw_field_row">
<div class="gw_label">Border Size<span class="hint ec-tip-twitter" title="Enter border size. 0 for no border">(?)</span></div>
<div class="gw_field">

    <div class="clear">
    <div class="gw_med_input" style="width:125px;"><input type="text" name="border_size" value="{$border_size}"  class="input" maxlength="2" /> &nbsp;&nbsp;&nbsp;px</div>
    </div>

</div>
</div>
<!--End Element-->






</div>
<!--End Step1-->

<!--Step1-->
<div id="gw_step3">




<!--Element-->
<div class="gw_field_row">
<div class="gw_label">Unlock Period <span class="hint ec-tip-twitter" title="Enter unlock period, for how long cookie should reside to keep contents unlocked.">(?)</span></div>
<div class="gw_field">

    <div class="clear">
    <div class="gw_small_input" style="width:450px;"><input type="text" name="unlock_period" value="{$unlock_period}" maxlength="3" class="input" /> &nbsp; &nbsp; 
    
    <select name="period_type" class="selectBox" style="height:24px; vertical-align:middle" >
    
    <option value="seconds" {if $period_type eq "seconds" || $period_type eq ""} selected="selected" {/if}>Second(s)</option>
    <option value="minutes" {if $period_type  eq "minutes"} selected="selected" {/if}>Minutes(s)</option>
    <option value="hours" {if $period_type eq "hours"} selected="selected" {/if}>Hour(s)</option>    
    <option value="days" {if $period_type eq "days"} selected="selected" {/if}>Day(s)</option>
    
    </select>
        
    
    </div>
    </div>

</div>
</div>
<!--End Element-->

<!--Element-->
<!--<div class="gw_field_row">
<div class="gw_label">Lock to IP <span class="hint ec-tip-twitter" title="Check the box if you want to keep contents unlocked for the ip completed an offer.">(?)</span></div>
<div class="gw_field">

    <div class="clear">
    <input type="checkbox" name="lock_ip" value="1" {if $lock_ip eq "1"} checked="checked" {/if} class="gw_chkbox" />
    </div>

</div>
</div>-->
<!--End Element-->

<div class="clear_row">&nbsp;</div>

<!--Element-->
<div class="gw_field_row">
<div class="gw_label">Redirect URL <span class="hint ec-tip-twitter" title="Enter url you want to redirect user when he completes an offer.">(?)</span></div>
<div class="gw_field">

    <div class="clear">
    <div class="gw_bigger_input"><input type="text" name="redirect_url" value="{$redirect_url}" class="input" /></div>
    </div>

</div>
</div>
<!--End Element-->

<div class="clear_row">&nbsp;</div>

<!--Element-->
<div class="gw_field_row">
<div class="gw_label">Start Delay<span class="hint ec-tip-twitter" title="Enter time in seconds, the content locker will be shown after fixed time">(?)</span></div>
<div class="gw_field">

    <div class="clear">
    <div class="gw_small_input" style="width:280px;"><input type="text" name="load_time" value="{$load_time}" maxlength="3" class="input" /> &nbsp; seconds <span style="font-size:10px">(or -1 to disable auto-start)</span></div>
    </div>

</div>
</div>
<!--End Element-->




<!--Element-->
<div class="gw_field_row">
<div class="gw_label">Include Close Link <span class="hint ec-tip-twitter" title="Check the box if you want to include close link in content locker.">(?)</span></div>
<div class="gw_field">

    <div class="clear">
    <input type="checkbox" name="include_close" value="1" {if $include_close eq "1"} checked="checked" {/if} class="gw_chkbox" />
    </div>

</div>
</div>
<!--End Element-->


<!--Element-->
<div class="gw_field_row">
<div class="gw_label">Number of Offers <span class="hint ec-tip-twitter" title="Select number of offers to show in the gateway.">(?)</span></div>
<div class="gw_field">

    <div class="clear">
    <select name="offers_show" class="select">
    
    <option value="2" {if $offers_show eq "2"} selected="selected" {/if}>2 Offers</option>
    <option value="3" {if $offers_show eq "3"} selected="selected" {/if}>3 Offers</option>
    <option value="4" {if $offers_show eq "4"} selected="selected" {/if}>4 Offers</option>
    <option value="5" {if $offers_show eq "5"  || $offers_show eq ""} selected="selected" {/if} >5 Offers</option>
    <option value="6" {if $offers_show eq "6"} selected="selected" {/if}>6 Offers</option>
    <option value="7" {if $offers_show eq "7"} selected="selected" {/if}>7 Offers</option>

    
    </select>
    </div>

</div>
</div>
<!--End Element-->


<!--Countries Lable And Fields-->
<div class="gw_field_row">
<div class="gw_label">Show Gateway For <span class="hint ec-tip-twitter" title="Select countries you want to allow to see content locker">(?)</span></div>
<div class="gw_field">
<input type="radio" name="target_countries" class="tctr" value="All" {if $target_countries eq "All" || $target_countries eq ""} checked="checked" {/if} />Show Gateway for All Countries<br />
<input type="radio" name="target_countries" class="tctr" value="US,GB,CA,AU" {if $target_countries eq "US,GB,CA,AU"} checked="checked" {/if} />Show Gateway ONLY for US, UK, Canada, and Australia<br />
<input type="radio" name="target_countries" class="tctr" value="other" {if $target_countries eq "other"} checked="checked" {/if} />Manually Choose Countries


</div>
</div>


<div class="gw_field_row"  style="display:none" id="showMoreCountries"><br />
<div style="font-weight:bold" class="gw_label">Choose Countries:</div>
<div class="gw_field">



        <script type="text/javascript">
		{literal}
        $(document).ready(function() {


            $("#targeted_countries").tokenInput(SITE_URL+"getCountries.php", {
                theme: "facebook",
				queryParam: 'c'{/literal}{if $targeted_countries ne " " && $targeted_countries ne "0" && $targeted_countries ne ""}, 
				prePopulate: {$targeted_countries}
				{/if}{literal} 
            });
			
			
			
			
        });
		{/literal}
        </script>


<input type="text"  id="targeted_countries"  name="targeted_countries" class="select_target_countries" style="width:500px;" />

                     

        


</div>

</div>
<!--end Countries Labels & Fields-->





</div>
<!--End Step1-->

<!--End form content-->
</div>

<div class="bottom">&nbsp;</div>
</div>
<!--End GW editor-->




<!--Element-->
<div class="gw_field_row" style="width:640px;">
<div class="gw_label" style="text-align:right; width:175px;">Gateway Name <span class="hint ec-tip-twitter" title="Enter name of your gateway">(?)</span></div>
<div class="gw_field">

    <div class="clear">
    <div class="gw_med_input2"><input type="text" name="gw_name" value="{$gw_name}" class="input" /></div>
    </div>

</div>
</div>
<!--End Element-->

<!--Element-->
<div class="gw_field_row" style="width:640px;">
<div class="gw_label" style="text-align:right; width:175px;">&nbsp;</div>
<div class="gw_field">

    <div class="clear" style="margin-left:2px;">
    <input type="hidden" name="edit" value="1" />
    <input type="image" src="templates/images/gw_edit_btn.jpg" alt="Edit Gateway" name="editBtn" onmouseover="this.src='templates/images/gw_edit_btn_hover.jpg'" onmouseout="this.src='templates/images/gw_edit_btn.jpg'" />
    
    <input type="image" src="templates/images/gw_preview_btn.jpg" alt="Preview Gateway" id="showPreview" name="preview"  onmouseover="this.src='templates/images/gw_preview_btn_hover.jpg'" onmouseout="this.src='templates/images/gw_preview_btn.jpg'" />    
           
    </div>

</div>
</div>
<!--End Element-->




</div>
</form>
<!--End Box Area-->



<br />




<br /><br />


</div></div>
<!--End Right Panel-->
{include file="footer.tpl.php"}