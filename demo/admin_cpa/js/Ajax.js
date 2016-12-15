var httpreq, http;

function Ajax_call()
{
var httpreq=null;
try
  {
  // Firefox, Opera 8.0+, Safari
  httpreq=new XMLHttpRequest();
  }
catch (e)
  {
  // Internet Explorer
  try
    {
    httpreq=new ActiveXObject("Msxml2.XMLHTTP");
    }
  catch (e)
    {
    httpreq=new ActiveXObject("Microsoft.XMLHTTP");
    }
  }
return httpreq;
}


 
 function dateChange(strdate, month, prefix)
 {
	 
	
	 
 httpreq = new Ajax_call();
  if (httpreq==null)
  {
  alert ("Your browser does not support AJAX!");
  return;
  }
  
  
   if(prefix == null)
   {
	 prefix = 'expiry';  
	 var container =  document.getElementById('changedate');   
   }else
   {
	   	 var container =  document.getElementById(prefix);      
   }
 
  
 var url = "datechanger.php";
 var params = "prefix="+prefix+"&date="+strdate+"&month="+month+"&seid="+Math.random();
      
  
   
  httpreq.onreadystatechange = function()
   {

 
 if(httpreq.readyState ==3)
{
	
container.innerHTML = '<img src="ajax-loader.gif" alt="Updating.." />';

 }
 
  if(httpreq.readyState==4)
  {
  
  
    container.innerHTML = httpreq.responseText;
  
 }

   }
   
httpreq.open("POST",url,true);
httpreq.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
httpreq.setRequestHeader("Content-length", params.length);
httpreq.setRequestHeader("Connection", "close");
httpreq.send(params);

  
 }
 
 
 