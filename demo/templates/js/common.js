function mouseOver(e, c)
{
	  e.style.backgroundColor=c;
}



function mouseOut(e, c)
{
    var color = c;
			
    e.style.backgroundColor=color;
}
function CheckAll(fn1) {
  //fn = form name
  var boxes = 0;
  var checkedboxes = 0;
  var fn = document.getElementById(fn1);
  var checkAllbox = document.getElementById('checkAll');
  var status = 'true';
  if(checkAllbox.checked == false)
  {
     status = 'false';
  }
  for(var i=0; i<fn.elements.length;i++)
  {
      var e = fn.elements[i];
	  if((e.name != 'checkAll') && (e.type == 'checkbox') && (e.disabled == false))
	  {
	      boxes++;
		  if(status == 'true')
		  e.checked = true;
		  else
		  e.checked = false;
		  if(e.checked)
		  {
		      checkedboxes++;
		  }
	  }
  }
  
  

}


function uncheckCheckAllbox(obj)
{
 if(obj.type == 'checkbox' && obj.checked == false)
 {
     document.getElementById('checkAll').checked=false;
 }
}


function cancelRequest(id)
{
   var e = $('#'+id);
   if(e.val() == 'cancel')
   {
      var c = confirm("Are you sure you want to delete this request?");
	  if(!c)
	  {
		  e.val('0');
	 	  return false;  
	  }

	  $('#form_'+id).submit();
	  
   }
}




function changeMethodName()
{
    var e = $('#cMethod').val();
	
	if(e == 'paypal' || e == 'payza' || e == 'payquicker' || e == 'Moneybookers' || e == 'SolidTrustPay'){
		

		
	
		$('#notesArea').hide();      		

		
		
		$('#emailCon').show();
		
				
	
	  if(e == "paypal")
	  {
		  
		  $('#cmn').html("Paypal Email");
		  
	  }else if (e == "payza")
	  {
		  $('#cmn').html("Payza Email");	
		  
	  }else if(e == "payquicker"){
		  $('#cmn').html("Payquicker Email");	
	  }else if(e == "Moneybookers"){
		  $('#cmn').html("Moneybookers Email");		
	  }else if(e == "SolidTrustPay"){
		  $('#cmn').html("SolidTrustPay Username");			
	  }
	  
    }else if(e == "Wire" || e == 'WesternUnion')
	{

		
		$('#emailCon').hide();
	    $('#notesArea').show();


        

	}    

}









function calculateCost()
{

    var amount = parseInt($('#amt').val());
	var fee = 0.00;

	
	
	if(amount < 1)
	{

        return false;		
	}
	
	if(amount > parseInt($('#availableBalance').val()))
	{
		$('#amt').val('0.00');
        alert("you dont have sufficient balance");		
		return false;
	}
	
    if($('#costCal').val() == 'quick')
	{
		
		if(quick_pay_flat_fee > 0){
		fee = quick_pay_flat_fee;
		}else if(quick_pay_fee > 0){
		fee = amount * quick_pay_fee;		
		fee = fee.toFixed(2);
		}else{
		fee = 0.00;		
		}
		
		
		
		if(isNaN(fee))
		$('#fee').text('$0.00');
		else
		$('#fee').text('$'+fee);
	}else
	{
		if($('#cMethod').val() == 'Wire' && amount >= 1)
        $('#fee').text('$0.00');		
	}
	
}

function highlightText(id)
{
    document.getElementById(id).focus();
    document.getElementById(id).select();
}





function showLink(plain, inputbox)
{
   
    document.getElementById(plain).style.display='none';
	document.getElementById(inputbox).style.display='block';

}


function getSel(){
var w=window,d=document,gS='getSelection';
return (''+(w[gS]?w[gS]():d[gS]?d[gS]():d.selection.createRange().text)).replace(/(^\s+|\s+$)/g,'');
}



function hideLink(plain, lid)
{

    var txt = null;
    if (window.getSelection)
    {
        txt = window.getSelection();
    }
    else if (document.getSelection)
    {
        txt = document.getSelection();
    }
    else if (document.selection)
    {
        txt = document.selection.createRange();
    }
   alert(txt);
    
	if(txt.replace(/\s/g,"") != "")
	{
	   alert(sel);
       return;
	}
	
}



/*swaping*/
var lastControl;

function swap(control, toggle)
{

    // Swap the input field
    if(toggle == "showInput")
    {
        document.getElementById(control).style.display = "none";
        document.getElementById("inputdiv"+control).style.display = "block";
    }
    else
    {
        // Don't un-select the last control
        if (control != lastControl)
        {
            document.getElementById(control).style.display = "block";
            document.getElementById("inputdiv"+control).style.display = "none";
        }
    }
    
}

function selectText(obj, control)
{
    // Focus on the text
    obj.focus();
    obj.select();
    

    // Copy the data to clipboard
    //$.copy(obj.value);
	//$().copy();
/* var text = $(obj).val();
 $(obj).zclip({
 path: 'templates/js/ZeroClipboard.swf', 
 copy: text,
 beforeCopy:function(){
	 alert("Copying");
 },
 afterCopy:function(){
	 alert("Copied");
 }
 });	
	
  */
  

    
    // Un-select the last control
    unSelectControl(lastControl);
    
    // Update the last control
   lastControl = control;
    
    // Un-select the newly selected control in 3 seconds
    setTimeout("unSelectControl('" + control + "');", 3000) 

}

function unSelectControl(control)
{
    if (control != null)
    {
        document.getElementById(control).style.display = "";
        document.getElementById("inputdiv"+control).style.display = "none";
        
        lastControl = null;
    }
}



/* end swapping*/



function updateLive()
{
  //$('#l_today').html('<img src="templates/images/small-loading.gif" /> calculating');
  //$('#l_epc').html('<img src="templates/images/small-loading.gif" /> calculating');
  //$('#l_downloads').html('<img src="templates/images/small-loading.gif" /> calculating');
  
  var __interval2 = setTimeout("getLiveStats()", 2500); 		
}


function getLiveStats()
{
	 


	 
	  $.get("live_stats.php?smr="+Math.random(), function(data_) {

	    var data = JSON.parse(data_);	
		if(data.error == 1)
		return; 
		var earnings = data.earnings;
		var downloads = data.downloads;
		var epc = data.epc;
		var clicks = data.clicks;
        var balance = data.balance;
	    var __play = data.play;
		
		

        $('#l_today').text(earnings);
        $('#l_epc').text(epc);				
        $('#l_downloads').text(downloads);
        $('#l_balance').text(balance);
//        $('#FAi_todayClicks').text(clicks);
		
		
		if(__play == "yes")
		{
             $.ionSound.play('leads');	   			
		}		
		
										
		
         var __interval2 = setTimeout("updateLive()", 5000); 		
	 

	});	  	 

}



function getServerTime()
{
  
    
	$.get(SITE_URL+"time.php?smr="+Math.random(), function(data_) {


	    var data = JSON.parse(data_);	
		var hours = data.hours;
		var minutes = data.minutes;
		var seconds = data.seconds;
		var ampm = data.ampm;
  	    var time = hours+":"+minutes+":"+seconds+" "+ampm;
		var year = data.year;
		var day = data.day;
		var month = data.month;
        var sdate = month+"/"+day+"/"+year;
		
	    $('#Fai_ServTime').html("<span  title=\""+sdate+" "+time+"\"> "+time+" </span>");		
											
		
        setTimeout("getServerTime()", 1000); 		
	 	

	});	  	 	  
	  
	

}


$(document).ready(function(){
if($('#liveCounter').length > 0){
updateLive();	
//getServerTime();
}

	
	

	
});

