


function enableOffer(e, oid)
{
	
	    //var ele = $('#'+e);
	    var cc = $('#op_countries').val();
	   	$.get("campaigns.php?smr="+Math.random()+"&enableOffer=1&&oid="+oid+"&country="+cc, function(data_) {
			

			
			if(data_ == "1")
			{

				//ele.text("Disable");
				//ele.removeClass("enableBtn")
				//ele.addClass("disableBtn");
				$('#actA-'+oid).html('<a class="btn btn-small btn-danger" onclick="toggleOffer(\'oidd-'+oid+'\',\''+oid+'\')" id="oidd-'+oid+'" href="javascript:void(0)">Disable</a>');
				$('#cst-'+oid).html('<img src="templates/images/enabled.png" alt="" />');
				
				
			}
			
		});	
		
		return false;
	
}







function toggleOffer(e, oid)
{
	
	

	    var ele = $('#'+e);

        if(ele.text() == "Disable")
		disableOffer(e, oid);
		else
		enableOffer(e, oid)
		
			
}



function disableOffer(e, oid)
{
	
	   // var ele = $('#'+e);
	    var cc = $('#op_countries').val();
	   	$.get("campaigns.php?smr="+Math.random()+"&disableOffer=1&oid="+oid+"&country="+cc, function(data_) {


			if(data_ == "1")
			{

				//ele.text("Enable");
				//ele.removeClass("disableBtn")
				//ele.addClass("enableBtn");		
				$('#actA-'+oid).html('<a class="btn btn-small btn-warning" onclick="toggleOffer(\'oidd-'+oid+'\',\''+oid+'\')" id="oidd-'+oid+'" href="javascript:void(0)">Enable</a>');
				$('#cst-'+oid).html('<img src="templates/images/disabled.png" alt="" />');

				

				
			}
			
		});	
		
		return false;
	
}



function loadCampaigns()
{



      var oTable = $('#offersTable').dataTable();
      oTable.fnClearTable();
      $('#cc_offers').html('<tr><td colspan="9" style="text-align:center"><img src="templates/images/small_loading.gif" alt="" /> Please Wait...</td></tr>');

    var cc = $('#op_countries').val();
    var mc = cc;
	$.get("campaigns.php?smr="+Math.random()+"&getOffers=1&country="+cc, function(data_) {
	$('#cc_offers').html('');
      if(data_ == "No Offer"){

        $('#cc_offers').append('<tr><td colspan="9" style="text-align:center">No offer available at the moment</td></tr>');		  		  		  		
		
		
		return;
	  }

	  var data__ = JSON.parse(data_);	
	  var data = data__;
	  var fg;
	  

		  var camp;
		  var offer_name;
		  var desc;
		  var payout;
		  var isEnabled;		 
		  var actBtn;
		  var oid;
		  var epc;
		  var cr;
		  var cat;
		  var isMob;	  
	      var mobImg;
		  var cst;
		  var o_cc;
	  
	  for(i = 0; i<data.length; i++)
	  {      
	  

		   camp = data[i]['campid'];
		   offer_name = data[i]['name'];
		   desc = data[i]['desc'];
		   payout = data[i]['payout'];
		   isEnabled = data[i]['isEnabled'];		 
		   
		   oid = data[i]['oid'];
		   epc = data[i]['epc'];
		   cr = data[i]['CR'];
		   cat = data[i]['category'];
		   isMob = data[i]['mobile'];
		   o_cc = data[i]['country'];
		  
          
		  
		  
		  if(isMob == "1")
		  mobImg = '<img src="templates/images/mobile.jpg" alt="" title="Mobile Offer" />';
		  else
		  mobImg = '<img src="templates/images/no_mobile.png" alt="" />';		  
		  
		  
         
		  if(isEnabled == 1)
		  {
              actBtn = '<a class="btn btn-small btn-danger" onclick="toggleOffer(\'oidd-'+oid+'\',\''+oid+'\')" id="oidd-'+oid+'" href="javascript:void(0)">Disable</a>';			  
			  cst = '<img src="templates/images/enabled.png" alt="" />';
			  
		  }else
		  {
              actBtn = '<a class="btn btn-small btn-warning" onclick="toggleOffer(\'oidd-'+oid+'\',\''+oid+'\')" id="oidd-'+oid+'" href="javascript:void(0)">Enable</a>';		
  			  cst = '<img src="templates/images/disabled.png" alt="" />';
		  }		  
		  

		 fg = "";

		 if(mc.length < 2 || mc == "Global" || mc == "All"){

		 fg = o_cc;

		 cc = o_cc;

		 }else

		 fg = cc.toLowerCase();
		 
		 
      $('#offersTable').dataTable().fnAddData( [
	  '<span id="cst-'+oid+'">'+cst+'</span> '+mobImg,
	    oid,
		'<span><img src=\"templates/flags/'+fg.toLowerCase()+'.gif\" alt=\"\" /> '+cc+'</span>',
        '<span><a href="javascript:void(0)" onclick="openDetail('+oid+');">'+offer_name+'</a></span>',
        '$'+payout,
		cr,
		epc,
		cat,
		'<span id="actA-'+oid+'">'+actBtn+'</span>  '
				
		 ], false );
		 
		 
		 
 				  		 
	  
	  
	  }

      oTable.fnDraw(); 
	  
	  return; 
			
	  
	  
  });	    
	
	

	

	

	
}



function openDetail(id){
 
//      $.colorbox({iframe: true, href:"viewOffer.php?id="+id, width: 600, height:300, overlayClose:true, fixed:true});	  
	  
  $.fancybox.open({
	  href : 'offerDetail.php?id='+id,
	  type : 'iframe',
	  padding : 5,
	  closeClick  : false, // prevents closing when clicking INSIDE fancybox
  	  openEffect : "none",
	  openSpeed : "fast",
  	  transitionIn : "none",
	  helpers     : { 
		  overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox
	  }	  
	  
	  
  });	  
	  
	  
	  return false;
	  
 
}




function loadMyCampaigns()
{



      var oTable = $('#offersTable').dataTable();
      oTable.fnClearTable();
      $('#cc_offers').html('<tr><td colspan="9" style="text-align:center"><img src="templates/images/small_loading.gif" alt="" /> Please Wait...</td></tr>');

    var cc = $('#op_countries').val();

	$.get("my_campaigns.php?smr="+Math.random()+"&getOffers=1&country="+cc, function(data_) {
	$('#cc_offers').html('');
      if(data_ == "No Offer"){

        $('#cc_offers').append('<tr><td colspan="9" style="text-align:center">No offer available at the moment</td></tr>');		  		  		  		
		
		
		return;
	  }

	  var data = JSON.parse(data_);	
	  

		  var camp;
		  var offer_name;
		  var desc;
		  var payout;
		  var isEnabled;		 
		  var actBtn;
		  var oid;
		  var epc;
		  var isFav;
		  var cr;
		  var cat;
		  var isMob;
		  
		  var mobImg;	  
	  
	  
	  for(i = 0; i<data.length; i++)
	  {      
	  

		   camp = data[i]['campid'];
		   offer_name = data[i]['name'];
		   desc = data[i]['desc'];
		   payout = data[i]['payout'];
		   isEnabled = data[i]['isEnabled'];		 
		   actBtn;
		   oid = data[i]['oid'];
		   epc = data[i]['epc'];
		   isFav = data[i]['fav'];
		   cr = data[i]['CR'];
		   cat = data[i]['category'];
		   isMob = data[i]['mobile'];

		  if(isMob == "1")
		  mobImg = '<img src="templates/images/mobile.jpg" alt="" title="Mobile Offer" />';
		  else
		  mobImg = '<img src="templates/images/no_mobile.png" alt="" />';		  
		  
		  
          var cst;

              actBtn = '<a class="btn btn-small btn-warning" href="edit_campaign.php?id=oid">Details</a>';			  

		  

		 
		 
      $('#offersTable').dataTable().fnAddData( [
	    mobImg,
	    oid,
		'<span><img src=\"templates/flags/'+cc.toLowerCase()+'.gif\" alt=\"\" /> '+cc+'</span>',
        '<span><a href="javascript:void(0)" onclick="openDetail('+oid+');">'+offer_name+'</a></span>',
        '$'+payout,
		cr,
		epc,
		cat,
		'<span id="actA-'+oid+'">'+actBtn+'</span>  '
				
		 ], false );
		 
		 
		 
 		  		  		 
	  
	  
	  }


      oTable.fnDraw(); 
	  
	  return; 
			
	  
	  
  });	    
	
	

	

	

	
}
