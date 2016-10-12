<?php
//start session
if(!isset($_SESSION['username']))
{
	session_start();
}

//include php function library
include 'php/phplib.php';

if (isset($_SESSION['username']))
{
	//logged in
	$username = $_SESSION['username'];
	$buttonfx = "Logout";
	$linkfx = "logout";
}
else
{
	//logged out
	$username = 'Guest';
	$buttonfx = "Login";
	$linkfx = "login";
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<!-- link to CGL cascading stylesheets -->
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<link rel="stylesheet" type="text/css" href="css/pulldown2.css" />
	<img src="img/img_6710.jpg" id="fullscreenimage" alt="campground image" />
		<!-- page wrapper -->
		<div id="wrapper">
			<!--page header-->
			<div id="header" class="scalefull">
				<!-- logo -->
				<div id="logo">
					<a href="index.php">
					<img width="100%" height="100%" alt="Campgrounds Live logo" src="img/cglogo.png" />
					</a>
				</div> <!--end logo div-->

				<!--social media box div-->
				<div id="socialmediabox">
					<ul style="padding-left: 0px;">
					<li class="facebook">
					<a target="_blank" title="Like Us On Facebook" href="http://www.facebook.com/pages/CampgroundsLive/111241992318629"><img alt="Like Us On Facebook" src="img/facebook-icon.png" width="30px" height="30px" /></a>
					</li>
					<li class="twitter">
					<a target="_blank" title="Follow Us On Twitter" href="http://www.twitter.com/campgroundslive"><img alt="Follow Us On Twitter" src="img/twitter-icon.png" width="30px" height="30px" /></a>
					</li>
					</ul>
				</div><!--end social media box div-->

				<div id="headerright" style="float:right;width: 500px; height: 100px">
					<div id="searchbox">
						<!-- Atomz HTML for Search -->
						<form id="searchform" style="width:203px;height:23px" name="searchform" method="get" action="http://search.atomz.com/search/">
						<input type="hidden" name="sp_a" value="sp100500e5">
						<input id="searchtext" class="search" type="text" maxlength="50" name="sp_q" onfocus="if (this.value == 'Enter Search Term') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Enter Search Term';}">
						<input type="submit" value = "" id="magnifyglass" style="background: url('img/magnifying-glass.png') no-repeat 0 0 transparent;" >
						<input type="hidden" name="sp_p" value="all">
						<input type="hidden" name="sp_f" value="UTF-8">
						</form>
						<!--end search form-->
					</div><!--end searchbox-->
						
					<div id="userinfo">
						<!--mycampgroundslive button-->
						<div id="loginbutton">
								<a href="<?php echo $linkfx?>.php" style="color:white"><?php echo $buttonfx?></a>
						</div>
						<div id="welcometext">Welcome 

						<?php
							echo $username
						?>
						</div><!--end welcometext-->
					</div><!--end userinfo div-->
				</div><!--end headerright div-->
								
				<!--navigation div-->
				<div id="nav">
					<ul>
						<li>
							<a href="index.php">Home</a>
						</li>
						<li>
							<a href="find-campground.php">Find A Campground</a>
								<ul>
									<li>
										<a href="find-campground-by-map.php">By Map</a>
									</li>
									<li>
										<a href="find-campground-by-query.php" style="border-bottom-style:none;">By What's There</a>
									</li>
								</ul>
						</li>
						<li>
							<a href="share-your-visit.php">Share Your Visit</a>
								<ul>
									<li>
										<a href="share-your-comments.php">Share Your Comments</a>
									</li>
									<li>
										<a href="upload-your-photos.php" style="border-bottom-style:none;">Upload Your Photos</a>
									</li>
								</ul>
						</li>
						<li>
							<a href="my-campgrounds-live.php" style="border-right-style:none">My CampgroundsLive!</a>
								<ul>
									<li>
										<a href="my-campground-photos.php">My Photos!</a>
									</li>
									<li>
										<a href="my-favorite-campgrounds.php" style="border-bottom-style:none;">My Favorite CGs!</a>
									</li>
								</ul>
									
						</li>
					</ul>
				</div><!--end nav div-->
			</div><!--end header div-->

			<!-- horizontal advertisement area -->
			<div id="adbanner">
				<?php include ('inc/adbanner.inc.php');?>
			</div><!--end adbanner div-->