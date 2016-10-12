<?php
	//write new rating to tblratings
	//database connector
	include('../inc/mysql.inc.php');
	
	//assign POST inputs to variables
	$cgid = $_POST['cgid'];
	$userid = $_POST['userid'];
	
	//check for invalid user id
	if (is_numeric($userid) && $userid > 0 && is_numeric($cgid) && $cgid > 0 && $cgid < $cgcount)
	{
		//build SQL statement to insert rating, rating date, and campground id into tblratings
		$query = sprintf("INSERT INTO tblfavoritecgs (fkCGId, fkUserId, AddDate,Comments)
					VALUES ('%s', '%s', '%s', '%s')", $_POST['cgid'], $userid, date('Y-m-d H:i:s'),'');
		
		echo $query;
		//execute query
		$result = mysql_query($query);
		
		//Pass back results
		return 'Favorite added!';
	}
	else
	{//invalid results
		return 'We couldn\'t save your results';
	}
	
?>