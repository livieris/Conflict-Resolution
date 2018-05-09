<?php
	session_start();
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	
	$startRegister = false;
	$db_hostname = 'localhost';
	$db_database = 'livies11';
	$db_username = 'root';
	$db_password = 'Buster88';
	$db = new PDO("mysql:dbname=" . $db_database . ";host=localhost",$db_username, $db_password);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
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
			<!-- this is where db will print out persons name -->
			<div class="section">
				<p>
					<a class="button" href="logOut.php">Log Out</a>
				</p>
				<div class="floatCenterText">
					<h2>
					<?php
						echo "Welcome ".$_SESSION['firstName']; 
					?>
					</h2>
				</div>
			</div>
			<br />
			<div id="loginDiv">
				<h2>Edit Client Notes:</h2>
					<?php
					if ($_SERVER['REQUEST_METHOD'] == "POST"){
						$note = $_POST['editClientNotes'];
						$query = $db->prepare("UPDATE notes SET clientNote = ? WHERE userName = ?;");	
						$query->execute(array($note, $_SESSION['userName']));
						
						echo("<div class='floatCenterText'><h3>Client note changed</h3></div>");
					}
					?>
				
				<!-- Here will print out from db and then submit changes-->
					<form class ="contactInfo" action="edit_client_notes.php" method="post">
						<textarea class="noteBox" name="editClientNotes">
						<?php
						$query = $db->prepare("SELECT clientNote FROM notes WHERE userName = ?");
						$query->execute(array($_SESSION['userName']));
						$rows = $query->fetchAll(PDO::FETCH_ASSOC);
						if($rows){
							foreach($rows as $row){
								echo $row['clientNote'];
							}
						}
						?>
						</textarea>
						<br /><br />					 
				 		<input type ="submit" value="Submit" class="button">
					</form>
					<div class="floatRightText">
						<p>
							<a id="button" href="profile.php">Back</a>
						</p>
						<br />
					</div>
				
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