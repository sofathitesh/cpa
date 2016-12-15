// JavaScript Document
function deleteIt(url, msg)
{
  var c = confirm(msg);	
  if(!c)
  {
	  return;
	  }
	  
  window.location = url;	  
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


   