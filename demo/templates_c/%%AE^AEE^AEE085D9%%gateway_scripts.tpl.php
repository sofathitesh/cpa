<?php /* Smarty version 2.6.26, created on 2016-12-14 10:48:52
         compiled from gateway_scripts.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'urldecode', 'gateway_scripts.tpl', 14, false),)), $this); ?>
<link href="templates/css/gateways.css" rel="stylesheet" type="text/css" />

<!--Color Box-->
<link rel="stylesheet" type="text/css" href="templates/css/colorbox/colorbox.css" />
<script type="text/javascript" src="templates/js/colorbox/jquery.colorbox-min.js"></script>



<script type="text/javascript" src="templates/js/gateways.js"></script>



<script type="text/javascript">
var SITE_URL = '<?php echo urldecode($this->_tpl_vars['SITE_URL']); ?>
';
<?php echo '
function activateGWStep(step)
{
	var eid = \'gw_basic\';
	switch(step)	
	{
		case \'gw_step1\':
		eid = \'gw_basic\';
		break;

		case \'gw_step2\':
		eid = \'gw_advance\';
		break;
		
		case \'gw_step3\':
		eid = \'gw_general\';
		break;							
	}
	

	
	switch(eid)
	{
		case \'gw_basic\':
		
		//set tabs formating
		$(\'#gw_basic\').removeClass(\'tab\').addClass(\'active_tab\');
		$(\'#gw_general\').removeClass(\'active_tab\').addClass(\'tab\');
		$(\'#gw_advance\').removeClass(\'active_tab\').addClass(\'tab\');						
		
		//show step content
		$(\'#gw_step1\').slideDown(\'slow\');	
		current_step = \'gw_step1\';
		break;	
		
		case \'gw_advance\':
		//set tabs formating
		$(\'#gw_basic\').removeClass(\'active_tab\').addClass(\'tab\');
		$(\'#gw_general\').removeClass(\'active_tab\').addClass(\'tab\');
		$(\'#gw_advance\').removeClass(\'tab\').addClass(\'active_tab\');			
		
		
		//show step content
		$(\'#gw_step2\').slideDown(\'slow\');	
		current_step = \'gw_step2\';
		break;
		
		case \'gw_general\':
		//set tabs formating
		$(\'#gw_basic\').removeClass(\'active_tab\').addClass(\'tab\');
		$(\'#gw_general\').removeClass(\'tab\').addClass(\'active_tab\');
		$(\'#gw_advance\').removeClass(\'active_tab\').addClass(\'tab\');				
		
		//show step content
		$(\'#gw_step3\').slideDown(\'slow\');	
		current_step = \'gw_step3\';
		break;
	}	
	

	
}

function countChars(f)
{
	
	var maxAllowed, count, left;
    if(f == \'title\')
	{

		maxAllowed = 200;
		count = $(\'#gw_title\').val().length;
		left = parseInt(maxAllowed - count);
		if(left < 0){
		$(\'#title_counter\').css(\'color\', \'#ff0000\');	
		$(\'#title_counter\').html("Characters: "+left+" remaining");
		}else{
		$(\'#title_counter\').css(\'color\', \'#999999\');	
		$(\'#title_counter\').html("Characters: "+left+" remaining");
			
		}
        

	}else if(f == \'instructions\')
	{

		maxAllowed = 400;
		count = $(\'#instructions\').val().length;
		left = parseInt(maxAllowed - count);
		
		if(left < 0){
		$(\'#instructions_counter\').css(\'color\', \'#ff0000\');	
		$(\'#instructions_counter\').html("Characters: "+left+" remaining");
		}else{
		$(\'#instructions_counter\').css(\'color\', \'#999999\');	
		$(\'#instructions_counter\').html("Characters: "+left+" remaining");
			
		}		
		
	}
	
	
}	




$(document).ready(function() {








//gwrow selection

$(\'.gw_row\').click(function(){
     $(\'.gw_row\').removeClass(\'highlight\');
	 $(this).addClass(\'highlight\');
     $(this).find(\'input[type=radio]\').attr(\'checked\', \'checked\');
 	
});

$(\'.gw_row\').mouseover(function(){
	   $(this).addClass(\'highlight\');
	   
	});

$(\'.gw_row\').mouseout(function(){
	
	   
	
	   if($(this).find(\'input[type=radio]\').attr(\'checked\') != \'checked\')
	   $(this).removeClass(\'highlight\');
	   
	});
	
$(\'.gw_row input[type=radio]\').click(function(){
	
	       $(\'.gw_row\').removeClass(\'highlight\');
		   $(this).parent().parent().addClass(\'highlight\');
		   
	});
	
	

$(\'.actionBtn\').click(function(e){
var selectedGW = 0;
var action = $(this).attr(\'id\');


    e.preventDefault();
	$(\'.gw_row input[type=radio]\').each(function(){
		
		if($(this).attr(\'checked\') == \'checked\')
		{
			selectedGW++;
			$(\'#action\').val(action);
			
			if(action == \'getcode\'){
				
				

				'; ?>

				
			getCode($(this).val(), '<?php echo $this->_tpl_vars['uloggedId']; ?>
'); //simply show the code for the gateway embed.
			
			   <?php echo '
			
			}else if(action == \'preview\'){
				
			
			'; ?>

			preparePreview('<?php echo $this->_tpl_vars['uloggedId']; ?>
', $(this).val());
			<?php echo '
			
		
				
			}else{
		
		    if(action == \'delete\')
			if(!confirm(\'Are you sure you want to delete selected gateway?\')) return false;		
				
			$(\'#gw_settings\').submit();
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
'; ?>




<?php if ($this->_tpl_vars['script'] == 'create' || $this->_tpl_vars['script'] == 'edit'): ?>


<!--Color Picker-->
<link href="templates/css/colorpicker.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/colorpicker.js"></script>




<script type="text/javascript">



//Color Picker Elements

<?php echo '
function setColors(f, v)
{
	setColorPicker(f, v);
}



$(document).ready(function(){





//for preview btn
$("#showPreview").click(function(e){
'; ?>

    e.preventDefault();
	preparePreview('<?php echo $this->_tpl_vars['uloggedId']; ?>
', '<?php echo $this->_tpl_vars['gid']; ?>
');
<?php echo '	
	
});
'; ?>


<?php if ($this->_tpl_vars['bg_color'] != ""): ?>
setColorPicker('bg_color', '<?php echo $this->_tpl_vars['bg_color']; ?>
');
<?php else: ?>
setColorPicker('bg_color', '#ffffff');
<?php endif; ?>




<?php if ($this->_tpl_vars['title_color'] != ""): ?>
setColorPicker('title_color', '<?php echo $this->_tpl_vars['title_color']; ?>
');
<?php else: ?>
setColorPicker('title_color', '#000000');
<?php endif; ?>



<?php if ($this->_tpl_vars['offer_color'] != ""): ?>
setColorPicker('offer_color', '<?php echo $this->_tpl_vars['offer_color']; ?>
');
<?php else: ?>
setColorPicker('offer_color', '#0000ff');
<?php endif; ?>


<?php if ($this->_tpl_vars['instructions_color'] != ""): ?>
setColorPicker('instructions_color', '<?php echo $this->_tpl_vars['instructions_color']; ?>
');
<?php else: ?>
setColorPicker('instructions_color', '#333333');
<?php endif; ?>


<?php if ($this->_tpl_vars['overlay_color'] != ""): ?>
setColorPicker('overlay_color', '<?php echo $this->_tpl_vars['overlay_color']; ?>
');
<?php else: ?>
setColorPicker('overlay_color', '#999999');
<?php endif; ?>



<?php if ($this->_tpl_vars['border_color'] != ""): ?>
setColorPicker('border_color', '<?php echo $this->_tpl_vars['border_color']; ?>
');
<?php else: ?>
setColorPicker('border_color', '#ffffff');
<?php endif; ?>





<?php echo '	
});
'; ?>



</script>







<!--Token Input-->
<link href="templates/css/token_input.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.tokeninput.js"></script>
<script type="text/javascript">
<?php if ($this->_tpl_vars['current_step'] != ""): ?> 
  var current_step = '<?php echo $this->_tpl_vars['current_step']; ?>
';

<?php else: ?>
  var current_step = 'gw_step1';
<?php endif; ?>
<?php echo '

$(document).ready(function(){

   //open templates viewer
   $(\'#chooseTemplate\').colorbox({iframe:true, innerWidth:930, innerHeight:700});

    activateGWStep(current_step);
    $(\'#gw_basic, #gw_advance, #gw_general\').click(function(){
		
	
	    var eid = $(this).attr(\'id\');
		
		switch(eid)
		{
		    case \'gw_basic\':
			
			//set tabs formating
			$(\'#gw_basic\').removeClass(\'tab\').addClass(\'active_tab\');
			$(\'#gw_general\').removeClass(\'active_tab\').addClass(\'tab\');
			$(\'#gw_advance\').removeClass(\'active_tab\').addClass(\'tab\');						
			
			//show step content
			if(current_step == \'gw_step1\')
			return;
			else
			{
			    $(\'#\'+current_step).slideUp(\'fast\', function(){
				    $(\'#gw_step1\').slideDown(\'slow\');	
					current_step = \'gw_step1\';
				});
				
			}
			
			
			break;	
			
			case \'gw_advance\':
			//set tabs formating
			$(\'#gw_basic\').removeClass(\'active_tab\').addClass(\'tab\');
			$(\'#gw_general\').removeClass(\'active_tab\').addClass(\'tab\');
			$(\'#gw_advance\').removeClass(\'tab\').addClass(\'active_tab\');			
			
			
			//show step content
			if(current_step == \'gw_step2\')
			return;
			else
			{
			    $(\'#\'+current_step).slideUp(\'fast\', function(){
				    $(\'#gw_step2\').slideDown(\'slow\');	
					current_step = \'gw_step2\';
				});
				
			}			
				
			break;
			
			case \'gw_general\':
			//set tabs formating
			$(\'#gw_basic\').removeClass(\'active_tab\').addClass(\'tab\');
			$(\'#gw_general\').removeClass(\'tab\').addClass(\'active_tab\');
			$(\'#gw_advance\').removeClass(\'active_tab\').addClass(\'tab\');				
			
			//show step content
			if(current_step == \'gw_step3\')
			return;
			else
			{
			    $(\'#\'+current_step).slideUp(\'fast\', function(){
				    $(\'#gw_step3\').slideDown(\'slow\');	
					current_step = \'gw_step3\';
					;
				});
				
			}
						
			break;
		}
		
		
	});




//Token Settings

//$(\'.tooltip a\').tooltip(); 

$(\'.tctr\').click(function(){
	
	
	if($(this).val() == \'other\')
	{
		
		$(\'#showMoreCountries\').slideDown(\'slow\',function(){
			
		$(this).fadeIn("slow").stop();
		
		
			
		});
		

	}else
	{
		$(\'#showMoreCountries\').slideUp(\'slow\', function(){
			
		$(this).fadeOut("fast").stop();
			
		});

	}
	
	});



'; ?>



<?php if ($this->_tpl_vars['target_countries'] == 'other'): ?> 
<?php echo '
		$(\'#showMoreCountries\').slideDown(\'fast\',function(){
		
		});
'; ?>

 <?php endif; ?>


<?php echo '

});

'; ?>

</script>
<?php endif; ?>