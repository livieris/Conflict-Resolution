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
	

	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$date = $_POST['date'];
		$fee = $_POST['fee'];
		
		//make sure correct format
		if (($date == "yyyy-mm-dd" && $fee = "") || ($date=="yyyy-mm-dd" && $fee !="") || ($date!="yyyy-mm-dd" && $fee =="")){
			$failedMessage = urlencode("ALL FIELDS REQUIRED!");
			header("location: adminAddService.php?failedMessage=".$failedMessage);
		}
		else{
			$year = substr($date, 0, 4);
			$dash1 = substr($date, 4, 1);
			$month = substr($date, 5, 2);
			$dash2 = substr($date, 7, 1);
			$day = substr($date, 8, 2);
			
			if ($dash1 == "-"  && is_numeric($year) && is_numeric($month) && is_numeric($day) && $day <= 31 && $month <= 12 && $dash2 == "-"){
				try{
					//add to serice table
					$query = $db->prepare("INSERT into services (userName, serviceType, date, location, fee) VALUES (?, ?, ?, ?, ?)");	
					$query->execute(array($_SESSION['serviceRequestUserName'], $_SESSION['type'], $date, $_SESSION['location'], $fee));
					
					//delete from service request table
					$query = $db->prepare("DELETE from service_request where userName = ? AND type = ? AND location = ? AND dateFrom = ? AND dateTo = ?");	
					$query->execute(array($_SESSION['serviceRequestUserName'], $_SESSION['type'], $_SESSION['location'], $_SESSION['dateFrom'], $_SESSION['dateTo']));
					header("location: staffProfile.php");
				}catch(PDOException $ex) {
					echo "An Error occured!"; 
					echo $ex->getMessage();
				}
			}
			else{
				?>
				<!doctype html>
				<html>
					<head>
						<title>Alertnative Resolutions, Inc.</title>
						<meta name="robots" content="noindex, nofollow" />
						<meta http-equiv="content-type" content="text/html; charset=utf-8" />
						<link href ="style.css" type="text/css" rel="stylesheet" />
					</head>
					<body>
						<div id="header">
							<!--<img id="logo" src="images/logoTransparent.png" alt="logo" onclick="http://webdev.cs.uwosh.edu/students/hammod27/individual-phase/index.html">-->
							<h1>Alertnative Resolutions, Inc.</h1>
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
								<div class = "floatCenterText">
									<div id = 'error'> ERROR, INVALID DATE FORMAT! </div>
								</div>
								<h2>Schedule A Date:
								</h2>
								<div class = "infoIndent">
									<?php
									//get first and last name
									$query = $db->prepare("SELECT firstName, lastName from registration_login WHERE userName = ?");	
									$query->execute(array($_SESSION['serviceRequestUserName']));
									$rows = $query->fetchAll(PDO::FETCH_ASSOC);
									$firstName;
									$lastName;
									if($rows){
										foreach($rows as $row){
											$firstName = $row['firstName'];
											$lastName = $row['lastName'];
										}
									}
									//print out information for user service being requested
									echo "<p><strong>For: </strong> " . $firstName . " " . $lastName . "</p>";
									echo "<p><strong>Between: </strong> " . $_SESSION['dateFrom'] . " - " . $_SESSION['dateTo'] . "</p>";
									echo "<p><strong>At: </strong> " . $_SESSION['location'] . "</p>";
									echo "<p><strong>Service Type: </strong> " . $_SESSION['type'] . "</p>";
									
									?>
									<form action="adminAddService.php" method="post">
										<br/>
										Schedule Date:
										<input type="text" name="date" placeholder = "yyyy-mm-dd"/><br/>
										Fee: 
										<input type="text" name="fee"/><br />
										<input type="Submit" class="button" value="Submit" name="submit"/>
										<a class="button" href="staffProfile.php">Back</a>
									</form>
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
<?php
			}
		}
	}else{
		if(!isset($_SESSION['serviceRequestUserName'])){
			$userName = $_GET['userName'];
			$_SESSION['serviceRequestUserName']=$userName;
			$type = $_GET['type'];
			$_SESSION['type'] = $type;
			$dateFrom = $_GET['dateFrom'];
			$_SESSION['dateFrom'] = $dateFrom;
			$dateTo = $_GET['dateTo'];
			$_SESSION['dateTo'] = $dateTo;
			$location = $_GET['location'];
			$_SESSION['location'] = $location;
		}
		
	?>
		<!doctype html>
	<html>
		<head>
			<title>Alertnative Resolutions, Inc.</title>
			<meta name="robots" content="noindex, nofollow" />
			<meta http-equiv="content-type" content="text/html; charset=utf-8" />
			<link href ="style.css" type="text/css" rel="stylesheet" />
		</head>
		<body>
			<div id="header">
				<!--<img id="logo" src="images/logoTransparent.png" alt="logo" onclick="http://webdev.cs.uwosh.edu/students/hammod27/individual-phase/index.html">-->
				<h1>Alertnative Resolutions, Inc.</h1>
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
					<h2>Schedule A Date:
					</h2>
					<div class = "floatCenterText">
					<?php
					if(isset($_GET['failedMessage'])){
    					echo "<div class = error>" . $_GET['failedMessage'] . "</div>";
						unset($_GET['failedMessage']);
					}
					?>
					</div>
					<div class = "infoIndent">
						<?php
						//get first and last name
						$query = $db->prepare("SELECT firstName, lastName from registration_login WHERE userName = ?");	
						$query->execute(array($_SESSION['serviceRequestUserName']));
						$rows = $query->fetchAll(PDO::FETCH_ASSOC);
						$firstName;
						$lastName;
						if($rows){
							foreach($rows as $row){
								$firstName = $row['firstName'];
								$lastName = $row['lastName'];
							}
						}
						//print out information for user service being requested
						echo "<p><strong>For: </strong> " . $firstName . " " . $lastName . "</p>";
						echo "<p><strong>Between: </strong> " . $_SESSION['dateFrom'] . " - " . $_SESSION['dateTo'] . "</p>";
						echo "<p><strong>At: </strong> " . $_SESSION['location'] . "</p>";
						echo "<p><strong>Service Type: </strong> " . $_SESSION['type'] . "</p>";
						
						?>
						<form action="adminAddService.php" method="post">
							<br/>
							Schedule Date:
							<input type="text" name="date" placeholder = "yyyy-mm-dd"/><br/>
							Fee: 
							<input type="text" name="fee"/><br />
							<input type="Submit" class="button" value="Submit" name="submit"/>
							<a class="button" href="staffProfile.php">Back</a>
						</form>
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
<?php
	}
?>