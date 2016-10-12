<?php
//$login=$_SESSION['username'];
$login = 1;
$to = "info@campgroundslive.com";
$subject = "Contact us";
$message = $_POST['comments'];
$from = $_POST['email'];
$headers = "From:" . $from;

//display page header
include 'header.php';
?>

<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />

<title>Thank You For Your Comment - CampgroundsLive!</title>
</head>

<body>
	<div id="linkbox">
		<ul>
			<li>
			<a href="index.php">Home</a>
			</li>
			<li>
			<a href="contact-us.php">==>&nbsp;Contact Us</a>
			</li>
		</ul>
	</div><!--end linkbox div-->
	<!-- Share your visit links content area -->
	<div id="mainbox" class="greenfill">
		<h1 class="leftmargin250">Contact Us</h1>
		<div class="halfpagetext">
		
			<?php
			if (empty($_POST['visitorname']) && empty($_POST['email']) && empty($_POST['comments']) && empty($_POST['requesttype']) && empty($_POST['Submit']))
			//valid form fields
			{
			//send email
			mail($to,$subject,$message,$headers);	
			?>		
				<p>Thank you for your comment.  We will contact you within 48 hours.</p>
					
			<?php
			} // end valid form fields true
			else
			//login false
			{
			?>
				<p>We didn't get your information.  Please go back and try again.</p>
				
				<form><input type="button" class="backbutton formbutton" value="Back" onClick="history.go(-1);return true;"></form>

			<?php
			} // end valid form fields false
			?>
		
		</div><!--end halfpagetext div-->
	</div><!--end mainbox div-->
<?php
include 'footer.php';
?>
