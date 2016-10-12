<?php
// read ratings from tblratings
// database connector
include('inc/mysql.inc.php');

if (isset($_POST['cgid']))
{
	$CGNo = $_POST['cgid'];
}
else
{
	$CGNo = $_GET['cgid'];
}

// build SQL statement to read ratings for campground id from tblratings
// define select query to select campground ratings where primary key ID matches the campground ID
$starquery = "SELECT * FROM tblratings WHERE fkcgID = " . $CGNo;

// query the database for all campground ratings records and assign result to array
$starresult = mysql_query($starquery);

// check to see of result array was filled.  If yes, calculate average, if no, assign 0 to rating
if(mysql_num_rows($starresult)>0)
{
	// declare rating summary variable and initialize to zero
	$ratingsum = 0;
	
	// declare counter i and initialize to zero
	$i = 0;
	
	// loop through star result array
	while($row = mysql_fetch_array($starresult))
	{
		// increment i counter
		$i++;
		
		// sum the retrieved ratings
		$ratingsum = $ratingsum + $row['Rating'];
	} // end loop through star result array
	
	// calculate rating average and round up
	$ratingavg = ceil($ratingsum/$i);
} // end if number of rows > 0 loop	
else
{
	// if no ratings retrieved, set average to zero
	$ratingavg = 0;
}

//$returnvalue = 'i:' . $i++ . ' ratingsum:' . $ratingsum . ' ratingavg:' . $ratingavg;
//echo $returnvalue;
echo $ratingavg;
?>