<?php
	//write new rating to tblratings
	//database connector
	include('../inc/mysql.inc.php');

	//build SQL statement to insert rating, rating date, and campground id into tblratings
	$query = sprintf("INSERT INTO tblratings (fkcgId, Rating, RatingDate)
				VALUES ('%s', '%s', '%s')", $_POST['cgid'], $_POST['newrating'], date('Y-m-d H:i:s'));
	
	//execute query
	$result = mysql_query($query);
	
	//Pass back results
	echo 'Result recorded';
?>