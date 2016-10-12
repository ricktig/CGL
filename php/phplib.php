<?php
//*************************************
// phplib.php
// PHP library file
// Copyright Applied GIS Solutions, LLC dba CampgroundsLive.com
// Author: Rick Rose
// Last modified: 9/23/2013
//*************************************
	//set current date - Month day, year
	//$curFjY = date('F j, Y');
	
	//set current year
	$curyear = date("Y");
	
	//fetch number of campgrounds currently in database
	function fetch_count_of_campgrounds()
	{
		//build select string
		$sql = "SELECT COUNT(*) FROM tblmain";
		//query database
		$result = mysql_query($sql);
		//fetch result
		$total_rows = mysql_fetch_row($result);
		//return count
		return $total_rows[0];
	}//end fetch_count_of_campgrounds
	
	// fetch userid from username
	function fetch_userid_from_username()
	{
		//get username from session variable set at login
		$username = $_SESSION['username'];
		//query user tables
		$sql = "SELECT pkId FROM tblusers WHERE UserName = '" . $username . "'";
		//echo $sql;
		$result=mysql_query($sql);
		//if result set then display results in table
		if ((!$result))
		{
			$userid='14';
		}
		else
		{
			//loop through result set
			while($row = mysql_fetch_array($result))
			{
				$userid = $row['pkId'];
			}
		}
		return $userid;
	}//end user_id_from_username function

	//fetch last three user comments for index.php
	function fetch_last_three_messages()
	{
		//query messages table for last three messages
		$sql = 'SELECT * FROM tblmessages ORDER BY ReportDate LIMIT 3';
		$str = null;

		$result = mysql_query($sql);

		//if result set then display results in table
		if (mysql_num_rows($result)<=0)
		{
			$str .= '';
		}
		else
		{
					
			while($row = mysql_fetch_array($result))
			{	
			//assign campground condition variable
				$message = $row['Comments'];
				$reportdate = date("F j, Y", strtotime($row['ReportDate']));
				$cgname = fetchCGNameByCGId($row['fkCGId']);
				$author = fetchUserNameByUserId($row['fkUserId']);
								
				$str.='<li style="background-color:white;height:90px;width:100%;border-bottom;1px solid grey">';
				$str.='<div style="font-size:1.0em;padding: 10px 0;">';
				$str.='<img src="img/campgroundicon.jpg" width="50" height="50" alt="campground icon" style="margin: 0 5px 0 10px;float:left" />';
				$str.='<div style="width:250px;float:right;">';
				$str.=$reportdate;
				$str.=' - ';
				$str.=$cgname;
				$str.=': ';
				$str.=$message;
				$str.=' - ';
				$str.=$author;
				$str.='</div>';
				$str.='</div>';
				$str.='</li>';
			}
		
			return $str;
		}
	}//end function fetch_last_three_messages
	
	//fetch last three user comments for index.php
	function fetch_alert_messages()
	{
		
		//query messages table for last three messages
		$sql = 'SELECT * FROM tblalerts ORDER BY EntryDate';
		$str = null;
		$result = mysql_query($sql);

		//if result set then display results in table
		if (mysql_num_rows($result)<=0)
		{
			$str .= '';
		}
		else
		{
			while($row = mysql_fetch_array($result))
			{	
			//assign campground condition variable
	
				$message = $row['AlertMessage'];
				$entrydate = date("F j, Y", strtotime($row['EntryDate']));
				
				$str.='<li style="background-color:white;height:90px;width:100%;border-bottom;1px solid grey">';
				$str.='<div style="font-size:1.0em;padding: 10px 0;">';
				$str.='<img src="img/yellow-alert.jpg" width="50" height="50" alt="alert icon" style="margin: 0 5px 0 10px;float:left" />';
				$str.='<div style="width:250px;float:right;">';
				$str.=$entrydate;
				$str.=' - ';
				$str.=$message;
				$str.='</div>';
				$str.='</div>';
				$str.='</li>';
			}
		
			return $str;
		}
	}//end function fetch_last_three_messages

	//create json object with all campgrounds for datatable on find-campground-by-query.php
	function fetch_all_campgrounds_json()
	{
	$str = null;

	$sql = "SELECT * FROM tblmain ORDER BY CGName";

	$result = mysql_query($sql);

		//if result set then display results in table
		if (mysql_num_rows($result)<=0)
		{
			$str .= '';
		}
		else
		{
					
			while($row = mysql_fetch_array($result))
			{	
			//assign campground condition variable
				$cgno = $row['pkID'];
				$cgname = $row['CGName'];
				$nosites = $row['TotalSiteCount'];
				$lng = $row['Longitude'];
				$lat = $row['Latitude'];
				$nearestcity = $row['NearestCity'];
				$metadata = buildSearchMetadataString($cgno);
				
				$str .= '[';
				$str .= '"' . $cgno .'",';
				$str .= '"' . $cgname .'",';
				$str .= '"' . $nosites .'",';
				$str .= '"' . sprintf("%0.6f", round($lng,6))  .'&deg;",';
				$str .= '"' . sprintf("%0.6f", round($lat,6))  .'&deg;",';
				$str .= '"' . $nearestcity .'",';
				$str .= '"' . $metadata .'"';
				$str .= '],';		
			}
			
			$str = substr($str, 0, strlen($str)-1);
			
			return $str;
		}
	}//end function fetch_all_campgrounds_json
	
	//query all messages for a specific userid for my-campgrounds-live.php page
	function fetch_messages_by_userid_json()
	{
		$str = null;
		
		$userid = fetch_userid_from_username();
		//echo $userid;
		$sql = "SELECT * FROM tblmessages WHERE fkUserId = $userid ORDER BY ReportDate";
		//echo $sql;

		$result = mysql_query($sql);

		//if result set then display results in table
		if (($result)==0)
		{
			$str .= '';
		}
		else
		{
					
			while($row = mysql_fetch_array($result))
			{	
			//assign campground condition variable
				$cgno = $row['pkId'];
				$cgname = fetchCGNameByCGId($row['fkCGId']);
				$reportdate = $row['ReportDate'];
				$startdate = $row['StartDate'];
				$enddate = $row['EndDate'];
				$cgcondition = $row['CGCondition'];
				switch($cgcondition)
				{
					case 'E':
						$cgcondition = "Excellent";
						break;
					case 'G':
						$cgcondition = 'Good';
						break;
					case 'F':
						$cgcondition = 'Fair';
						break;
					case 'P':
						$cgcondition = 'Poor';
						break;
					default:
						$cgcondition = 'Good';
				}
				
				
				$comments = $row['Comments'];
			
				$str .= '[';
				$str .= '"' . $cgno .'",';
				$str .= '"' . $cgname .'",';
				$str .= '"' . $reportdate .'",';
				$str .= '"' . $startdate .'",';
				$str .= '"' . $enddate .'",';
				$str .= '"' . $cgcondition .'",';
				$str .= '"' . $comments .'"';
				$str .= '],';		
			}
			
			$str = substr($str, 0, strlen($str)-1);
			
			return $str;
		}
	}//end function fetch_messages_by_userid_json


	//query all messages for a specific campground for detail-tab.php page
	function fetch_messages_by_campgroundid_json($cgId)
	{
		$str = null;
	
		$sql = "SELECT * FROM tblmessages WHERE fkCGId = $cgId ORDER BY ReportDate";

		$result = mysql_query($sql);

		//if result set then display results in table
		if (mysql_num_rows($result)==0)
		{
			$str .= 'None';
		}
		else
		{
					
			while($row = mysql_fetch_array($result))
			{	
			//assign campground condition variable
				$cgno = $row['pkId'];
				//$cgname = fetchCGNameByCGId($row['pkId']);
				$username = fetchUserNameByUserId($row['fkUserId']);
				$reportdate = $row['ReportDate'];
				$startdate = $row['StartDate'];
				$enddate = $row['EndDate'];
				$cgcondition = $row['CGCondition'];
				switch($cgcondition)
				{
					case 'E':
						$cgcondition = "Excellent";
						break;
					case 'G':
						$cgcondition = 'Good';
						break;
					case 'F':
						$cgcondition = 'Fair';
						break;
					case 'P':
						$cgcondition = 'Poor';
						break;
					default:
						$cgcondition = 'Good';
				}
				
				
				$comments = $row['Comments'];
			
				$str .= '[';
				$str .= '"' . $cgno .'",';
				$str .= '"' . $username .'",';
				$str .= '"' . $reportdate .'",';
				$str .= '"' . $startdate .'",';
				$str .= '"' . $enddate .'",';
				$str .= '"' . $cgcondition .'",';
				$str .= '"' . $comments .'"';
				$str .= '],';		
			}
			
			$str = substr($str, 0, strlen($str)-1);
			
			return $str;
		}
	}//end function fetch_all_campgrounds_json	

	//query all favorite campgrounds for a specific userid for my-favorite-campgrounds.php page
	function fetch_my_favorite_campgrounds()
	{
		$str = null;
		
		$userid = fetch_userid_from_username();
		//echo $userid;
		$sql = "SELECT * FROM tblfavoritecgs WHERE fkUserId = $userid";
		//echo $sql;

		$result = mysql_query($sql);

		//if result set then display results in table
		if (($result)==0)
		{
			$str .= '';
		}
		else
		{
					
			while($row = mysql_fetch_array($result))
			{	
			//assign campground condition variable
				$cgno = $row['pkId'];
				$cgname = fetchCGNameByCGId($row['fkCGId']);
				$adddate = $row['AddDate'];
				$comments = $row['Comments'];
			
				$str .= '[';
				$str .= '"' . $cgno .'",';
				$str .= '"' . $cgname .'",';
				$str .= '"' . $adddate .'",';
				$str .= '"' . $comments .'"';
				$str .= '],';		
			}
			
			$str = substr($str, 0, strlen($str)-1);
			
			return $str;
		}
	}//end function fetch_my_favorite_campgrounds
	
	
	
	//fetch campground name by campground id
	function fetchCGNameByCGId($CGId)
	{
		$sql = "SELECT CGName FROM tblmain WHERE pkID = '" . $CGId . "'";
		$result = mysql_query($sql);
		
		while($row = mysql_fetch_array($result))
		{
			$CGName = $row['CGName'];
		}
		
		return $CGName;
	}
	
	//fetch username by userid
	function fetchUserNameByUserId($UserId)
	{
		$sql = "SELECT UserName FROM tblusers WHERE pkID = '" . $UserId . "'";
		$result = mysql_query($sql);
		
		while($row = mysql_fetch_array($result))
		{
			$UserName = $row['UserName'];
		}
		
		return $UserName;
	}

	//fetch userid by email
	function fetchUserNameByEmail($email)
	{
		$sql = "SELECT UserName FROM tblusers WHERE EmailAddress = '" . $email . "'";
		$result = mysql_query($sql);

		while($row = mysql_fetch_array($result))
		{
			$UserName = $row['UserName'];
		}

		return $UserName;
	}
	
	//fetch Password Hash for password reset from tblusers
	function fetchDatabaseHashByUserName($uname)
	{
		$sql = "SELECT ExpiryToken FROM tblusers WHERE UserName ='" . $uname . "'";
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result))
		{
			$DatabaseExpiryToken = $row['ExpiryToken'];
		}

		return $DatabaseExpiryToken;
	}
	
	//fetch Password reset expiry date from tblusers
	function fetchDatabaseExpiry($uname)
	{
		$sql = "SELECT ExpiryTime FROM tblusers WHERE UserName ='" . $uname . "'";
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result))
		{
			$DatabaseExpiryTime = $row['ExpiryTime'];
		}
		
		return $DatabaseExpiryTime;
	}
	
	//Build search metadata string
	function buildSearchMetadataString($cgid)
	{
		$meta = '';
		$sql = "SELECT * FROM tblmain WHERE pkID = $cgid";
		$sql2 = "SELECT * FROM tblrecreation WHERE pkID = $cgid";
		$sql3 = "SELECT * FROM tbldetail WHERE pkID = $cgid";
		
				
		//loop through tblmain
		$result = mysql_query($sql);
		while ($row = mysql_fetch_array($result))
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
			$meta.=$cgOwner . ' ';
			
			//Campgrounds status
			if($row['CGStatus']=='C'|'F'|'B'|'S'|'A')
			{
				$status = 'Closed';
			}
			else if($row['CGStatus']=='O')
			{
				$status = 'Open';
			}
			else
			{
				$status = 'Unknown';
			}
			$meta.=$status . ' ';
				
			//RV Dump Station
			$RVDumpYN = $row['RVDumpYN'];
			if($RVDumpYN == TRUE)
				$meta.='Dump Station' . ' ';
			
			$groupSiteYN = $row['GroupSiteYN'];
			if ($groupSiteYN == TRUE)
				$meta.="Group Site" . ' ';
			
			$cabinYN = $row['CabinYN'];
			if ($cabinYN == TRUE)
				$meta.= 'Cabin' . ' ';

			$yurtYN = $row['YurtYN'];
			if ($yurtYN == TRUE)
				$meta.='Yurt' . ' ';
				
			$handicapYN = $row['HandicapYN'];
			if ($handicapYN == TRUE)
				$meta.= 'Handicap' . ' ';
				
			$campHostYN = $row['CampHostYN'];
			if ($campHostYN == TRUE)
				$meta.='Host' . ' ';
				
			$reservableYN = $row['ReservableYN'];
			if ($reservableYN == TRUE)
				$meta.= 'Reserve Reservation Reservable' . ' ';
				
			$pmtCashYN = $row['PmtCashYN'];
			if ($pmtCashYN == TRUE)
				$meta.="Cash" . ' ';
				
			$pmtCheckYN = $row['PmtCheckYN'];
			if ($pmtCheckYN == TRUE)
				$meta.='Check' . ' ';
				
			$pmtCreditCardYN = $row['PmtCreditCardYN'];
			if ($pmtCreditCardYN == TRUE)
				$meta.="Credit VISA Mastercard Discover" . ' ';
		}//end loop tblmain

		//loop through tblrecreation
		$result2 = mysql_query($sql2);
		while ($row2 = mysql_fetch_array($result2))
		{
			//Bike Trails
			if($row2['BikeTrailType']<=4)
				$meta .= 'Bicycle Trail Bike' . ' ';
			
			// Bike Rental
			if ($row2['BikeRentalYN'] == TRUE)
				$meta.= "Bike Rental Bicycle Rental" . ' ';
				
			//ATV Trails
			if ($row2['ATVTrailYN'] == TRUE) 
				$meta.= "ATV Trails" . ' ';
			
			//ATV Rental
			if ($row2['ATVRentalYN'] == TRUE)
			$meta.= "ATV Rental" . ' ';
			
			//Fishing
			if($row2['FishingType']<=5)
				$meta .= 'Fish Fishing' . ' ';
			
			//Boating
			if($row2['BoatingType']<=6)
				$meta .= 'Boat Boating' . ' ';
			
			//Boat Rental
			if ($row2['BoatRentalYN'] == TRUE)
				$meta.= "Boat Rental" . ' ';			
			
			//Swimming
			if($row2['SwimmingType']<=5)
				$meta .= 'Swim Swimming' . ' ';			
				
			// River Rafting
			if ($row2['RiverRaftingYN'] == TRUE)
			$meta.= "Rafting". ' ';	
			
			// Climbing
			if ($row2['ClimbingYN'] == TRUE)
			$meta.=  "Climb Climbing". ' ';	
			
			// Hiking
			if ($row2['HikingYN'] == TRUE)
			$meta.= "Hike Hiking". ' ';	
			
			// Trailhead
			if ($row2['TrailheadYN'] == TRUE)
			$meta.= "Trailhead". ' ';	
			
			// Geocaching
			if ($row2['GeocachingYN'] == TRUE) 
				$meta.= "Trailhead". ' ';	
				
			// Hot Springs
			if ($row2['HotSpringYN'] == TRUE) 
				$meta.= "Hot Spring". ' ';	
				
			// Downhill Skiing
			if ($row2['DownhillSkiYN'] == TRUE) 
				$meta.= "Downhill Skiing". ' ';	
				
			// Cross Country Skiing
			if ($row2['XCountrySkiYN'] == TRUE) 
				$meta.= "Cross Country Skiing". ' ';	
				
			// Snowmobiling
			if ($row2['SnowmobilingYN'] == TRUE) 
				$meta.= "Snowmobile Snowmobiling". ' ';	
				
			// Snowshoeing
			if ($row2['SnowshoeingYN'] == TRUE) 
				$meta.= "Snowshoe Showshoeing". ' ';	
				
			// Ice Climbing
			if ($row2['IceClimbingYN'] == TRUE) 
				$meta.= "Ice Climbing". ' ';	
				
			// Scenic Drive
			if ($row2['ScenicDriveYN'] == TRUE) 
				$meta.= "Scenic Drive". ' ';	
				
			// Horse Trails
			if ($row2['HorseTrailsYN'] == TRUE) 
				$meta.= "Horse Trails". ' ';	
				
			// Horse Corral
			if ($row2['HorseCorralYN'] == TRUE) 
				$meta.= "Horse Corral". ' ';	
				
			// Horseshoe Pit
			if ($row2['HorseshoePitYN'] == TRUE) 
				$meta.= "Horseshoe". ' ';	
				
			// Playground
			if ($row2['PlaygroundYN'] == TRUE) 
				$meta.= "Playground". ' ';	
				
			// Spelunking
			if ($row2['SpelunkingYN'] == TRUE) 
				$meta.= "Cave Spelunking". ' ';	
				
			// Museum
			if ($row2['MuseumYN'] == TRUE)
				$meta.="Museum";
				
			// Festival
			if ($row2['FestivalYN'] == TRUE) 
				$meta.= "Festival". ' ';	
				
			// Golfing
			if ($row2['GolfingYN'] == TRUE) 
				$meta.= "Golf Golfing". ' ';	
				
			// Gambling
			if ($row2['GamblingYN'] == TRUE) 
				$meta.= "Gaming Gambling". ' ';	
				
			// Shopping
			if ($row2['ShoppingYN'] == TRUE) 
			$meta.= "Shopping". ' ';	
		
		}//end loop through tblrecreation
		
		//loop through tbldetail
		$result3 = mysql_query($sql3);
		while ($row3 = mysql_fetch_array($result3))
		{
			//Toilets
			if($row3['ToiletType']==1)
				$meta .= 'Outhouse' . ' ';
				
			if($row3['ToiletType']==2)
				$meta .= 'Flush' . ' ';

			if($row3['ToiletType']==3)
				$meta .= 'Flush Outhouse' . ' ';
				
			//Water
			if($row3['WaterType']<=3)
				$meta .= 'Water' . ' ';
			
			//Showers
			if ($row3['ShowersYN'] == TRUE)
				$meta .= 'Showers' . ' ';
				
			//Firewood
			if($row3['FirewoodType']<=2)
				$meta .= 'Firewood' . ' ';
				
			//Ice
			//if ($row['IceSaleYN'] == TRUE)
			//	$meta .= 'Ice' . ' ';
			
			// Trash Pickup area?
			if ($row3['TrashPickupYN'] == TRUE)
				$meta.='Trash' . ' ';
				
			//Picnic table
			if ($row3['TableYN'] == TRUE)
				$meta.='Table' . ' ';
				
			//Cell Service
			if($row3['CellQuality']<=3)
				$meta .= 'Cell Service' . ' ';	

			//Data Coverage
			if ($row['DataCoverageYN'] == TRUE)
				$meta.='Data Coverage' . ' ';
				
			//Wifi?
			if ($row['WifiYN'] == TRUE)
				$meta.='WiFi' . ' ';
		}//end loop through tbldetail

		return $meta;
	}//end buildSearchMetadataString function
		

?>