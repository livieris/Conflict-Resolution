<?php
	session_start();
?>
<!doctype html>
<html>
	<head>
		<title>Alternative Resolutions, Inc.</title>
		<meta name="robots" content="noindex, nofollow" />
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<link href ="style.css" type="text/css" rel="stylesheet" />
	</head>
	<body>
		<div id="header">
			<!--<img id="logo" src="images/logoTransparent.png" alt="logo" onclick="http://webdev.cs.uwosh.edu/students/hammod27/individual-phase/index.html">-->
			<h1>Alternative Resolutions, Inc.</h1>
			<p id="navbar">
				<a href="index.html">Home</a>   
				<a href="services.html">Our Services</a>   
				<a href="why.html">Why Our Services Matter</a>   
				<a href="staff_expertise.html">Staff Expertise</a>   
				<a href="previous_clients.html">Previous Clients</a>   
				<a href="professional_articles.html">Professional Articles</a>   
				<a href="portal.php">Portal</a>   
				<a href="contact_us.html">Contact Us</a>
			</p>
		</div>
		<br>
		<br>
		<div id="body">
			<div id="loginDiv">
				<h2>Log into Portal:
				</h2>
				<div class = "floatCenterText">
					<?php
						if(isset($_GET['failedMessage'])){
    						echo $_GET['failedMessage'];
							unset($_GET['failedMessage']);
						}
					?>
					</div>
				<form action="profile.php" method="post">
					<br/>
					<p>
					<label>User Name:</label>
					<input type="text" name="userName"/><br/>
					<label>Password:</label>
					<input type="password" name="password"/><br/><br/>
					</p>
					<input type="Submit" class="button" value="Login" name="submit"/>
					<a class="button" href="register.php">Register</a>
				</form>
			</div>
		</div>
		<br/>
		<div id="footer">
			<p>Disclaimer: This site is under development by UW Oshkosh students as a prototype for the organization of Alternative Resolutions.
				Nothing on the site should be construed in any way as being officially connected with or representative of Alternative Resolutions.
			</p>
			<p>
			<a href="http://validator.w3.org/check/referer">
			<img src="http://www.w3.org/html/logo/badge/html5-badge-h-css3-semantics.png"
			width="88" height="64"
			alt="HTML5 Powered with CSS3 / Styling, and Semantics"
			title="HTML5 Powered with CSS3 / Styling, and Semantics">
			</a>
			<a href="http://jigsaw.w3.org/css-validator/check/referer">
			<img style="border:0;width:88px;height:31px"
			src="http://jigsaw.w3.org/css-validator/images/vcss"
			alt="Valid CSS!" />
			</a>
			</p>
		</div>
	</body>
</html>