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
		<div class="section">
			<div class = "contactInfo">
				<?php
				if(isset($_GET['failMessage'])){
					echo($_GET['failMessage']);
					unset($_GET['failMessage']);
				}
				?>
				<h2>Notes by client: </h2><br/>
				<textarea class="noteBox" form ="cReg" name = "cNotes"></textarea><br/>
			</div><br/><br/>
		</div>
		<br /><br />
		<div class="section">
				<div class = "contactInfo">
				<br/>
				
				<form id ="cReg" action="registerComplete.php" method="post">
					<p>
    				<label>Username:</label> <input type="text" name="userName" placeholder = "Please enter in a user name"/><br/>
					<label>Last Name:</label> <input type="text" name="lastName" placeholder = "Last Name"/><br/>
					<label>First Name:</label> <input type="text" name="firstName" placeholder = "First Name"/><br/>
					<label>Password:</label> <input type="password" name="password" placeholder = "Password"/><br/>
					<label>Verify Password:</label> <input type="password" name="passwordConfirm" placeholder = "Re-type Password"/><br/>
					
				
				    <label>State:</label>
				 	<select name = "state">
						<option value="AL">Alabama</option>
						<option value="AK">Alaska</option>
						<option value="AZ">Arizona</option>
						<option value="AR">Arkansas</option>
						<option value="CA">California</option>
						<option value="CO">Colorado</option>
						<option value="CT">Connecticut</option>
						<option value="DE">Delaware</option>
						<option value="DC">District Of Columbia</option>
						<option value="FL">Florida</option>
						<option value="GA">Georgia</option>
						<option value="HI">Hawaii</option>
						<option value="ID">Idaho</option>
						<option value="IL">Illinois</option>
						<option value="IN">Indiana</option>
						<option value="IA">Iowa</option>
						<option value="KS">Kansas</option>
						<option value="KY">Kentucky</option>
						<option value="LA">Louisiana</option>
						<option value="ME">Maine</option>
						<option value="MD">Maryland</option>
						<option value="MA">Massachusetts</option>
						<option value="MI">Michigan</option>
						<option value="MN">Minnesota</option>
						<option value="MS">Mississippi</option>
						<option value="MO">Missouri</option>
						<option value="MT">Montana</option>
						<option value="NE">Nebraska</option>
						<option value="NV">Nevada</option>
						<option value="NH">New Hampshire</option>
						<option value="NJ">New Jersey</option>
						<option value="NM">New Mexico</option>
						<option value="NY">New York</option>
						<option value="NC">North Carolina</option>
						<option value="ND">North Dakota</option>
						<option value="OH">Ohio</option>
						<option value="OK">Oklahoma</option>
						<option value="OR">Oregon</option>
						<option value="PA">Pennsylvania</option>
						<option value="RI">Rhode Island</option>
						<option value="SC">South Carolina</option>
						<option value="SD">South Dakota</option>
						<option value="TN">Tennessee</option>
						<option value="TX">Texas</option>
						<option value="UT">Utah</option>
						<option value="VT">Vermont</option>
						<option value="VA">Virginia</option>
						<option value="WA">Washington</option>
						<option value="WV">West Virginia</option>
						<option value="WI">Wisconsin</option>
						<option value="WY">Wyoming</option>
					</select><br />
					
					<label>City:</label> <input type="text" name="city" placeholder="city"/><br/>
					<label>Address:</label> <input type="text" name="address" placeholder = "Address"/><br/>
					<label>Phone:</label> <input type="text" name="phone" placeholder = "Phone"/><br/>
					<label>Email:</label> <input type="text" name="email" placeholder = "Email"/><br/>
					<label>Verify Email:</label> <input type="text" name="emailConfirm" placeholder = "Re-Type Email"/><br/>
					<label>Company Name:</label> 
					<select name="company">
						 	<option>None</option>
							 <?php
								$query = $db->prepare("SELECT distinct company FROM registration_login WHERE company != ?");
								$query->execute(array("None"));
								$rows = $query->fetchAll(PDO::FETCH_ASSOC);
								if($rows){
									foreach($rows as $row){
								?>
										<option><?php echo $row['company'] ?></option>
								<?php
									}
								}
							?>
						</select><br/><br />
					</p>
						<input type="Submit" class="button" value="Register" name = "submit"/>
					<div class="floatRightText">
						<a class="button" href="portal.php">Back</a><br/><br/>
					</div>
				</form>
		</div>
			</div><br/><br/>
				<br />
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