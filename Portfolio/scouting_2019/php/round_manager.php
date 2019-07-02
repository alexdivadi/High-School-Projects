<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="/style.css">
</head>
<body>
<div class="smallheader">
<h1>Round Manager</h1>
</div>	
	
<div class="navbar">
	<a href="/index.php">Home</a>
	<a href="/teams.php">Teams</a>
	<div class="dropdown">
		<button class="dropbtn">Scouting Info
			<i class="fa fa-caret-down"></i>
		</button>
		<div class="dropdown-content">
			<a href="/scouting_form.php">Form</a>
			<a href="#">Manager</a>
			<a href="#">Link 3</a>
		</div>
	</div>
</div>

<div class="main">
	<h1>Teams Currently Scouted:</h1>
	<p>Scouting in progress! The following teams have completed scouting:</p>
	<?php
		try {
	$dbh = new PDO('mysql:host=localhost;dbname=sciborg4061','sciborg4061','sciborg4061');
	echo "<p>";
	foreach($dbh->query('SELECT * FROM Round') as $row) {

		echo $row['id'];
	}
	echo "</p>";
	} catch (PDOException $e) {
	print "Error!: ".$e->getMessage()."<br/>";
	die();
	}
	?>
	<button class="button">Submit</button><button class="button">Scrap</button>
</div>

</body>
</html>
