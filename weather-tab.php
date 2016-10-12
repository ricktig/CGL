<!-- weathertab.php -->
<?php
// include file to establish database connection
include ('./inc/mysql.inc.php');
	
// assign passed in campground id to variable
$CGNumber = $_GET['CGNo'];
$cam1 = '';

// define select query to select campground for longitude and latitude where primary key ID matches the passed in parameter from the map
$query = "SELECT * FROM tblmain WHERE pkID = $CGNumber";

// query the database and assign result to array
$result = mysql_query($query);

// check to see if result array was filled by query
if($result)
{
	// loop through result array
	while($row = mysql_fetch_array($result))
	{
		// assign cam and live weather variables
		$longitude = $row['Longitude'];
		$latitude = $row['Latitude'];
	} // end while loop
} // end if result


// define select query to select campground for webcam URLs where primary key ID matches the passed in parameter from the map
$query2 = "SELECT tblmain.CGName, tblcams.CamURL, tblcams.CamLocationName, tblcams.CamCity FROM (tblmain INNER JOIN tblcgcams ON tblmain.pkID = tblcgcams.CGID) INNER JOIN tblcams ON tblcgcams.CamID = tblcams.pkID WHERE tblmain.pkID=" . $CGNumber;
// query the database and assign result to array
$result2 = mysql_query($query2);

// check to see if result array was filled by query
if($result2)
{

	// loop through result array
	while($row = mysql_fetch_array($result2))
	{
		// assign cam URL variable
		$cam1 = '<iframe src="' .  $row['CamURL'] . '" width="100%" height="100%" frameborder="0"></iframe>';
		//assign cam name & location
		$camname = $row['CamLocationName'];
		$camcity = $row['CamCity'];
	} // end while loop
}
else
{
	$cam1 = "No local camera available for this location";
}// end if result2
?>


<!-- link to latest jQuery code -->
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>

<script type="text/javascript">
//<![CDATA[
//document ready jQuery function
$(function()
{
	// Set first tab to active class for 'active' color
	$("#camtab").addClass("active");
		
	//Tab click event to change color
	$("#livetabs li").click(function()
	{ 
		//Remove any "active" class
		$("#livetabs li").removeClass("active");

		// Set active class on clicked tab for 'active' color
		$(this).addClass("active");
	});

	//Load camtab - Camera tab on page load
	var result = '<div class="wxheader">Current Live Camera:</div>' +
	'<div id="camholder">' +
	'<?php echo $camname?>' +
	'<br/>' +
	'<?php echo $camcity?>' +
	'<br/>' +
	'<?php echo $cam1?>' +
	'</div>';
	$("#tabbody").css("height","500px");
	$("#mainbox").css("height","782px");
	$("#detailbody").css("height","630px");				
	$("#tabbody").html(result);
	
	// camtab - Camera tab click - load cam into tabbody div
	$("#camtab").click(function()
	{
		var result = '<div class="wxheader">Current Live Camera</div>' +
		'<div id="camholder">' +
		'<?php echo $cam1?>' +
		'</div>';
		$("#tabbody").css("height","500px");
		$("#mainbox").css("height","650px");
		$("#detailbody").css("height","630px");				
		$("#tabbody").html(result);
	}); // end camtab

	// wxtab - Current Weather tab click - load into tabbody div
	$("#wxtab").click(function()
	{
		$.ajax(
		{
			type: 'GET',
			url: 'wunderground-tab.php',
			data: {cgid:<?php echo $CGNumber?>,latitude:<?php echo $latitude?>,longitude:<?php echo $longitude?>},
			success: function(data)
			{
				$("#tabbody").css("height","500px");
				$("#mainbox").css("height","650px");
				$("#detailbody").css("height","630px");				
				$('#tabbody').html(data);
			}
		});//end ajax GET
	}); // end wxtab

	// fxtab - Current Forecast tab click - load into tabbody div
	$("#fxtab").click(function()
	{
		var result = '<div class="wxheader">Current Forecast</div>' +
		'<div id="forecastholder">' +
		'<?php echo '<iframe src="http://forecast.weather.gov/MapClick.php?textField1=' . $latitude . '&textField2=' . $longitude . '" width="100%" height="100%" frameborder="0"></iframe>'?>' +
		'</div>';
		$("#tabbody").html(result);
		$("#detailbody").css("height","1250px");		
		$("#tabbody").css("height","1100px");
		$("#forecastholder").css("height","1050px");
		$("#mainbox").css("height","1400px");		
	}); // end fxtab

});//end DOM load function
</script>

<head>
<style type="text/css">
	.wxheader
	{
		background-color: #167DC4;
		color: white;
		font-size: 1.2em;
		height: 30px;
		margin: 0 0 5px;
		padding: 4px 0 0 5px;
		text-transform:uppercase;
	}
</style>

<!-- Tab header-->
<h1>Live Camera and Weather Conditions</h1>
<ul id="livetabs" style="margin:0 0 0 25px">
	<li id="camtab" class="tab roundedtop tabcenter">
	<p>Live Camera</p>
	</li>
	<li id="wxtab" class="tab roundedtop tabcenter">
	<p>Current Weather</p>
	</li>
	<li id="fxtab" class="tab roundedtop tabcenter">
	<p>Weather Forecast</p>
	</li>
</ul>	
<!--div to hold tab content-->
<div id="tabbody" style="margin:51px 0 0 25px; height:500px;width:1028px;border:1px solid black">Loading, please wait...</div>