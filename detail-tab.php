<!-- detailtab.php -->
<?php
$CGNumber = $_GET['CGNo'];

//Connect To Database using include file
include './inc/mysql.inc.php';


$query = "SELECT * FROM tbldetail WHERE pkID = $CGNumber";
$result = mysql_query($query);

// check to see if result array was filled by query
if(mysql_num_rows($result)>0)
{
	// loop through result array
	while($row = mysql_fetch_array($result))
	{
		// Determine toilet type
		switch ($row['ToiletType'])
		{
		case "1": 
			$toiletType = "Outhouse";
			break;
		case "2":
			$toiletType = "Flush";
			break;
		case "3":
			$toiletType = "Outhouse and Flush";
			break;
		case "4":
			$toiletType = "None";
			break;
		case "5":
			$toiletType = "Unknown";
			break;
		default:
			$toiletType = "Unknown";
		} // end toilet switch

		// Determine water type
		switch ($row['WaterType'])
		{
		case "1": 
			$waterType = "Faucet/Municipal";
			break;
		case "2":
			$waterType = "Well/Hand Pump";
			break;
		case "3":
			$waterType = "Both";
			break;
		case "4":
			$waterType = "Non-Potable Only";
			break;
		case "5":
			$waterType = "None";
			break;
		case "5":
			$waterType = "Unknown";
			break;			
		default:
			$waterType = "Unknown";
		} // end water switch
	
		// Determine road type
		switch ($row['RoadType'])
		{
		case "1": 
			$roadType = "Paved";
			break;
		case "2":
			$roadType = "Dirt/Gravel";
			break;
		case "3":
			$roadType = "4-Wheel Access Only";
			break;
		case "4":
			$roadType = "No Roads";
			break;
		case "5":
			$roadType = "Unknown";
			break;				
		default:
			$roadType = "Unknown";
		} // end road switch

		// Determine fire type
		switch ($row['FireType'])
		{
		case "1": 
			$fireType = "Fire Ring";
			break;
		case "2":
			$fireType = "Raised BBQ";
			break;
		case "3":
			$fireType = "Banned Area";
			break;
		case "4":
			$fireType = "None";
			break;
		case "5":
			$fireType = "Unknown";
			break;			
		default:
			$fireType = "Unknown";
		} // end fire switch

		// Determine fire danger type
		switch ($row['FireDanger'])
		{
		case "1": 
			$fireDanger = "Low";
			break;
		case "2":
			$fireDanger = "Medium";
			break;
		case "3":
			$fireDanger = "High";
			break;
		case "4":
			$fireDanger = "Extreme";
			break;
		case "5":
			$fireDanger = "Banned";
			break;
		case "6":
			$fireDanger = "None";
			break;
		case "7":
			$fireDanger = "Unknown";
			break;			
		default:
			$fireDanger = "Unknown";
		} // end fire switch		
		
		// Showers available?		
		if ($row['ShowersYN'] == TRUE)
		{
			if ($row['ShowerCost'] > 0)
			{
				$showerYN = "Yes - $" . $row['ShowerCost'];
			}
			else
			{ $showerYN = "Yes"; }			
		}
		else
		{ $showerYN = "Not Available";} //end showeryn
	
		// Firewood available?
		switch ($row['FirewoodType'])
		{
			case "1":
				$firewoodType = "For Sale";
					if ($row['FirewoodCost'] > 0) { 
						$firewoodType = $firewoodType . ' - $' . $row['FirewoodCost'] . ' per bundle';
						}
				break;
			case "2":
				$firewoodType = "Collectable";
				break;
			case "3":
				$firewoodType = "None";
				break;
			case "4":
				$firewoodType = "Unknown";
				break;				
			default:
				$firewoodType = "Unknown";
		} // end firewoodtype case
		

		// Ice available?		
		if ($row['IceSaleYN'] == TRUE)
		{
			if ($row['IceCost'] > 0)
			{
				$iceYN = "Yes - $" . $row['IceCost'];
			}
			else
			{ $iceYN = "Yes"; }			
		}
		else
		{ $iceYN = "Not Available";} // end ice available

		// Bug problem?
		switch ($row['BugType'])
			{
			case "1":
				$bugType = "Flies";
				break;
			case "2":
				$bugType = "Mosquitos";
				break;
			case "3":
				$bugType = "None";
				break;
			case "4":
				$bugType = "Unknown";
				break;
			default:
				$bugType = "Unknown";
			} // end bugtype case

		// Bear area?
		if ($row['BearAreaYN'] == TRUE) {
				$bearAreaYN = "checked";
			}
			else
			{ $bearAreaYN = "";} // end if bear area

		// Trash Pickup area?
		if ($row['TrashPickupYN'] == TRUE) {
				$trashYN = "checked";
			}
			else
			{ $trashYN = "";}	//end if trash pickup		

		// Beetle Kill area?
		if ($row['BeetleKillAreaYN'] == TRUE) {
				$beetleKill = "checked";
			}
			else
			{ $beetleKill = "";} //end if beetle kill
			
		// Table at site?
		if ($row['TableYN'] == TRUE) {
				$table = "checked";
			}
			else
			{ $table = "";} //end if table
		
		// Cell coverage?
		switch ($row['CellQuality'])
			{
			case "1":
				$cellQuality = "Excellent";
				break;
			case "2":
				$cellQuality = "Good";
				break;
			case "3":
				$cellQuality = "Poor";
				break;
			case "4":
				$cellQuality = "None";
				break;
			case "5":
				$cellQuality = "Unknown";
				break;				
			default:
				$cellQuality = "Unknown";
			} // end cell coverage switch
			
		// Data coverage?
		if ($row['DataCoverageYN'] == TRUE) {
				$dataCoverageYN = "checked";
			}
			else
			{ $dataCoverageYN = "";} //end if table	
			
		// WiFi?
		if ($row['WifiYN'] == TRUE)
		{
			$wifiYN = "checked";
			if ($row['WifiCost'] > 0)
			{
				$wifiCost = ": $" . $row['WifiCost'];
			}
		}
		else
		{ 
			$wifiYN = "";
		} // end wifi available			
	} // end while loop through recordset
}// end if to determine if record exists
?>
<h1>Campground Details</h1>
<div id = "leftdetail">
	Toilets: <?php echo $toiletType?><br />
	Water: <?php echo $waterType?><br />
	Roads: <?php echo $roadType?><br />
	Fire Pit Type: <?php echo $fireType?><br />
	Fire Danger: <?php echo $fireDanger?><br />
	Firewood Availability: <?php echo $firewoodType?><br />
	Cell Coverage: <?php echo $cellQuality?><br />
	<input type="checkbox" <?php echo $dataCoverageYN?>> Data Coverage<br />
	<input type="checkbox" <?php echo $wifiYN?>> WiFi<br />
	</div><div id="rightdetail">
	Showers: <?php echo $showerYN?><br />
	Ice Availability: <?php echo $iceYN?><br />
	Bug Problem: <?php $bugType?><br />
	<input type="checkbox" <?php echo $table?>>Table at Site <img src='img/table-icon.png' class='icon' /><br />
	<input type="checkbox" <?php echo $trashYN?>>Trash Pickup<br />
	<input type="checkbox" <?php echo $bearAreaYN?>>Bear Area<br />
	<input type="checkbox" <?php echo $beetleKill?>>Beetle Kill Area<br />
</div>