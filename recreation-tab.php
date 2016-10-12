<!-- recreationtab.php -->
<?php
$CGNumber = $_GET['CGNo'];

//Connect To Database using include file
include './inc/mysql.inc.php';

$query = "SELECT * FROM tblrecreation WHERE pkID = $CGNumber";
$result = mysql_query($query);

if($result)
{
	while($row = mysql_fetch_array($result))
	{

		// Bike Trail Type
		switch ($row['BikeTrailType'])
					{
					case "1": 
						$bikeTrail = ": Paved - Outside Campground";
						$bikeTrailYN = "checked";
						break;
					case "2": 
						$bikeTrail = ": Dirt - Outside Campground";
						$bikeTrailYN = "checked";
						break;
					case "3": 
						$bikeTrail = ": Paved - In Campground Only";
						$bikeTrailYN = "checked";
						break;
					case "4": 
						$bikeTrail = ": Dirt - In Campground Only";
						$bikeTrailYN = "checked";
						break;
					case "5": 
						$bikeTrail = "";
						$bikeTrailYN = "";
						break;
					case "6": 
						$bikeTrail = ": Unknown";
						$bikeTrailYN = "";
						break;						
					default:
						$bikeTrail = "Unknown";
				} // end bikeTrail switch

		// Bike Rental
		if ($row['BikeRentalYN'] == TRUE) {
			$bikeRentalYN = "checked";
		} else {
			$bikeRentalYN = "";
		} // end bikeRentalYN if then		
		
		// ATV Trails
		if ($row['ATVTrailYN'] == TRUE) {
			$atvYN = "checked";
		} else {
			$atvYN = "";
		} // end ATV Trails if then

		// ATV Rental
		if ($row['ATVRentalYN'] == TRUE) {
			$atvRentalYN = "checked";
		} else {
			$atvRentalYN = "";
		} // end atvRentalYN if then		

		// Fishing Type
		switch ($row['FishingType'])
		{
			case "1": 
				$fishing = ": Pond";
				$fishingYN = "checked";
				break;
			case "2": 
				$fishing = ": Lake";
				$fishingYN = "checked";
				break;
			case "3": 
				$fishing = ": River/Stream";
				$fishingYN = "checked";
				break;
			case "4": 
				$fishing = ": Ocean";
				$fishingYN = "checked";
				break;
			case "5": 
				$fishing = ": Fish Farm";
				$fishingYN = "checked";
				break;
			case "6": 
				$fishing = "";
				$fishingYN = "";
				break;
			case "7": 
				$fishing = ": Unknown";
				$fishingYN = "";
				break;
			default:
				$fishing = "";
				$fishingYN = "";
		} // end boating switch
		
		// Boating Type
		switch ($row['BoatingType'])
		{			
			case "1": //none
				$boating = ": Pond - Hand Launch";
				$boatingYN = "checked";
				break;
			case "2": 
				$boating = ": Lake - Boat Ramp";
				$boatingYN = "checked";
				break;
			case "3": 
				$boating = ": Lake - Hand Launch Only";
				$boatingYN = "checked";
				break;
			case "4": 
				$boating = ": River - Boat Ramp";
				$boatingYN = "checked";
				break;
			case "5": 
				$boating = ": River - Hand Launch Only";
				$boatingYN = "checked";
				break;
			case "6": 
				$boating = ": Ocean";
				$boatingYN = "checked";
				break;
			case "7": 
				$boating = "";
				$boatingYN = "";
				break;
			case "8": 
				$boating = ": Unknown";
				$boatingYN = "";
				break;
			default:
				$boating = "";
				$boatingYN = "";
				} // end boating switch

		// Boat Rental
		if ($row['BoatRentalYN'] == TRUE) {
			$boatRentalYN = "checked";
		} else {
			$boatRentalYN = "";
		} // end boatRentalYN if then

		// Swimming Type
		switch ($row['SwimmingType'])
		{
			case"1":
				$swim = ": Pool";
				$swimmingYN = "checked";
			case "2": 
				$swim = ": Lake";
				$swimmingYN = "checked";
				break;
			case "3": 
				$swim = ": River";
				$swimmingYN = "checked";
				break;
			case "4": 
				$swim = ": Hot Springs";
				$swimmingYN = "checked";
				break;
			case "5": 
				$swim = ": Ocean";
				$swimmingYN = "checked";
				break;
			case "6":
				$swim = "";
				$swimmingYN = "";
				break;
			case "7":
				$swim=": Unknown";
				$swimmingYN = "";
				break;
			case "8":
				$swim=": Swim Beach";
				$swimmingYN = "checked";
				break;	
			default:
				$swim = ": Unknown";
				$swimmingYN = "";
		} // end swim switch
			
		// River Rafting
		if ($row['RiverRaftingYN'] == TRUE) {
			$riverRaftingYN = "checked";
		} else {
			$riverRaftingYN = "";
		} // end riverRaftingYN if then
		
		// Climbing
		if ($row['ClimbingYN'] == TRUE) {
			$climbingYN = "checked";
		} else {
			$climbingYN = "";
		} // end climbingYN if then
		
		// Hiking
		if ($row['HikingYN'] == TRUE) {
			$hikingYN = "checked";
			$hiking = "";
		} else {
			$hikingYN = "";
			$hiking ="";
		} // end hiking if then
		
		// Trailhead
		if ($row['TrailheadYN'] == TRUE) {
			$trailheadYN = "checked";
			$trailhead = "";
			if ($row['HikingTrailNumber'] == TRUE) {
					$trailhead = ": " . $row['HikingTrailNumber'];
				}
		} else {
			$trailheadYN = "";
			$trailhead = "";
		} // end trailheadyn if then
		
		// Geocaching
		if ($row['GeocachingYN'] == TRUE) {
			$geocachingYN = "checked";
		} else {
			$geocachingYN = "";
		} // end geocachingYN if then
		
		// Hot Springs
		if ($row['HotSpringYN'] == TRUE) {
			$hotSpringYN = "checked";
		} else {
			$hotSpringYN = "";
		} // end hotSpringYN if then
		
		// Downhill Skiing
		if ($row['DownhillSkiYN'] == TRUE) {
			$downhillSkiYN = "checked";
		} else {
			$downhillSkiYN = "";
		} // end downhillSkiYN if then
		
		// Cross Country Skiing
		if ($row['XCountrySkiYN'] == TRUE) {
			$xCountrySkiYN = "checked";
		} else {
			$xCountrySkiYN = "";
		} // end xCountrySkiYN if then
		
		// Snowmobiling
		if ($row['SnowmobilingYN'] == TRUE) {
			$snowmobileYN = "checked";
		} else {
			$snowmobileYN = "";
		} // end snowmobileYN if then
		
		// Snowshoeing
		if ($row['SnowshoeingYN'] == TRUE) {
			$snowshoeYN = "checked";
		} else {
			$snowshoeYN = "";
		} // end snowshoeYN if then

		// Ice Climbing
		if ($row['IceClimbingYN'] == TRUE) {
			$iceClimbYN = "checked";
		} else {
			$iceClimbYN = "";
		} // end snowmobileYN if then
		
		// Scenic Drive
		if ($row['ScenicDriveYN'] == TRUE) {
			$scenicDriveYN = "checked";
		} else {
			$scenicDriveYN = "";
		} // end scenicDriveYN if then
		
		// Horse Trails
		if ($row['HorseTrailsYN'] == TRUE) {
			$horseTrailsYN = "checked";
		} else {
			$horseTrailsYN = "";
		} // end horseTrailsYN if then
		
		// Horse Corral
		if ($row['HorseCorralYN'] == TRUE) {
			$horseCorralYN = "checked";
		} else {
			$horseCorralYN = "";
		} // end horseCorralYN if then
		
		// Horseshoe Pit
		if ($row['HorseshoePitYN'] == TRUE) {
			$horseshoePitYN = "checked";
		} else {
			$horseshoePitYN = "";
		} // end horseshoePitYN if then
		
		// Playground
		if ($row['PlaygroundYN'] == TRUE) {
			$playgroundYN = "checked";
		} else {
			$playgroundYN = "";
		} // end playgroundYN if then
		
		// Spelunking
		if ($row['SpelunkingYN'] == TRUE) {
			$spelunkingYN = "checked";
		} else {
			$spelunkingYN = "";
		} // end spelunkingYN if then
		
		// Museum
		if ($row['MuseumYN'] == TRUE) {
			$museumYN = "checked";
		} else {
			$museumYN = "";
		} // end museumYN if then
		
		// Festival
		if ($row['FestivalYN'] == TRUE) {
			$festivalYN = "checked";
		} else {
			$festivalYN = "";
		} // end festivalYN if then
		
		// Golfing
		if ($row['GolfingYN'] == TRUE) {
			$golfingYN = "checked";
		} else {
			$golfingYN = "";
		} // end golfingYN if then
		
		// Gambling
		if ($row['GamblingYN'] == TRUE) {
			$gamblingYN = "checked";
		} else {
			$gamblingYN = "";
		} // end gamblingYN if then

		// Shopping
		if ($row['ShoppingYN'] == TRUE) {
			$shoppingYN = "checked";
		} else {
			$shoppingYN = "";
		} // end shoppingYN if then

	} // end while: loop through each record
	
} // end if: query result found
?>

<!-- display output in two columns defined by leftdiv and rightdiv -->
<!-- summer activites in leftdetail -->
<h1>Things To Do</h1>
<div id="leftdetail">
	<strong>Summer Activities:</strong><br />
	<input type="checkbox" <?php echo $scenicDriveYN?> />Scenic Drive<br/>
	<input type="checkbox" <?php echo $bikeTrailYN?> />Bike Trails<br/>
	<input type="checkbox" <?php echo $atvYN?> />ATV Trails 
	<input type="checkbox" <?php echo $atvRentalYN?> />ATV Rental<br/>
	<input type="checkbox" <?php echo $fishingYN?> />Fishing <?php $fishing?><br/>
	<input type="checkbox" <?php echo $boatingYN?> />Boating <?php $boating?><br/>
	<input type="checkbox" <?php echo $boatRentalYN?> />Boat Rental<br/>
	<input type="checkbox" <?php echo $swimmingYN?> />Swimming <?php $swim?><br/>
	<input type="checkbox" <?php echo $riverRaftingYN?> />River Rafting<br/>
	<input type="checkbox" <?php echo $climbingYN?> />Climbing<br/>
	<input type="checkbox" <?php echo $hikingYN?> />Hiking <br/>
	<input type="checkbox" <?php echo $trailheadYN?> />Trailhead <?php $trailhead?><br/>
	<input type="checkbox" <?php echo $geocachingYN?> />Geocaching<br/>
	<input type="checkbox" <?php echo $hotSpringYN?> />Hot Springs<br/>
	<input type="checkbox" <?php echo $horseTrailsYN?> />Horse Trails
	<input type="checkbox" <?php echo $horseCorralYN?> />Horse Corral<br/>
	<input type="checkbox" <?php echo $horseshoePitYN?> />Horseshoe Pit<br/>
	<input type="checkbox" <?php echo $playgroundYN?> />Playground<br/>
	<input type="checkbox" <?php echo $spelunkingYN?> />Spelunking<br/>
	</div>
	<!--winter activities in rightdetail div-->
	<div id="rightdetail">
	<strong>Winter Activities:</strong><br/>
	<input type="checkbox" <?php echo $downhillSkiYN?> />Downhill Skiing<br/>
	<input type="checkbox" <?php echo $xCountrySkiYN?> />Cross Country Skiing<br/>
	<input type="checkbox" <?php echo $snowmobileYN?> />Snowmobiling<br/>
	<input type="checkbox" <?php echo $snowshoeYN?> />Snowshoeing<br/>
	<input type="checkbox" <?php echo $downhillSkiYN?> />Sledding<br/>
	<input type="checkbox" <?php echo $iceClimbYN?> />Ice Climbing<br/>
	<!--nearby activities  in rightdetail div-->
	<strong>Nearby Activities:</strong><br/>
	<input type="checkbox" <?php echo $museumYN?> />Museum<br/>
	<input type="checkbox" <?php echo $festivalYN?> />Festival<br/>
	<input type="checkbox" <?php echo $golfingYN?> />Golfing<br/>
	<input type="checkbox" <?php echo $gamblingYN?> />Gambling<br/>
	<input type="checkbox" <?php echo $shoppingYN?> />Shopping<br/>
</div>