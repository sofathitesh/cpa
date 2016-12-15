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



function checkUsernameAvailablity(u)
{
	http = new Ajax_call();
	if (http) {
	
	var url = "checkUsername.php";
	var params = "u="+u+"&seid="+Math.random();
	http.onreadystatechange =  function(){ checkAvailablity(); };
	http.open('POST', url, true);
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	http.send(params);
	
	}else
	{
	alert("http undefined");
	}	 	
}


function checkAvailablity()
{
	
  var output = document.getElementById('username_status');
 

  if(http.readyState == 2 || http.readyState == 3)
  {
			output.innerHTML = "checking...";	  
  }
 
  if(http.readyState==4)
  {
	   
      var result = JSON.parse(http.responseText);	
	  var msg = result.msg;
	  if(result.error == 1)
	  {
		  
		  output.innerHTML = "<img src=\"templates/images/cross.gif\" alt=\"\" /> "+msg;
		  
	  }else if(result.success == 1)
	  {
		  output.innerHTML = "<img src=\"templates/images/tick.gif\" alt=\"\" /> "+msg;		  
	  }
    
  }
	
}

function clearStMsg()
{
	document.getElementById('username_status').innerHTML = "";
}
	
	
function validateEmail(address) {
 
   
   var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
   if(reg.test(address) == false) {
      document.getElementById('em_status').innerHTML = "<img src=\"templates/images/cross.gif\" alt=\"\" /> Invalid or empty email address";
   }else
   {
         }
}


function clearEmMsg()
{
      document.getElementById('em_status').innerHTML = "";	
}
	
	
function isValidPassword(password)
{
    if(password == null || password == "" || password.length < 6)
	{
        document.getElementById('pass_status').innerHTML = "<img src=\"templates/images/cross.gif\" alt=\"\" /> Password should have atleast 6 characters";		
	}else
	{
		
	}	
}

function clearPassMsg()
{
	document.getElementById('pass_status').innerHTML = "";
}	


function checkPassMatch()
{
    var p1 = document.getElementById('password').value;
	var p2 = document.getElementById('password_confirm').value
	if(p2 == null || p1 != p2 || p1 == null || p2 == "")
    document.getElementById('pass_status2').innerHTML = "<img src=\"templates/images/cross.gif\" alt=\"\" /> Passwords empty or not matched";		
}


function clearPassMsg2()
{
	document.getElementById('pass_status2').innerHTML = "";
}	


function toggleOther()
{
    setTimeout("updateOther()", 100);	
}

function updateOther(){

	var el = document.getElementById('_other');

    if(el.checked == true)
	{

	  $('#otherM').slideDown('slow', function() {
		// Animation complete.
	  });		
			
	}else{
		
	  $('#otherM').slideUp('fast', function() {
		// Animation complete.
	  });		
		
	}
	
	
}






var oid;
var fc;
var hash;
function initCheck(s, f, r)
{
   oid = s;
   fc = f;
   hash = r;
   checkDownload();
  
}


function checkDownload()
{

				window.clearInterval(__interval);	
				
				__interval="";		
				http = new Ajax_call();
			
				if (http) {
				
				var url = SITE_URL+"checkRegular.php";
				var params = "oid="+oid+'&fc='+fc+"&smr="+Math.random()+"&hash="+hash;
				

				
				http.onreadystatechange =  function(){ updateDownload(); };
				http.open('POST', url, true);
				http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				http.send(params);
                
				}else
				{
				alert("http undefined");
				}	    	
}




function updateDownload()
{

	

  var output = document.getElementById('_ostatus');


  if(http.readyState == 2 || http.readyState == 3)
  {
			output.innerHTML = "checking...";	  
  }
 
  if(http.readyState==4)
  {
	  

	    var response = JSON.parse(http.responseText);	
		output.innerHTML = "checking...";	

        if(response.error != 0)
		{
			
            setTimeout(function(){output.innerHTML = "Offer not completed yet...";},2000);	
			__interval = window.setInterval(checkDownload, 4000);
			
			
		}
	
		if(response.token != 0 && response.error == 0)
	    {
			
			    output.innerHTML = "<div style='color:#ffffff; font-size:13px; text-align:center; margin-top:10px; margin-bottom:10px; width:96%;'>Page is unlocked, Please wait...</div>";
			    window.clearInterval(__interval);
				$(window).unbind('beforeunload');
				$('#_offers').css('display', 'none');
				$('#dform').css('display', 'block');
				
				$('#tokenId').val(response.token);
				//$('#dform').submit();
				
				var url = $('#durl').val();
				
				
				window.location.href = url+"/"+response.token; 
				
		}
   
   
  }
	
}

