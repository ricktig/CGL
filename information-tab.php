<!-- maintab.php -->
<?php
$CGNumber = $_GET['CGNo'];

//Connect To Database using include file
include './inc/mysql.inc.php';

$query = "SELECT * FROM tblmain WHERE pkID = $CGNumber";
$result = mysql_query($query);

if(mysql_num_rows($result)>0)
{
	while($row = mysql_fetch_array($result))
	{
		$cgOwner = $row['CGOwner'];
		switch ($cgOwner){
			case 'COSP':
				$cgOwner = 'Colorado State Park';
				break;
			case 'NFS':
				$cgOwner = 'National Forest Service';
				break;
			case 'BLM':
				$cgOwner = 'Bureau of Land Management';
				break;
			case 'NPS':
				$cgOwner = 'National Park Service';
				break;				
			case 'BMP':
				$cgOwner = 'Boulder Mountain Parks';
				break;
			case 'RMP':
				$cgOwner = 'Rifle Mountain Parks';
				break;
			case 'CE':
				$cgOwner = 'Canyon Enterprises';
				break;
			case 'DOW':
				$cgOwner = 'Division of Wildlife';
				break;
			case 'PRI':
				$cgOwner = 'Private';
				break;
		} // end campground owner case statement
		
		$cgOperator = $row['CGOperator'];
		switch ($cgOperator){
			case 'COSP':
				$cgOperator = 'Colorado State Park';
				break;
			case 'NFS':
				$cgOperator = 'National Forest Service';
				break;
			case 'BLM':
				$cgOperator = 'Bureau of Land Management';
				break;
			case 'RMRC':
				$cgOperator = 'Rocky Mountain Recreation Company';
				break;
			case 'FVLC':
				$cgOperator = 'Fraser Valley Lions Club';
				break;
			case 'ALL':
				$cgOperator = 'American Land and Leisure';
				break;
			case 'BMP':
				$cgOperator = 'Boulder Mountain Parks';
				break;
			case 'RMP':
				$cgOperator = 'Rifle Mountain Parks';
				break;
			case 'CE':
				$cgOperator = 'Canyon Enterprises';
				break;		
			case 'DOW':
				$cgOperator = 'Division of Wildlife';
				break;						
			case 'RRM':
				$cgOperator = 'Recreation Resource Management';
				break;					
			case 'PRI':
				$cgOperator = 'Private';
				break;
		} // end campground operator case statement
		
		$cgDescrip = $row['CGDescrip'];
		
		$status = $row['CGStatus'];
		switch ($status){
			case 'C':
				$status = 'Closed - Construction';
				break;
			case 'F':
				$status = 'Closed - Fire';
				break;
			case 'S':
				$status = 'Closed - Snow';
				break;
			case 'B':
				$status = 'Closed - Beetle Kill';
				break;
			case 'L':
				$status = 'Closed - Flood';
				break;
			case 'A':
				$status = 'Closed - Campground No Longer Maintained';
				break;
			case 'W':
				$status = 'Closed - Off Season';
				break;				
			case 'O':
				$status = 'Open';
				break;
		} // end campground status case statement
		
		
		$openYearRound = $row['OpenYearRoundYN'];
		$openDate = date('m/d/Y', strtotime($row['OpenDate']));
		$closeDate = date('m/d/Y', strtotime($row['CloseDate']));
		if($openYearRound){
			$openDate = "Open Year Round";
		}
		else
		{
			$openDate = $openDate . ' to ' . $closeDate;
		}
		
		if($row['CGStatus']=='C'|'F'|'B'|'S'|'A')
		{
			$openDate = 'Closed in 2013';
		}	
		
		$maxDayStay = $row['MaxDayStay'];
		if($maxDayStay<0){
			$maxDayStay = 'No limit';
		}
		else
		{
			$maxDayStay = $maxDayStay . ' days';
		}
		
		$maxPeopleCount = $row['MaxPeopleCount'];
		if($maxPeopleCount<0){
			$maxPeopleCount = 'No limit';
		}
		
		$longitude = $row['Longitude'];
		$latitude = $row['Latitude'];
		$elevation = $row['Elevation'];
		$totalSiteCount = $row['TotalSiteCount'];
		$tentSiteCount = $row['TentSiteCount'];
		
		
		$primitiveSiteCount = $row['PrimitiveSiteCount'];
		$boatInSiteCount = $row['BoatInSiteCount'];
		$elecSiteCount = $row['ElecSiteCount'];
		$fullSiteCount = $row['FullSiteCount'];
		$RVDumpYN = $row['RVDumpYN'];
		if($RVDumpYN == TRUE)
		{
			$RVDumpYN = 'checked';
		}

		$RVDumpFee = $row['RVDumpFee'];
		if($RVDumpFee < 0)
		{
			$RVDumpFee = ' No Charge';
		}
		else
		{
			$RVDumpFee = ' Fee: $' . $RVDumpFee;
		}
		

			
		$condition = $row['CGCondition'];
		switch ($condition){
			case '1':
				$condition = 'Excellent';
				break;
			case '2':
				$condition = 'Good';
				break;
			case '3':
				$condition = 'Fair';
				break;
			case '4':
				$condition = 'Poor';
				break;
		} // end condition case statement
		
		
		$groupSiteYN = $row['GroupSiteYN'];
		if ($groupSiteYN == TRUE)
			$groupSite = 'checked';
		else
			$groupSite = '';
		
		$cabinYN = $row['CabinYN'];
		if ($cabinYN == TRUE)
			$cabin = 'checked';
		else
			$cabin = '';
	
		$cabinCost = $row['CabinCost'];
		if ($cabinCost == 0)
		{
			$cabinCost = 'None';
		}
		
		$yurtYN = $row['YurtYN'];
		if ($yurtYN == TRUE)
			$yurt = 'checked';
		else
			$yurt = '';
			
		$handicapYN = $row['HandicapYN'];
		if ($handicapYN == TRUE)
			$handicap = 'checked';
		else
			$handicap = '';
			
		$campHostYN = $row['CampHostYN'];
		if ($campHostYN == TRUE)
			$campHost = 'checked';
		else
			$campHost = '';
			
		$reservableYN = $row['ReservableYN'];
		if ($reservableYN == TRUE)
			$reservable = 'checked';
		else
			$reservable = '';
		
		$reserveLink = $row['ReserveLink'];
		
		$siteCostLow = $row['SiteCostLow'];
		$siteCostHigh = $row['SiteCostHigh'];

		if ($siteCostLow == $siteCostHigh)
		{
			$siteCost = '$' . $siteCostLow;
		}
		else $siteCost = '$' . $siteCostLow . ' to $' .$siteCostHigh;
		
		if ($siteCost == '$0.00')
		{
			$siteCost = 'None';
		}
		

		$addVehCost = $row['AddVehCost'];
		$elecCost = $row['ElecCost'];
		$fullCost = $row['FullCost'];
		$groupCost = $row['GroupCost'];
					
		$pmtCashYN = $row['PmtCashYN'];
		if ($pmtCashYN == TRUE)
			$pmtCash = 'checked';
		else
			$pmtCash = '';

		$pmtCheckYN = $row['PmtCheckYN'];
		if ($pmtCheckYN == TRUE)
			$pmtCheck = 'checked';
		else
			$pmtCheck = '';

		$pmtCreditCardYN = $row['PmtCreditCardYN'];
		if ($pmtCreditCardYN == TRUE)
			$pmtCreditCard = 'checked';
		else
			$pmtCreditCard = '';

		$pmtHostYN = $row['PmtHostYN'];
		if ($pmtHostYN == TRUE)
			$pmtHost = 'checked';
		else
			$pmtHost = '';
			
		$pmtSelfPayYN = $row['PmtSelfPayYN'];
		if ($pmtSelfPayYN == TRUE)
			$pmtSelfPay = 'checked';
		else
			$pmtSelfPay = '';
			
		$dayUseYN = $row['DayUseYN'];
		if ($dayUseYN == TRUE)
			$dayUseYN = 'checked';
		else
			$dayUseYN = '';
			
		$dayUseCost = $row['DayUseCost'];
		$forestName = $row['ForestName'];
			
		// Comments
		$comments = $row['Comments']; 
		if (!$comments)
			$comments = 'None';
	
		// Build the html output
		// Add h1 header
		?>
		<h1>Campground Information</h1>
		<div id="leftdetail">
		Status:
		<?php echo $status;?>
		&nbsp;&nbsp;&nbsp;&nbsp;Condition:
		<?php echo $condition;?>
		<br />
		<?php
		if ($cgOwner == $cgOperator){
			echo 'Owner/Operator: ' . $cgOwner . '<br />';
		} else {
			if ($cgOwner){
				echo 'Owner: ' . $cgOwner . '<br />';
			}
			if ($cgOperator){
				echo 'Operator: ' . $cgOperator . '<br />';
			}
		}
		if ($forestName){
			echo 'Forest Name: ' . $forestName . '<br />';
		}?>
		<div id="cgdescrip">Description: <?php echo $cgDescrip?><br /></div>
		<span>Season: <?php echo $openDate?><br /></span>
		<span>Maximum Stay: <?php echo $maxDayStay?><br /></span>
		<span>Maximum # of People Per Site: <?php echo $maxPeopleCount?><br /></span>
		<span>Longitude: W <?php echo abs((float)$longitude)?>&deg;</span>
		<span>Latitude: N <?php echo $latitude?>&deg;<br /></span>
		<span>Elevation <?php echo $elevation?><br /></span>
		<span><div class="infotabhighlighted">Number of Sites:<br /></span>
		<span>Total: <?php echo $totalSiteCount?></span>
		echo "<img src='img/tent-icon.png' class='icon' />  Tent: " . $tentSiteCount . "  ";
		echo 'Primitive: ' . $primitiveSiteCount . "  ";
		echo 'Boat In: ' . $boatInSiteCount . "<br />";
		echo 'Electricity Only: ' . $elecSiteCount . "  ";
		echo 'Full Hookup: ' . $fullSiteCount . "<br /></div>";
		echo '<input type="checkbox"' . $RVDumpYN . '>RV Dump Station?';
		if ($RVDumpYN == TRUE){
			echo $RVDumpFee . '<br />';
		} else {
			echo '<br />';
		}
		echo '<input type="checkbox"' . $groupSite . '>Group Site?  ';
		echo '<input type="checkbox"' . $cabin . '>Cabins?  ';
		echo '<input type="checkbox"' . $yurt . '>Yurts?<br />';		
		echo '</div><div id="rightdetail">';
		echo '<input type="checkbox"' . $handicap . ">Handicap Accessible? <img src='img/handicap-icon.png' class='icon' /><br />";
		echo '<input type="checkbox"' . $campHost . '>Camp Host?<br />';
		echo '<input type="checkbox"' . $reservable . '>Reservable?  ';
		if ($reserveLink){
			echo '<a id="reservelink" href = "' . $reserveLink . '" target="_blank">Click Here To Reserve</a><br />';
		} else {
			echo '<br />';
		}
		echo '<div class="infotabhighlighted">Payment Information:<br />';
		echo 'Site Cost: ' . $siteCost . "<br />";
		
		if ($addVehCost<0){
			$addVehCost='N/A';
		}
		else
		{
			$addVehCost='$' . $addVehCost;
		}
		echo 'Additional Vehicle Cost: ' . $addVehCost . '<br />';

		if ($elecCost<0){
			$elecCost='N/A';
		}
		else
		{
			$elecCost='$' . $elecCost;
		}
		echo 'Electricity Site Cost: ' . $elecCost . '<br />';
		
		if ($fullCost<0){
			$fullCost='N/A';
		}
		else
		{
			$fullCost='$' . $fullCost;
		}
		echo 'Full Hookups Site Cost: ' . $fullCost . '<br />';
		
		if ($groupCost<0){
			$groupCost='N/A';
		}
		else
		{
			$groupCost='$' . $groupCost;
		}
			echo 'Group Site Cost: ' . $groupCost . '<br />';

		if ($cabinCost<0){
			$cabinCost='N/A';
		}
		else
		{
			$cabinCost='$' . $cabinCost;
		}
		echo 'Cabin Site Cost: ' . $cabinCost . '<br />';
		
		echo '<input type="checkbox"' . $dayUseYN . '>Day Use Fee? ';
		if ($dayUseYN){
			echo '$' . $dayUseCost . '<br />';
		} else {
			echo '<br />';
		}		
		echo '<input type="checkbox"' . $pmtCash . '>Cash ';
		echo '<input type="checkbox"' . $pmtCheck . '>Check ';
		echo '<input type="checkbox"' . $pmtCreditCard . '>Credit Card<br />';
		echo '<input type="checkbox"' . $pmtHost . '>Host/Cashier ';
		echo '<input type="checkbox"' . $pmtSelfPay . '>Self Pay Box <img src="img/pay-station-icon.png" class="icon" /><br /></div>';
		echo '<div id="commentbox">Comments: <br />' . $comments . "</div>";
		echo '</div><br />';
	}
}
?>