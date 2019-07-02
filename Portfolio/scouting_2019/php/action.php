<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="style.css">
<script src="script.js"></script>
</head>
<body>
<?php
include 'functions.php';
$user = $pass = 'sciborg4061';

try {
	$dbh = new PDO('mysql:host=localhost;dbname=sciborg4061',$user,$pass);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
/////////////////////////////////////////////////////////////////////////////////
	
//Search
if (isset($_GET["submit_Search"])) {
	echo "<div class=\"main\"> <h2>Search Results:</h2>";
	$search = $_GET["search_Text"];
	if ($search!="") {
		$condition = (is_numeric($search) ? "id LIKE '".(int)$search."%' AND " 
		: "(name LIKE '".$search."%' OR city LIKE '".$search."%' OR state LIKE '".$search."%') AND ");
	}
	
	if (isset($_GET["competition1"]) AND isset($_GET["competition2"])) {	
			$condition = $condition."Yakima = 1 AND WV = 1";
	}
	else if (isset($_GET["competition1"])) {
			$condition = $condition."Yakima = 1";
	}
	else if (isset($_GET["competition2"])) {
			$condition = $condition."WV = 1";
	}
	else {
			$condition = $condition."1";
	}
	teamsTable($user, $pass, $dbh, ("SELECT * FROM Teams WHERE ".$condition." ORDER BY name ASC"));
	echo "<br><button onclick=\"goBack()\" class=\"button\">Back</button></div>";
}
if (isset($_GET["submit_Search2"])) {
	$search = (int)$_GET["search_Average"];
	$sql = 
	"SELECT t.*, p.`team-id`, p.`points`, p.`games`
	FROM ( 
		SELECT `team-id`, (2*SUM(`m-hatches`)+3*SUM(`m-cargo`)+SUM(`ending-level`)+SUM(`starting-level`)) AS 'points', COUNT(`team-id`) AS `games` 
		FROM `Round` 
		GROUP BY `team-id`) AS p 
	JOIN `Teams` AS t ON p.`team-id` = t.id
	WHERE (p.`points`/p.`games`) >= ".$search;
	echo "<div class=\"main\"> <h2>Search Results - Average Points Per Game > ".$search."</h2>";
	teamsTable($user, $pass, $dbh, $sql);
	echo "<br><button onclick=\"goBack()\" class=\"button\">Back</button></div>";
}
	
//Stats
if (isset($_GET["team_Stats"])) {
	$stmt = $dbh->query('SELECT name FROM Teams WHERE id = '.$_GET["team_Stats"]);
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	$name = $row['name'];
	echo "<div class=\"smallheader\"><h1>".$name."</h1></div>";
	echo "<div id=\"myNav\" class=\"navbar\">
	<a href=\"javascript:void(0)\" class=\"closebtn\" onclick=\"closeNav()\">&times;</a>
	<a href=\"/index.php\">Home</a>
	<a href=\"/teams.php\">Teams</a>
	<a href=\"/scouting_form.php\">Form</a>
	</div><button class=\"openbtn\" onclick=\"openNav()\">&#9776;</button><div class=\"main\">";
	if (countRows($user, $pass, $dbh, ('SELECT COUNT(*) FROM Round WHERE `team-id` = '.$_GET["team_Stats"])) != 0) {
		foreach ($dbh->query('SELECT * FROM Round WHERE `team-id` = '.$_GET["team_Stats"]) as $row) {
			$games += 1;
			$points += (2*$row['m-hatches']+2*$row['s-hatches'] + 3*$row['m-cargo']+3*$row['s-cargo']); 
			$points += $row['ending-level'] + $row['starting-level'];
			if ($row['win']) { $win += 1; }
		}
		$mean = $points/$games;
		$win_percentage = $win/$games*100;
	}
	else {
		$games = $points = $mean = $win = $win_percentage = '?';
	}
	echo "<h2>* TEAM ".$_GET["team_Stats"]." STATS *</h2>
		<p>Games Played: ".$games."</p>
		<p>Total Points Scored: ".$points."</p>
		<p>Average Points Per Game: ".round($mean, 2)."</p>
		<p>Win Percentage: ".round($win_percentage, 2)."%</p>";
		echo "<h4>Comments:</h4>";
		foreach ($dbh->query('SELECT name, notes FROM Round WHERE `team-id` = '.$_GET["team_Stats"]) as $row) {
			echo "<div class=\"form-card\"><p style=\"color:orange\">".$row['name']."</p>".$row['notes']."</div>";
		}
	}
	
//Form Submit
if (isset($_POST["submit_scouting_form"])) {
	$notes = addslashes($_POST['notes']);
	$sql = "INSERT INTO Round (`competition`, `round`, `team-id`, `starting-level`, `preload-bot`, `preload-bay`, `s-hatches`, `s-cargo`, 
	`rocket`, `m-hatches`, `m-cargo`, `ending-level`, `win`,`notes`,`name`) 
	VALUES ('".$_POST['competition']."', '".$_POST['round']."', '".$_POST['id']."', '".$_POST['starting-level']."', '".$_POST['preload-bot']."', '".$_POST['preload-bay']."', '".
	$_POST['s-hatch']."', '".$_POST['s-cargo']."', '".$_POST['rocket']."', '".$_POST['m-hatch']."', '".$_POST['m-cargo']."', '".
	$_POST['ending-level']."', '".$_POST['win']."', '".$notes."', '".$_POST['name']."')";
	
	$count = countRows($user, $pass, $dbh, 'SELECT COUNT(*) FROM Teams WHERE id = '.$_POST['id'].' AND '.$_POST['competition'].' = 1');
	if ($count == 0) {
	   	echo "<h1>Submission Failed!</h1><p>Team not attending this competition!</p>";
		echo "<br><button onclick=\"goBack()\" class=\"button\">Back</button></div>";
	}
	else {
		execDDL($user, $pass, $dbh, $sql);
		echo "<br><a href=\"/index.php\" class=\"link-button\">Home</a></div>";
	}

$_POST = array(); 
$_GET = array();
$dbh = null;
}

/////////////////////////////////////////////////////////////////////////////////
} catch (\Exception $e) {
	echo "<h1>Submission Failed!</h1><p>".$e->getMessage()."</p>";
	echo "<br><button onclick=\"goBack()\" class=\"button\">Back</button></div>";
	//die();
}
?>
</body>
</html>
