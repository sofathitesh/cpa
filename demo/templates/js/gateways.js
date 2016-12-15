function getCode(gid, aff_id)
{


	 var code = "<b>Widget Code</b><br /><textarea style=\"width:430px; height:150px\">\r\n<script type=\"text/javascript\" src=\""+SITE_URL+"assets/gwui.php?gid="+gid+"&aff_id="+aff_id+"\"></script>\r\n<noscript>\r\n<meta http-equiv=\"refresh\" content=\"0; URL="+SITE_URL+"assets/nojs.html\">\r\n</noscript>\r\n<script type=\"text/javascript\">\r\n$(document).ready(function(){initWidget();});\r\n</script>\r\n</textarea><br /><p>Place the code before &lt;/head&gt; tag in your web page, if you already have jquery in your web page, then remove first jquery script tag from given code.</p><br /><b>Loading the Gateway when a Link is Clicked</b><br /><p>If you would rather have the gateway appear only after a link (or other object) on your page is clicked -- and not when the page loads -- that is possible. First, Edit your gateway and set the Start Delay to -1. Then you will use Javascript's onClick event to trigger the gateway.<br />"+'<input type="text" name="gc" value=\'<a href="javascript:loadWidget()">Click here</a>\' style=\'width:350px\' /><br />'+'For image example:<br /><input type="text" name="gc" value=\'<img src="image.jpg" onclick="loadWidget()" />\' style=\'width:350px\' /></p>';
	 
     $.colorbox({html: code, height: "520px", width: "630px"});		
}


//set color
function setColorPicker(id, color) {
	

	$('#' + id + '_selector div').css('backgroundColor', color);
	$("#" + id).val(color);
	$('#' + id + '_selector').ColorPicker(
			{
				color : color,
				onShow : function(colpkr) {
					$(colpkr).fadeIn(500);
					return false;
				},
				onHide : function(colpkr) {
					$(colpkr).fadeOut(500);
					return false;
				},
				onChange : function(hsb, hex, rgb) {
					$('#' + id + '_selector div').css('backgroundColor', '#' + hex);
					$("#" + id).val('#' + hex);
				}
			});

}


/*Gateway Funcs*/
function preparePreview(u, ngid)
{
	
	window.open(SITE_URL+"gw_preview.php?u="+u+"&gwd="+ngid, 'gateway_preview');	
	return false;
	

	
}



	



