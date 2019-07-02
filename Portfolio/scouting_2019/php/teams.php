<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="style.css">
<script src="script.js"></script>
</head>
<body>
	
<div class="smallheader">
<h1>Team Info</h1>
</div>
<div id="myNav" class="navbar">
	<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
	<a href="/index.php">Home</a>
	<a href="#" class="active">Teams</a>
	<a href="/scouting_form.php">Form</a>
</div>
<button class="openbtn" onclick="openNav()">&#9776;</button>
<div class="main">
<h2>Search Teams: </h2>
<form class="searchbar" action="action.php" method="get">
	<input type="hidden" name="submit_Search">
	<h4>Search by Team Info</h4><p>Competitions:</p>
	<label class="container"> Yakima
		<input type="checkbox" name="competition1" value="Yakima">
		<span class="checkmark"></span>
	</label>
	<label class="container"> West Valley Spokane
		<input type="checkbox" name="competition2" value="WV">
		<span class="checkmark"></span>
	</label>
	<p>Keywords/Id:</p>
	<input type="text" placeholder="Search by id, name, city, or state" name="search_Text">
	<button type="submit">Go</button>
</form>
<form class="searchbar" action="action.php" method="get">
	<input type="hidden" name="submit_Search2">
	<h4>Search by Stats</h4><p>Average Points Per Game:</p>
	<input type="number" placeholder="Search by average points scored" min="0" name="search_Average">
	<button type="submit">Go</button>
</form>
<br><hr>
<h2>Enter Team:</h2>
<?php
include 'functions.php';
//echo phpinfo();
$user = $pass = 'sciborg4061';
$idErr=$nameErr=$cityErr=$stateErr="";
$id=NULL; $name=$city=$state="";

if (isset($_POST['submit'])) {
	if ($_POST['id'] == NULL) {
	   $idErr = "Required field";
	}
	if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
		$nameErr = "Only letters and white space allowed";
	}
	if (!preg_match("/^[a-zA-Z ]*$/",$city)) {
		$cityErr = "Only letters and white space allowed";
	}
	if (!preg_match("/^[a-zA-Z ]*$/",$state)) {
		$stateErr = "Only letters and white space allowed";
	}
if ($idErr == "" && $nameErr == "" && $cityErr == "" && $stateErr == ""){
	try {
	$dbh = new PDO('mysql:host=localhost;dbname=sciborg4061',$user,$pass);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	execDDL($user, $pass, $dbh, ("INSERT INTO Teams VALUES ('".$_POST['id']."', '".$_POST['name']."', '".$_POST['city']."', '".$_POST['state']."')"));
	}
	catch (\Exception $e) {
	echo "<p>Error: ".$e->getMessage()."</p>";
	}
}
	$_POST = array();
}
?>
<form class="f" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<span class="error">* <?php echo $idErr;?></span>
	Team id:<br><input type="number" name="id" min="0" placeholder="ex. 4061" value="<?php echo $id ?>"><br>
	<span class="error">* <?php echo $nameErr;?></span>
	Team name:<br><input type="text" name="name" placeholder="ex. SciBorgs" value="<?php echo $name ?>"><br>
	<span class="error">* <?php echo $cityErr;?></span>
	City:<br><input type="text" name="city" placeholder="ex. Pullman" value="<?php echo $city ?>"><br>
	<span class="error">* <?php echo $stateErr;?></span>
	State:<br><input type="text" name="state" maxlength="2" placeholder="ex. WA" value="<?php echo $state ?>"><br>
	<br><input type="submit" class="button" name="submit" value="Submit">
</form>
<hr>
<h2>All Teams: </h2>
<?php 
	try { $dbh = new PDO('mysql:host=localhost;dbname=sciborg4061',$user,$pass);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	teamsTable($user, $pass, $dbh, 'SELECT * FROM Teams ORDER BY id'); 
	}
	catch (\Exception $e) {
	echo "<p>Error: ".$e->getMessage()."</p>";
	}
?>
</div>
</body>
</html>
