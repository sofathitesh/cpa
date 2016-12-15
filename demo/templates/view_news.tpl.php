{include file="header.tpl.php"}


<!--Page Title and User earnings overview-->
<div id="page_header">

<div class="pageTitle">
News & Announcement
</div>


<div class="liveCounters">

{include file="live_counters.tpl.php"}

</div>


</div>
<!--End Page Title and User eanrings overview-->

<!--Contents-->
<div id="content" >


<br />

<h4>{$title}</h4>

<p>Posted on {$date_day} {$date_month}, {$date_year}</p>

<p>{$description|@nl2br}</p>









</div>


{include file="footer.tpl.php"}