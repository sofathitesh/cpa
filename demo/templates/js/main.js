var toggle = true;
$("body .sidebar-icon").click(function() {   
  if (toggle)
  {
    $(".page-container").addClass("sidebar-collapsed").removeClass("sidebar-collapsed-back");
    $("#menu span").css({"position":"absolute"});
    $(".page-container.sidebar-collapsed .logo").css({"height":"75px"});
    $("header img").hide();
    $("header p").hide();
    $("#page_header").removeClass("lateral-menu-is-open");
    $("#content").removeClass("lateral-menu-is-open");
    }
  else
  {
       
        $(".page-container").removeClass("sidebar-collapsed").addClass("sidebar-collapsed-back");
    setTimeout(function() {
      $("#menu span").css({"position":"relative"});
        $(".page-container.sidebar-collapsed-back .logo").css({"height":"250px"});
        $("header img").show();
        $("header p").show();
        $("#page_header").addClass("lateral-menu-is-open");
        $("#content").addClass("lateral-menu-is-open");
    }, 400);
  }
                
                toggle = !toggle;
            });
