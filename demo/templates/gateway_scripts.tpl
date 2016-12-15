<link href="templates/css/gateways.css" rel="stylesheet" type="text/css" />

<!--Color Box-->
<link rel="stylesheet" type="text/css" href="templates/css/colorbox/colorbox.css" />
<script type="text/javascript" src="templates/js/colorbox/jquery.colorbox-min.js"></script>



<script type="text/javascript" src="templates/js/gateways.js"></script>



<script type="text/javascript">
var SITE_URL = '{$SITE_URL|@urldecode}';
{literal}
function activateGWStep(step)
{
	var eid = 'gw_basic';
	switch(step)	
	{
		case 'gw_step1':
		eid = 'gw_basic';
		break;

		case 'gw_step2':
		eid = 'gw_advance';
		break;
		
		case 'gw_step3':
		eid = 'gw_general';
		break;							
	}
	

	
	switch(eid)
	{
		case 'gw_basic':
		
		//set tabs formating
		$('#gw_basic').removeClass('tab').addClass('active_tab');
		$('#gw_general').removeClass('active_tab').addClass('tab');
		$('#gw_advance').removeClass('active_tab').addClass('tab');						
		
		//show step content
		$('#gw_step1').slideDown('slow');	
		current_step = 'gw_step1';
		break;	
		
		case 'gw_advance':
		//set tabs formating
		$('#gw_basic').removeClass('active_tab').addClass('tab');
		$('#gw_general').removeClass('active_tab').addClass('tab');
		$('#gw_advance').removeClass('tab').addClass('active_tab');			
		
		
		//show step content
		$('#gw_step2').slideDown('slow');	
		current_step = 'gw_step2';
		break;
		
		case 'gw_general':
		//set tabs formating
		$('#gw_basic').removeClass('active_tab').addClass('tab');
		$('#gw_general').removeClass('tab').addClass('active_tab');
		$('#gw_advance').removeClass('active_tab').addClass('tab');				
		
		//show step content
		$('#gw_step3').slideDown('slow');	
		current_step = 'gw_step3';
		break;
	}	
	

	
}

function countChars(f)
{
	
	var maxAllowed, count, left;
    if(f == 'title')
	{

		maxAllowed = 200;
		count = $('#gw_title').val().length;
		left = parseInt(maxAllowed - count);
		if(left < 0){
		$('#title_counter').css('color', '#ff0000');	
		$('#title_counter').html("Characters: "+left+" remaining");
		}else{
		$('#title_counter').css('color', '#999999');	
		$('#title_counter').html("Characters: "+left+" remaining");
			
		}
        

	}else if(f == 'instructions')
	{

		maxAllowed = 400;
		count = $('#instructions').val().length;
		left = parseInt(maxAllowed - count);
		
		if(left < 0){
		$('#instructions_counter').css('color', '#ff0000');	
		$('#instructions_counter').html("Characters: "+left+" remaining");
		}else{
		$('#instructions_counter').css('color', '#999999');	
		$('#instructions_counter').html("Characters: "+left+" remaining");
			
		}		
		
	}
	
	
}	




$(document).ready(function() {








//gwrow selection

$('.gw_row').click(function(){
     $('.gw_row').removeClass('highlight');
	 $(this).addClass('highlight');
     $(this).find('input[type=radio]').attr('checked', 'checked');
 	
});

$('.gw_row').mouseover(function(){
	   $(this).addClass('highlight');
	   
	});

$('.gw_row').mouseout(function(){
	
	   
	
	   if($(this).find('input[type=radio]').attr('checked') != 'checked')
	   $(this).removeClass('highlight');
	   
	});
	
$('.gw_row input[type=radio]').click(function(){
	
	       $('.gw_row').removeClass('highlight');
		   $(this).parent().parent().addClass('highlight');
		   
	});
	
	

$('.actionBtn').click(function(e){
var selectedGW = 0;
var action = $(this).attr('id');


    e.preventDefault();
	$('.gw_row input[type=radio]').each(function(){
		
		if($(this).attr('checked') == 'checked')
		{
			selectedGW++;
			$('#action').val(action);
			
			if(action == 'getcode'){
				
				

				{/literal}
				
			getCode($(this).val(), '{$uloggedId}'); //simply show the code for the gateway embed.
			
			   {literal}
			
			}else if(action == 'preview'){
				
			
			{/literal}
			preparePreview('{$uloggedId}', $(this).val());
			{literal}
			
		
				
			}else{
		
		    if(action == 'delete')
			if(!confirm('Are you sure you want to delete selected gateway?')) return false;		
				
			$('#gw_settings').submit();
			}
		}
	  	
	});
	
	if(selectedGW != 1)
	{
	    alert("Please choose gateway first.");	
	}
	
});

});

</script>
{/literal}



{if $script eq "create" || $script eq "edit"}


<!--Color Picker-->
<link href="templates/css/colorpicker.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/colorpicker.js"></script>




<script type="text/javascript">



//Color Picker Elements

{literal}
function setColors(f, v)
{
	setColorPicker(f, v);
}



$(document).ready(function(){





//for preview btn
$("#showPreview").click(function(e){
{/literal}
    e.preventDefault();
	preparePreview('{$uloggedId}', '{$gid}');
{literal}	
	
});
{/literal}

{if $bg_color ne ""}
setColorPicker('bg_color', '{$bg_color}');
{else}
setColorPicker('bg_color', '#ffffff');
{/if}




{if $title_color ne ""}
setColorPicker('title_color', '{$title_color}');
{else}
setColorPicker('title_color', '#000000');
{/if}



{if $offer_color ne ""}
setColorPicker('offer_color', '{$offer_color}');
{else}
setColorPicker('offer_color', '#0000ff');
{/if}


{if $instructions_color ne ""}
setColorPicker('instructions_color', '{$instructions_color}');
{else}
setColorPicker('instructions_color', '#333333');
{/if}


{if $overlay_color ne ""}
setColorPicker('overlay_color', '{$overlay_color}');
{else}
setColorPicker('overlay_color', '#999999');
{/if}



{if $border_color ne ""}
setColorPicker('border_color', '{$border_color}');
{else}
setColorPicker('border_color', '#ffffff');
{/if}





{literal}	
});
{/literal}


</script>







<!--Token Input-->
<link href="templates/css/token_input.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.tokeninput.js"></script>
<script type="text/javascript">
{if $current_step ne ""} 
  var current_step = '{$current_step}';

{else}
  var current_step = 'gw_step1';
{/if}
{literal}

$(document).ready(function(){

   //open templates viewer
   $('#chooseTemplate').colorbox({iframe:true, innerWidth:930, innerHeight:700});

    activateGWStep(current_step);
    $('#gw_basic, #gw_advance, #gw_general').click(function(){
		
	
	    var eid = $(this).attr('id');
		
		switch(eid)
		{
		    case 'gw_basic':
			
			//set tabs formating
			$('#gw_basic').removeClass('tab').addClass('active_tab');
			$('#gw_general').removeClass('active_tab').addClass('tab');
			$('#gw_advance').removeClass('active_tab').addClass('tab');						
			
			//show step content
			if(current_step == 'gw_step1')
			return;
			else
			{
			    $('#'+current_step).slideUp('fast', function(){
				    $('#gw_step1').slideDown('slow');	
					current_step = 'gw_step1';
				});
				
			}
			
			
			break;	
			
			case 'gw_advance':
			//set tabs formating
			$('#gw_basic').removeClass('active_tab').addClass('tab');
			$('#gw_general').removeClass('active_tab').addClass('tab');
			$('#gw_advance').removeClass('tab').addClass('active_tab');			
			
			
			//show step content
			if(current_step == 'gw_step2')
			return;
			else
			{
			    $('#'+current_step).slideUp('fast', function(){
				    $('#gw_step2').slideDown('slow');	
					current_step = 'gw_step2';
				});
				
			}			
				
			break;
			
			case 'gw_general':
			//set tabs formating
			$('#gw_basic').removeClass('active_tab').addClass('tab');
			$('#gw_general').removeClass('tab').addClass('active_tab');
			$('#gw_advance').removeClass('active_tab').addClass('tab');				
			
			//show step content
			if(current_step == 'gw_step3')
			return;
			else
			{
			    $('#'+current_step).slideUp('fast', function(){
				    $('#gw_step3').slideDown('slow');	
					current_step = 'gw_step3';
					;
				});
				
			}
						
			break;
		}
		
		
	});




//Token Settings

//$('.tooltip a').tooltip(); 

$('.tctr').click(function(){
	
	
	if($(this).val() == 'other')
	{
		
		$('#showMoreCountries').slideDown('slow',function(){
			
		$(this).fadeIn("slow").stop();
		
		
			
		});
		

	}else
	{
		$('#showMoreCountries').slideUp('slow', function(){
			
		$(this).fadeOut("fast").stop();
			
		});

	}
	
	});



{/literal}


{if $target_countries eq "other"} 
{literal}
		$('#showMoreCountries').slideDown('fast',function(){
		
		});
{/literal}
 {/if}


{literal}

});

{/literal}
</script>
{/if}