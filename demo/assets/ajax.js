// JavaScript Document
var http;
var __interval;

function Ajax_call()
{
	var http=null;
	try
	  {
	  // Firefox, Opera 8.0+, Safari
	  http=new XMLHttpRequest();
	  }
	catch (e)
	  {
	  // Internet Explorer
	  try
		{
		http=new ActiveXObject("Msxml2.XMLHTTP");
		}
	  catch (e)
		{
		http=new ActiveXObject("Microsoft.XMLHTTP");
		}
	  }
	return http;
}



var g;
var s;

function initCheck(gw, ss)
{
  
   g = gw;
   s = ss;
   document.getElementById('offers_layer').style.display = 'none';
   document.getElementById('status').style.display = 'block';
   checkStatus();
}


function checkStatus()
{

				window.clearInterval(__interval);	
				
				__interval="";		
				http = new Ajax_call();
				
				if (http) {
				
				var url = "validate_status.php";
				var params = "g="+g+"&seid="+Math.random()+"&sess="+s;
				http.onreadystatechange =  updateStatus;
				http.open('POST', url, true);
				http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				http.send(params);
                
				}else
				{
				alert("http undefined");
				}	    	
}




function updateStatus()
{
	
  var output = document.getElementById('status_m');
  
 
  if(http.readyState == 2 || http.readyState == 3)
  {
			output.innerHTML = "checking for completion...";	  
  }
 
  
  if(http.readyState==4)
  {
	  
	    var response = JSON.parse(http.responseText);	
		
        if(response.error == 1)
		{
			output.innerHTML = "Not completed yet.</div>";
		   __interval = window.setInterval("checkStatus()", 1300);	
           return;			
			
		}else if(response.success == '1')	    {
		  output.innerHTML = "Offer completed, Unlocking contents...</div>";
			
		}else
		{
		   __interval = window.setInterval("checkStatus()", 1500);	
		}
   
   
  }
	
}
	
function stopChecker()
{
   window.clearInterval(__interval);		 
   document.getElementById('offers_layer').style.display = 'block';
   document.getElementById('status').style.display = 'none';
	
}
