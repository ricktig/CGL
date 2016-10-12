<?php
//display page header
include 'header.php';
?>

<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />

<title>Contact Us - CampgroundsLive!</title>
</head>

<body>
	<div id="linkbox">
		<ul>
			<li>
			<a href="index.php">Home</a>
			</li>
			<li>
			<a href="#">==>&nbsp;Contact Us</a>
			</li>
		</ul>
	</div><!--end linkbox div-->

	<!-- Share your visit links content area -->
	<div id="mainbox" class="greenfill">
		<h1 class="leftmargin250">Contact Us</h1>
		<form id="contactusform" class="halfpagetext" action="contact-us-do.php" method="post">
			<p>Your Name</p>
			<input id="visitorname" name="visitorname" size="30" maxlength="70" />
			<p>Email Address</p>
			<input id="email" name="email" size="30" maxlength="70" />
			<p>Request Type</p>
			<select name="requesttype">
				<option value="CampgroundProblem">Incorrect Campground Info</option>
				<option value="Inappropriate">Inappropriate Photo or Post</option>
				<option value="Advertiser">Advertise With Us</option>
				<option value="Other">Other</option>
			</select>
			<p>Comments</p>
			<textarea id="comments" name="comments" rows="10" cols="78"></textarea>
			<input type = "submit" id="submitbutton" name="submitbutton" class="formbutton" value="Submit" />
		</form>
	</div><!--end mainbox div-->

	<?php
	include 'footer.php';
	?>