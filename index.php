<?php
//display page header
include 'header.php';

//Connect To Database using include file
include './inc/mysql.inc.php';

//fill array of last three user report messages for display on vertical scroller
$lastthreemessages = fetch_last_three_messages();

//fill array of all alert messages for display on vertical scroller
$alertmessages = fetch_alert_messages();
?>

<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<!-- link to latest jQuery code -->
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript" src="js/jquery.vticker.min.js"></script>

<title>Find Tonight's Campground Now! - CampgroundsLive!</title>

<style type="text/css">
h1{
background-image:url('img/greenheader.png');
background-repeat:repeat-x;
font-size: 16px;
font-family: Ariel, Helvetica, sans-serif;
font-weight: bold;
color:white;
height:24px;
padding:6px 0 0 0;
text-align:center;
}

.scroller{
font-size:0.7em;
box-shadow: 5px 5px 5px black;
border:1px solid mediumseagreen;
float:left;
margin: 20px 0 0 124px;
width:320px;
}

.reportitems{
width:320px;
overflow:hidden;
background-color:white;
color:#2A4C31
}
</style>

<script type="text/javascript">
$(document).ready(function()
{
	$('#recentreports').vTicker('init', { showItems: 3});
	$('#recentalerts').vTicker('init', { showItems: 3});
});
</script>
</head>

<body>
	<!-- main content area -->
	<div id="mainbox" class="greenfill" style="color:#F9E1A7">
		<div id="topbox" style="width:850px;margin:0 auto 0 auto;padding:20px 0 0 0">
			<!-- radar image overlay -->
			<div id="radarholder" style="width:402px;height:430px;border:1px solid mediumseagreen;box-shadow: 5px 5px 5px black; float:left;">
				<h1 id="radardivheader">Current Denver Radar</h1>
				<div id="radardiv">
					<div id="image0">
						<img style="z-index:0" width="402" height="400" src="http://radar.weather.gov/ridge/Overlays/Topo/Short/FTG_Topo_Short.jpg" />
					</div>
					<div id="image1">
						<img style="z-index:1" width="402" height="400" src="http://radar.weather.gov/ridge/RadarImg/N0R/FTG_N0R_0.gif" name="conditionalimage" />
					</div>
					<div id="image2">
						<img style="z-index:2" width="402" height="400" src="http://radar.weather.gov/ridge/Overlays/County/Short/FTG_County_Short.gif" />
					</div>
					<div id="image3">
						<img style="z-index:3" width="402" height="400" src="http://radar.weather.gov/ridge/Overlays/Rivers/Short/FTG_Rivers_Short.gif" />
					</div>
					<div id="image4">
						<img style="z-index:4" width="402" height="400" src="http://radar.weather.gov/ridge/Overlays/Highways/Short/FTG_Highways_Short.gif" />
					</div>
					<div id="image5">
						<img style="z-index:5" width="402" height="400" src="http://radar.weather.gov/ridge/Overlays/Cities/Short/FTG_City_Short.gif" />
					</div>
					<div id="image6">
						<img style="z-index:6" width="402" height="400" src="http://radar.weather.gov/ridge/Warnings/Short/FTG_Warnings_0.gif" border="0" />
					</div>
					<div id="image7">
						<img style="z-index:7" width="402" height="400" src="http://radar.weather.gov/ridge/Legend/N0R/FTG_N0R_Legend_0.gif" border="0" name="conditionallegend" />
					</div>
				</div><!--end radardiv-->
			</div><!--end radarholder-->
			
			<!--messageholder div-->
			<div id="messageholder" class="scroller" style="margin:0 0 0 124px;">
				<h1 class="recentreportsheader">
					Recent Visitor Reports
				</h1>
				<!-- root element for newsticker -->
				<div id="recentreports" class="reportitems">
					<ul>
					<?php echo $lastthreemessages?>
					</ul>
				</div><!--end recentreports div-->				
			</div><!--end messageholder-->
			
			<div id="alertsholder" class="scroller">
				<!--alert header div-->
				<h1 class="recentreportsheader">
					Current Alerts
				</h1>
				<!-- root element for newsticker -->
				<div id="recentalerts" class="reportitems">
					<ul>
					<?php echo $alertmessages?>
					</ul>
				</div><!--end recentalerts div-->
			</div><!--end alertsholder-->
		</div><!--end topbox div-->
	</div><!--end mainbox div-->
<?php
include 'footer.php';
?>

</body>
</html>