<?php
	$my_latitude = $_GET['latitude'];
	$my_longitude = $_GET['longitude'];

	//get closest station
	$json_string_closest_station = file_get_contents("http://api.wunderground.com/api/42643b0057a37fd6/geolookup/q/${my_latitude},${my_longitude}.json");
		
	$parsed_json_closest_station = json_decode($json_string_closest_station);
	$closest_city = $parsed_json_closest_station->{'location'}->{'nearby_weather_stations'}->{'airport'}->{'station'}[0]->{'city'};
	$closest_state = $parsed_json_closest_station->{'location'}->{'nearby_weather_stations'}->{'airport'}->{'station'}[0]->{'state'};

	//get latest observations
	$exploded = explode(' ', $closest_city);
	$fixed_closest_city = implode('%20', $exploded);
	
	$current_conditions_url = "http://api.wunderground.com/api/42643b0057a37fd6/conditions/q/$closest_state/$fixed_closest_city.json";
	
	$json_string_latest_observations = file_get_contents($current_conditions_url);
	
	$parsed_json = json_decode($json_string_latest_observations);
	$location = $parsed_json->{'current_observation'}->{'observation_location'}->{'full'};
	$latitude = $parsed_json->{'current_observation'}->{'observation_location'}->{'latitude'};
	$longitude = $parsed_json->{'current_observation'}->{'observation_location'}->{'longitude'};
	$display_latitude = round($latitude,3);
	$display_longitude = (round($longitude,3))*-1;
	
	$elevation = $parsed_json->{'current_observation'}->{'observation_location'}->{'elevation'};
	$obs_time = $parsed_json->{'current_observation'}->{'observation_time'};
	$current_conditions = $parsed_json->{'current_observation'}->{'weather'};
	$current_icon = $parsed_json->{'current_observation'}->{'icon_url'};
	$temp_f = $parsed_json->{'current_observation'}->{'temp_f'};
	$dewpoint = $parsed_json->{'current_observation'}->{'dewpoint_f'};
	$relative_humidity = $parsed_json->{'current_observation'}->{'relative_humidity'};
	$wind_string = $parsed_json->{'current_observation'}->{'wind_string'};
	$pressure_in = $parsed_json->{'current_observation'}->{'pressure_in'};
	$visibility = $parsed_json->{'current_observation'}->{'visibility_mi'};
	$title = $parsed_json->{'current_observation'}->{'image'}->{'title'};
	$forecast_url = $parsed_json->{'current_observation'}->{'forecast_url'};

	//get sunrise/sunset
	$astronomy_url = "http://api.wunderground.com/api/42643b0057a37fd6/astronomy/q/$closest_state/$fixed_closest_city.json";
	
	$json_string_astronomy = file_get_contents($astronomy_url);
	
	//echo $json_string_astronomy;
	
	$parsed_json_string_astronomy = json_decode($json_string_astronomy);
	$sunrise_hour = $parsed_json_string_astronomy->{'moon_phase'}->{'sunrise'}->{'hour'};
	$sunrise_minute = $parsed_json_string_astronomy->{'moon_phase'}->{'sunrise'}->{'minute'};
	$sunset_hour = $parsed_json_string_astronomy->{'moon_phase'}->{'sunset'}->{'hour'};
	$sunset_minute = $parsed_json_string_astronomy->{'moon_phase'}->{'sunset'}->{'minute'};
	
	//$distance_from_waypoint = distance($my_latitude, $my_longitude, $latitude, $longitude);
	$haversine = haversine($my_latitude, $my_longitude, $latitude, $longitude);	
	
    function distance($lat1, $lng1, $lat2, $lng2, $miles = true)
    {
		$pi80 = M_PI / 180;
		$lat1 *= $pi80;
		$lng1 *= $pi80;
		$lat2 *= $pi80;
		$lng2 *= $pi80;
		 
		$r = 6372.797; // mean radius of Earth in km
		$dlat = $lat2 - $lat1;
		$dlng = $lng2 - $lng1;
		$a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlng / 2) * sin($dlng / 2);
		$c = 2 * atan2(sqrt($a), sqrt(1 - $a));
		$km = $r * $c;
     
		return ($miles ? ($km * 0.621371192) : $km);
    }
	
	function haversine ($l1, $o1, $l2, $o2) { 
	  $l1 = deg2rad ($l1); 
	  $sinl1 = sin ($l1); 
	  $l2 = deg2rad ($l2); 
	  $o1 = deg2rad ($o1); 
	  $o2 = deg2rad ($o2); 

	  $distance = (7926 - 26 * $sinl1) * asin (min (1, 0.707106781186548 * sqrt ((1 - (sin ($l2) * $sinl1) - cos ($l1) * cos ($l2) * cos ($o2 - $o1))))); 

	  return round($distance, 2);
	}

?>

<head>
<style type="text/css">
	#weatherholder h1
	{
		background-color: #167DC4;
		color: white;
		font-size: 1.2em;
		height: 30px;
		margin: 0 0 5px;
		padding: 4px 0 0 5px
	}
	
	#weatherholder #leftcolumn{
		width:500px;
		float:left;
		margin: 0 0 0 10px;
	}
	
	#weatherholder #map{
		float:left;
		width:302px;
		height:302px;
		margin: 5px 0 0 20px;
		border:1px solid grey;
	}
</style>

<!-- link to latest jQuery code -->
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
<!-- load Google Maps API codebase -->
<script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>	

<script type="text/javascript">
	$(function()
	{
		//create new roadmap object in map div centered on Colorado at zoom level 8
		var map = new google.maps.Map(document.getElementById('map'),
		{
		zoom: 8,
		center: new google.maps.LatLng(<?php echo $my_latitude?>, <?php echo $my_longitude?>),
		mapTypeId: google.maps.MapTypeId.TERRAIN
		}); // end map block
		
		//Create wx station location marker w/ current conditions icon from WxUnderground
		marker = new google.maps.Marker(
		{
			position: new google.maps.LatLng(<?php echo $latitude?>,<?php echo $longitude?>),
			map: map,
			icon: new google.maps.MarkerImage(
			'<?php echo $current_icon?>',
			null,
			null,
			new google.maps.Point(0,0),
			new google.maps.Size(30,30)
			)
		});
		
		//Create cg location marker
		marker = new google.maps.Marker(
		{
			position: new google.maps.LatLng(<?php echo $my_latitude?>,<?php echo $my_longitude?>),
			map: map,
			icon: new google.maps.MarkerImage(
			'img/bluecgicon.jpg',
			null,
			null,
			new google.maps.Point(0,0),
			new google.maps.Size(22,22)
			)
		});
	});//end DOM load
</script>
</head>

<body>
	<div id="weatherholder">
		<h1>Current Observation</h1>
		<div id="leftcolumn">
		
		<?php
			echo "<div style='font-size:1.4em'>Location: ${location}</div>";
			echo "N ${display_latitude}&deg;&nbsp;W ${display_longitude}&deg;&nbsp;";
			echo "Elevation: ${elevation}<br/>";
			echo "Distance from campground: ${haversine} miles<br/><br/>";

			echo "<div style='font-size:1.2em'>";
			echo "<img style='border:1px solid #E5E5E5;margin-right:5px;vertical-align:middle;float:left' src='${current_icon}'/>";
			echo "<div style='font-size:1.6em;float:left'>${current_conditions}</div>";
			echo "<div style='clear:both'></div>";
			echo "<div style='font-size:1.6em;float:left'>${temp_f}&deg; F</div>";

			echo "<div style='float:left;margin: 17px 0 0 29px'>Dewpoint: ${dewpoint}&deg; F</div>";
			echo "<div style='clear:both'>Relative humidity: ${relative_humidity}</div>";
			echo "Winds: ${wind_string}<br/>";
			echo "Pressure: ${pressure_in} in<br />";
			echo "Visibility: ${visibility} mi<br/>";
			echo "Sunrise: ${sunrise_hour}:${sunrise_minute} am ";
			
			if ($sunset_hour>12)
			{
				$sunset_hour = $sunset_hour-12;
			}
			echo "Sunset: ${sunset_hour}:${sunset_minute} pm<br/><br/>";	
			
			echo "</div>";

			echo "${obs_time}<br/>";
			echo "Current weather conditions provided by ${title}";
		?>
		</div><!--end leftcolumn-->

		<div id="map"></div>
	</div><!--end weatherholder-->

