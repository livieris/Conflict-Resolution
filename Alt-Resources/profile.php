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

$userName = $_POST["userName"];
$_SESSION['firstName'];
if(!isset($_SESSION['userName'])){
	$_SESSION['userName']=$userName;
}
$password = $_POST["password"];
//encypt password
$password = md5($password);
if(!isset($_SESSION['password'])){
	$_SESSION['password']=$password;
}
echo "'<script>console.log(\"$password\")</script>'";
try{
	//adds first name to session var								
	$query = $db->prepare("SELECT firstName FROM registration_login WHERE userName = ?");
	$query->execute(array($_SESSION['userName']));
	$rows = $query->fetchAll(PDO::FETCH_ASSOC);
	if($rows){
		foreach($rows as $row){
			$_SESSION['firstName']=$row['firstName'];
		}
	}
									
							
	//checks for user name in db
	$query = $db->prepare("SELECT userName FROM registration_login WHERE userName = ?");
	$query->execute(array($_SESSION['userName']));
	$rows = $query->fetchAll(PDO::FETCH_ASSOC);
	$rowCount=$query->rowCount();
	if($rowCount==1 ){
		//check if user name's password is correct
		$query = $db->prepare("SELECT userName FROM registration_login WHERE userName = ? AND password = ?");
		$query->execute(array($_SESSION['userName'], $_SESSION['password']));
		$rows = $query->fetchAll(PDO::FETCH_ASSOC);
		$rowCount=$query->rowCount();
		if($rowCount == 1){	
			//check for client permission
			$query = $db->prepare("SELECT client, staff, company FROM permissions WHERE userName = ?");
			$query->execute(array($_SESSION['userName']));
			$rows = $query->fetchAll(PDO::FETCH_ASSOC);
			$rowCount=$query->rowCount();
			$staff="";
			$company="";
			$client="";
			if($rows){
				foreach($rows as $row){
					$client = $row['client'];
					$staff = $row['staff'];
					$company = $row['company'];
				}
			}
			if($rowCount==1 && $client=="y"){
				$_SESSION['permissions']=2;
	?>
	
				<!doctype html>
				<html>
				
				<head>
					<title>Alternative Resolutions, Inc.</title>
					<meta name="robots" content="noindex, nofollow" />
					<meta http-equiv="content-type" content="text/html; charset=utf-8" />
					<link href="style.css" type="text/css" rel="stylesheet" />
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
									<a class="changePassButton" href="changePassword.php">Change Password</a>				
							</p>
							<div class="floatCenterText">
								<h2>
								<?php
									echo "Welcome ". $_SESSION['firstName'];									
								?>
								</h2>
							</div>
						</div>
						<br />
						<div class="section">
							<h2>Profile:</h2>
							<!-- this is where db print contact information -->
							<div class="contactInfo">
								<p>
								<?php
									$query = $db->prepare("SELECT lastName, firstName, state, city, address, phone, email, company FROM registration_login WHERE userName = ?");
									$query->execute(array($_SESSION['userName']));
									$rows = $query->fetchAll(PDO::FETCH_ASSOC);
									if($rows){
										foreach($rows as $row){
											echo '<label>Last Name: </label> '    . $row['lastName'] . '<br />';
											echo '<label>First Name: </label> '    . $row['firstName'] . '<br />';
											echo '<label>State: </label> '    . $row['state'] . '<br />';
											echo '<label>City: </label> '    . $row['city'] . '<br />';
											echo '<label>Address: </label> '    . $row['address'] . '<br />';
											echo '<label>Phone: </label> '     . $row['phone'] . '<br />';
											echo '<label>Email: </label> '     . $row['email'] . '<br />';
											echo '<label>Company: </label> '    . $row['company'] . '<br />';
										}
									}
								?>
								</p>
									<br />
									<div class="floatRightText">
										<p>
											<a class="button" href="edit_client_contact.php">Edit</a>
										</p>
										<br />
									</div>
							</div>
						</div>
						<br />
						<br />
						<div class="section">
							<h2>Notes By Client:</h2>
							<div class="contactInfo">
								<textarea class="noteBox" name="client_note" readonly>
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
								<br />
								<div class="floatRightText">
									<p>
										<a class="button" href="edit_client_notes.php">Edit</a>
									</p>
									<br />
								</div>
							</div>
						</div>
						<br />
						<br />
						<div class="section">
							<h2>Notes By Staff:</h2>
							<p class="contactInfo">
								<textarea class="noteBox" name="staff_note" readonly>
								<?php 
								$query = $db->prepare("SELECT staffNote FROM notes WHERE userName = ?");
								$query->execute(array($_SESSION['userName']));
								$rows = $query->fetchAll(PDO::FETCH_ASSOC);
								if($rows){
									foreach($rows as $row){
										echo $row['staffNote'];
									}
								}
								?>
								</textarea>
								<br />
				
							</p>
						</div>
						<br />
						<br />
						<div class="section">
							<h2>Schedule:</h2>
							<div class="contactInfo">
				
								<h3>Upcoming sessions:</h3>
								<form action="profile.php" method="post">
									<select name = "types">
										<option>All</option>
										<option>Training</option>
										<option>Mediation</option>
										<option>Facilitation</option>
										<option>Coaching</option>
										<option>Consultation</option>
									</select>
									<input type="submit" class="button" value="Go" name="Go"/><br/>
								</form>
								<?php 
								if (isset($_POST['Go'])) {
									$type = $_POST['types'];
									if ($type == "All"){
										$query = $db->prepare("SELECT date, serviceType FROM services WHERE userName = ? ORDER BY date");
										$query->execute(array($_SESSION['userName']));
										$rows = $query->fetchAll(PDO::FETCH_ASSOC);
										if($rows){
											foreach($rows as $row){
												echo "<p>" . $row['date'] . ": " . $row['serviceType'] . "</p>";
											}
										}
										else
											echo("No Results Found");
									}
									else{
										$query = $db->prepare("SELECT date, serviceType FROM services WHERE userName = ? AND serviceType = ? ORDER BY date");
										$query->execute(array($_SESSION['userName'],$type));
										$rows = $query->fetchAll(PDO::FETCH_ASSOC);
										if($rows){
											foreach($rows as $row){
												echo "<p>" . $row['date'] . ": " . $row['serviceType'] . "</p>";
											}
										}
										else
											echo("No Results Found");
									}
								}
								else{
									$query = $db->prepare("SELECT date, serviceType FROM services WHERE userName = ? ORDER BY date");
									$query->execute(array($_SESSION['userName']));
									$rows = $query->fetchAll(PDO::FETCH_ASSOC);
									if($rows){
										foreach($rows as $row){
											echo "<p>" . $row['date'] . ": " . $row['serviceType'] . "</p>";
										}
									}
									else
											echo("No Results Found");
								}
								?>
								<br />
				
							</div>
						</div>
						<br />
						<br />
						<div class="section">
							<h2>Request of Service:</h2>
							<p class="contactInfo">
								<a class="button" href="service_request.php"> Click Here To Request Services! </a>
								<br />
				
							</p>
						</div>
					</div>
					<br/>
					<div id="footer">
						<p>Disclaimer: This site is under development by UW Oshkosh students as a prototype for the organization of Alternative Resolutions.
							Nothing on the site should be construed in any way as being officially connected with or representative of Alternative
							Resolutions.
						</p>
						<p>
							<a href="http://validator.w3.org/check/referer">
								<img src="http://www.w3.org/html/logo/badge/html5-badge-h-css3-semantics.png" width="88" height="64" alt="HTML5 Powered with CSS3 / Styling, and Semantics"
								title="HTML5 Powered with CSS3 / Styling, and Semantics">
							</a>
							<a href="http://jigsaw.w3.org/css-validator/check/referer">
								<img style="border:0;width:88px;height:31px" src="http://jigsaw.w3.org/css-validator/images/vcss" alt="Valid CSS!" />
							</a>
						</p>
					</div>
				</body>
		<?php
			//permission for staff else
			}else if($rowCount==1 && $staff=='y'){
				$_SESSION['permissions']=0;
				header("location: staffProfile.php");
			//permission for company
			}else{
				$query = $db->prepare("SELECT company FROM registration_login WHERE userName = ?");
				$query->execute(array($_SESSION['userName']));
				$rows = $query->fetchAll(PDO::FETCH_ASSOC);
				$company;
				if($rows){
					foreach($rows as $row){
						$company = $row['company'];
					}
				}
				$_SESSION['company']=$company;
				$_SESSION['permissions']=1;
				header("location: companyProfile.php");
			}
		}else{
			unset($_SESSION['userName']);
			unset($_SESSION['password']);
			setcookie("PHPSESSID", "", time() - 3600);
			$failedMessage = urlencode("Incorrect password! Try again!");
			header("location: portal.php?failedMessage=".$failedMessage);
		}
	}else{
		unset($_SESSION['userName']);
		unset($_SESSION['password']);
		setcookie("PHPSESSID", "", time() - 3600);
		$failedMessage = urlencode("User Name doesn't exist or is wrong! Please re-try!");
		header("location: portal.php?failedMessage=".$failedMessage);
	}
	}catch(PDOException $ex) {
		echo "An Error occured!"; 
		echo $ex->getMessage();
	}
	?>
</html>