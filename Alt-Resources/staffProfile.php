<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$startRegister = false;
$db_hostname = 'localhost';
$db_database = 'livies11';
$db_username = 'root';
$db_password = 'Buster88';
$db = new PDO("mysql:dbname=" . $db_database . ";host=localhost",$db_username, $db_password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


	session_start();
	if(isset($_SESSION['searchUserName'])){
		unset($_SESSION['searchUserName']);
	}

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
		<div id="loginDiv">
			<br/>
				<a class="button" href="logOut.php">Log Out</a>
				<a class="changePassButton" href="adminChangePassword.php">Change Password</a>
				<div class="floatCenterText">
					<h2>
						<?php
							echo "Welcome " . $_SESSION['firstName'];
						?>
					</h2>
				</div>
		</div>
		<br/>
		<div id="searchBy">
			<h2>Search For Client:</h2>
			<form action="staffProfile.php" method="post">
				<br/>
				<p>
				<label>First Name:</label> <input type="text" name="firstName"  id="firstName"/><br/>
				<label>Last Name:</label> <input type="text" name="lastName"  id="lastName"/><br/>
				</p>
				<?php
				if($_SESSION['permissions']==0){
				?>
				<p>
				<label>Company Name:</label> 
				<select name="company">
						 	<option>All</option>
							 <?php
								$query = $db->prepare("SELECT distinct company FROM registration_login");
								$query->execute();
								$rows = $query->fetchAll(PDO::FETCH_ASSOC);
								if($rows){
									foreach($rows as $row){
								?>
										<option><?php echo $row['company'] ?></option>
								<?php
									}
								}
							?>
			     
				</select></p><br/><br />
				<?php
				}
				?>
				<input type="submit" class="button" name="searchButton" value="Search"/><br/>
			</form>
		</div>
		<br />
		<div id="searchResults">
			<h2>Search Results:</h2>
			<div class = "infoIndent">
			<?php 
			
			if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['searchButton'])){
				//staff search results
				if($_SESSION['permissions']==0) {
					$firstName = $_POST["firstName"];
					$lastName = $_POST["lastName"];
					$companyName = $_POST['company'];
					//no search parameters, return everything
					if($firstName=="" && $lastName =="" && $companyName =="All"){
						$query = $db->prepare("SELECT permissions.userName, firstName, lastName FROM registration_login, permissions
						WHERE (permissions.client =  'y' OR permissions.company = 'y') AND registration_login.userName = permissions.userName");	
						$query->execute();
						$rows = $query->fetchAll(PDO::FETCH_ASSOC);
						if($rows){
							foreach($rows as $row){
								//echo "<p>User Name: <a href='searchResultProfile.php?userName=" . $row['userName'] . "'>" . $row['userName'] . "</a>       Name: " . $row['firstName'] . " " . $row['lastName'] . "</p>";
								echo "<p>User Name: " . $row['userName'] . " | Name: " . $row['firstName'] . " " . $row['lastName'] . " <a href='searchResultProfile.php?userName=" . $row['userName'] . "'>See Profile</a></p>";
							}
						}
					//if only company, return everyone from that company
					}else if($companyName != "All" && $firstName =="" && $lastName ==""){
						$query = $db->prepare("SELECT userName, firstName, lastName FROM registration_login WHERE company = ?;");	
						$query->execute(array($companyName));
						$rows = $query->fetchAll(PDO::FETCH_ASSOC);
						if($rows){
							foreach($rows as $row){
								//echo "<p>User Name: <a href='searchResultProfile.php?userName=" . $row['userName'] . "'>" . $row['userName'] . "</a>       Name: " . $row['firstName'] . " " . $row['lastName'] . "</p>";
								echo "<p>User Name: " . $row['userName'] . " | Name: " . $row['firstName'] . " " . $row['lastName'] . " <a href='searchResultProfile.php?userName=" . $row['userName'] . "'>See Profile</a></p>";
							}
						}
						else{
							echo("<p>No results found.</p>");
						}
					//if company and a name	
					}else if($companyName != "All" && ($firstName =="" || $lastName =="")){
						$query = $db->prepare("SELECT userName, firstName, lastName FROM registration_login WHERE (firstName = ? OR lastName = ?) AND company = ?;");	
						$query->execute(array($firstName, $lastName, $companyName));
						$rows = $query->fetchAll(PDO::FETCH_ASSOC);
						if($rows){
							foreach($rows as $row){
								//echo "<p>User Name: <a href='searchResultProfile.php?userName=" . $row['userName'] . "'>" . $row['userName'] . "</a>       Name: " . $row['firstName'] . " " . $row['lastName'] . "</p>";
								echo "<p>User Name: " . $row['userName'] . " | Name: " . $row['firstName'] . " " . $row['lastName'] . " <a href='searchResultProfile.php?userName=" . $row['userName'] . "'>See Profile</a></p>";
							}
						}
						else{
							echo("<p>No results found.</p>");
						}
					//search both first and last name without any company parameter
					}else if($firstName !="" && $lastName != "" && $companyName == "All"){
						$query = $db->prepare("SELECT userName, firstName, lastName FROM registration_login WHERE (firstName = ? AND lastName = ?);");	
						$query->execute(array($firstName, $lastName));
						$rows = $query->fetchAll(PDO::FETCH_ASSOC);
						if($rows){
							foreach($rows as $row){
								//echo "<p>User Name: <a href='searchResultProfile.php?userName=" . $row['userName'] . "'>" . $row['userName'] . "</a>       Name: " . $row['firstName'] . " " . $row['lastName'] . "</p>";
								echo "<p>User Name: " . $row['userName'] . " | Name: " . $row['firstName'] . " " . $row['lastName'] . " <a href='searchResultProfile.php?userName=" . $row['userName'] . "'>See Profile</a></p>";
							}
						}
						else{
							echo("<p>No results found.</p>");
						}
					//searching all parameters
					}else if($firstName !="" && $lastName != "" && $companyName != "All"){
						$query = $db->prepare("SELECT userName, firstName, lastName FROM registration_login WHERE firstName = ? AND lastName = ? AND company = ?;");	
						$query->execute(array($firstName, $lastName, $companyName));
						$rows = $query->fetchAll(PDO::FETCH_ASSOC);
						if($rows){
							foreach($rows as $row){
								//echo "<p>User Name: <a href='searchResultProfile.php?userName=" . $row['userName'] . "'>" . $row['userName'] . "</a>       Name: " . $row['firstName'] . " " . $row['lastName'] . "</p>";
								echo "<p>User Name: " . $row['userName'] . " | Name: " . $row['firstName'] . " " . $row['lastName'] . " <a href='searchResultProfile.php?userName=" . $row['userName'] . "'>See Profile</a></p>";
							}
						}
						else{
							echo("<p>No results found.</p>");
						}	
					}else{
						$query = $db->prepare("SELECT userName, firstName, lastName FROM registration_login WHERE firstName = ? OR lastName = ?;");	
						$query->execute(array($firstName, $lastName));
						$rows = $query->fetchAll(PDO::FETCH_ASSOC);
						if($rows){
							foreach($rows as $row){
								//echo "<p>User Name: <a href='searchResultProfile.php?userName=" . $row['userName'] . "'>" . $row['userName'] . "</a>       Name: " . $row['firstName'] . " " . $row['lastName'] . "</p>";
								echo "<p>User Name: " . $row['userName'] . " | Name: " . $row['firstName'] . " " . $row['lastName'] . " <a href='searchResultProfile.php?userName=" . $row['userName'] . "'>See Profile</a></p>";
							}
						}
						else{
							echo("<p>No results found.</p>");
						}	
					}
					//company
				}else{
					$firstName = $_POST["firstName"];
					$lastName = $_POST["lastName"];
					if($firstName=="" && $lastName ==""){
						$query = $db->prepare("SELECT permissions.userName, firstName, lastName FROM registration_login, permissions
						WHERE permissions.client =  'y' AND registration_login.userName = permissions.userName AND registration_login.company = ?");	
						$query->execute(array($_SESSION['company']));
						$rows = $query->fetchAll(PDO::FETCH_ASSOC);
						if($rows){
							foreach($rows as $row){
								//echo "<p>User Name: <a href='searchResultProfile.php?userName=" . $row['userName'] . "'>" . $row['userName'] . "</a>       Name: " . $row['firstName'] . " " . $row['lastName'] . "</p>";
								echo "<p>User Name: " . $row['userName'] . " | Name: " . $row['firstName'] . " " . $row['lastName'] . " <a href='searchResultProfile.php?userName=" . $row['userName'] . "'>See Profile</a></p>";
							}
						}	
					}else{
						$query = $db->prepare("SELECT userName, firstName, lastName FROM registration_login WHERE (firstName = ? OR lastName = ?) AND company = ?;");	
						$query->execute(array($firstName, $lastName, $_SESSION['company']));
						$rows = $query->fetchAll(PDO::FETCH_ASSOC);
						if($rows){
							foreach($rows as $row){
								//echo "<p>User Name: <a href='searchResultProfile.php?userName=" . $row['userName'] . "'>" . $row['userName'] . "</a>       Name: " . $row['firstName'] . " " . $row['lastName'] . "</p>";
								echo "<p>User Name: " . $row['userName'] . " | Name: " . $row['firstName'] . " " . $row['lastName'] . " <a href='searchResultProfile.php?userName=" . $row['userName'] . "'>See Profile</a></p>";
							}
						}
						else{
							echo("<p>No results found.</p>");
						}
					}	
				}
			}
			?>
			</div>
		</div>
		<br />
		<div class = "section">
			<?php
			//if for permissions for add button***staff permission
			if($_SESSION['permissions']==0){
			?>
				<h2>Service Requests:</h2>
				<div class = "infoIndent">
				<?php
				$query = $db->prepare("SELECT firstName, lastName, type , dateFrom, dateTo, location, service_request.userName FROM registration_login, service_request WHERE registration_login.userName = service_request.userName;");	
				$query->execute();
				$rows = $query->fetchAll(PDO::FETCH_ASSOC);
				if($rows){
					foreach($rows as $row){
						$firstName = $row['firstName'];
						$lastName = $row['lastName'];
						$type = $row['type'];
						$location = $row['location'];
						$dateFrom = $row['dateFrom'];
						$dateTo = $row['dateTo'];
						$userName = $row['userName'];
						$queryLocation = str_replace(" ", "%20", $location);
						
						echo "<p>" . $firstName . "  " . $lastName . ":  " . $type . "  (" . $dateFrom . " - " 
						. $dateTo . ")  Location: " . $location . "   " . "<a class='button' href='adminAddService.php?userName=" . $userName . "&amp;type=" . $type 
						."&amp;dateFrom=" . $dateFrom . "&amp;dateTo=" . $dateTo ."&amp;location=" . $queryLocation ."'>Add</a> </p>";
					}
				}
				?>
				</div>
				<?php
			}else{
			?>
				<h2>Service Requests:</h2>
				<div class = "infoIndent">
				<?php
					$query = $db->prepare("SELECT firstName, lastName, type , dateFrom, dateTo, location, service_request.userName FROM registration_login, service_request WHERE registration_login.userName = service_request.userName;");	
					$query->execute();
					$rows = $query->fetchAll(PDO::FETCH_ASSOC);
					if($rows){
						foreach($rows as $row){
							$firstName = $row['firstName'];
							$lastName = $row['lastName'];
							$type = $row['type'];
							$location = $row['location'];
							$dateFrom = $row['dateFrom'];
							$dateTo = $row['dateTo'];
							$userName = $row['userName'];
							echo "<p>" . $firstName . "  " . $lastName . ":  " . $type . "  (" . $dateFrom . " - " 
							. $dateTo . ")  Location: " . $location . "   " . " </p>";
						}
					}
			?>
				</div>
			<?php	
			}
			?>
		</div>
		<br />
		<div class = "section">
			<h2> Search Schedules: </h2>
			<div class = "infoIndent">
				<?php
				
				
				if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['scheduleSearchButton'])){
					$serviceType = $_POST['typeSearch'];
					?>
					<form action="staffProfile.php" method="post">
					<br/>
					<p>
					<label>Filter By Service Type:</label><br /> 
					<select name="typeSearch">
						<option>All</option>
						<option>Training</option>
						<option>Mediation</option>
						<option>Facilitation</option>
						<option>Coaching</option>
						<option>Consultation</option>
					</select>
					<br /><br />
					<input type="submit" id="button" name="scheduleSearchButton" value="Search"/><br/>
					</form>
					<?php
					if($serviceType != "All"){
						$query = $db->prepare("SELECT firstName, lastName, serviceType, date, fee, location FROM services, registration_login WHERE services.userName = registration_login.userName AND services.serviceType = ? ORDER BY date ASC;");	
						$query->execute(array($serviceType));
						$rows = $query->fetchAll(PDO::FETCH_ASSOC);
						if($rows){
							foreach($rows as $row){
								$firstName = $row['firstName'];
								$lastName = $row['lastName'];
								$type = $row['serviceType'];
								$location = $row['location'];
								$date = $row['date'];
								echo "<p> <strong>" . $firstName . "  " . $lastName . ":</strong>  " . $type . "  (" . $date . ")  Location: " . $location . "   " . " </p>";
							}
						}
					}else{
						$query = $db->prepare("SELECT firstName, lastName, serviceType, date, fee, location FROM services, registration_login WHERE services.userName = registration_login.userName ORDER BY date ASC;");	
						$query->execute();
						$rows = $query->fetchAll(PDO::FETCH_ASSOC);
						if($rows){
							foreach($rows as $row){
								$firstName = $row['firstName'];
								$lastName = $row['lastName'];
								$type = $row['serviceType'];
								$location = $row['location'];
								$date = $row['date'];
								echo "<p> <strong>" . $firstName . "  " . $lastName . ":</strong>  " . $type . "  (" . $date . ")  Location: " . $location . "   " . " </p>";
							}
						}	
					}
				}else{
					?>
					
					<form action="staffProfile.php" method="post">
					<p>
					<label>Filter By Service Type:</label>
					<br /> 
					<select name="typeSearch">
						<option>None</option>
						<option>Training</option>
						<option>Mediation</option>
						<option>Facilitation</option>
						<option>Coaching</option>
						<option>Consultation</option>
					</select>
					<br /><br />
					<input type="submit" class="button" name="scheduleSearchButton" value="Search"/><br/>
				</form>
					<?php
					$query = $db->prepare("SELECT firstName, lastName, serviceType, date, fee, location FROM services, registration_login WHERE services.userName = registration_login.userName ORDER BY date ASC;");	
					$query->execute();
					$rows = $query->fetchAll(PDO::FETCH_ASSOC);
					if($rows){
						foreach($rows as $row){
							$firstName = $row['firstName'];
							$lastName = $row['lastName'];
							$type = $row['serviceType'];
							$location = $row['location'];
							$date = $row['date'];
							echo "<p> <label>" . $firstName . "  " . $lastName . ":</label>  " . $type . "  (" . $date . ")  Location: " . $location . "   " . " </p>";
						}
					}
				}
				?>
			</div>
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

</html>