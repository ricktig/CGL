<!-- geocachetab.php -->
<?php
$latitude = $_GET['latitude'];
$longitude = $_GET['longitude'];
?>

<!-- Define div to geocaching map -->
<h1>Nearby Geocaches</h1>
<div id="geo">
<?php echo '<iframe src="http://www.geocaching.com/map/default.aspx?ll=' . $latitude . ',' . $longitude . '&z=14" width="100%" height="100%" frameborder="0"></iframe>' ?>
</div>