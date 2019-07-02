<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="styles.css">
<script type="text/javascript">
	function goBack() {
		window.history.back();
	}
	function time(str) {
		var index = 0;
		for (var i = 0; i < str.length; i++) {
			if (str.atChar(i) == 'h') {
				index = i;
			}
		}
		return parseint(str.substr(0,index))*60 + parseint(str.substr(index+1,str.length)); 
	}
</script>
</head>
<body>
<?php 
try {
	$dbh = new PDO('mysql:host=35.197.98.39;dbname=recipes','root','root');
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
	$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

if (isset($_GET["recipe_info"])) {
	$row = $dbh->query("SELECT * FROM trecipes WHERE recipeID = '".$_GET["id"]."'");
	$result = $row->fetch(PDO::FETCH_ASSOC);
	echo "<div class=\"smallheader\"><h1>Recipe: ".$_GET["recipe_info"]."</h1><p>By ".$result["author"]."</p></div><div class=\"main\">";
	$data = preg_split("/[,]+/", $result["ingredients"], -1, PREG_SPLIT_NO_EMPTY);
	echo "<image src=\"".$result["recipe_photo"]."\" alt=\"*Recipe Photo*\"><h4>Ingredients</h4><ul>";
	foreach ($data as $ingredient) {
		echo "<li>".$ingredient."</li>";
	}
	echo "</ul><hr><p><b>Prep Time: </b>".$result["prepare_time"]."</p>";
	echo "<p><b>Cook Time: </b>".$result["cook_time"]."</p><hr>";
	echo "<p><b>Total Time: </b>".$result["total_time"]."</p><hr>";
	echo "<h4>Directions</h4><p>".$result["directions"]."</p>";
	echo "<button class=\"button\" style=\"width:auto\" onclick=\"goBack()\">Back</button><a href=\"index.php\" style=\"width:auto\" class=\"button\">Home</a></div>";
	$_GET = array();
}
if (isset($_GET["submit_search"])) {
	echo "<div class=\"smallheader\"><h1>Search results</h1><p style=\"float:left\">&#9889;: quick; &#10004;: highly-reviewed</p><form class=\"f\" style=\"float:right\" action=\"action.php\" method=\"get\" autocomplete=\"off\">
	<input type=\"textarea\" name=\"ingredients\" placeholder=\"ex. apple,milk\" required>
	<input type=\"submit\" name=\"submit_search\">
</form><br><br><br></div>";
	$data = preg_split("/[,]+/", $_GET["ingredients"], -1, PREG_SPLIT_NO_EMPTY);
	$sql = "SELECT * FROM trecipes WHERE ingredients LIKE";
	$entries = $number = sizeof($data);
	foreach($data as $ingredient) {
		$sql = $sql." '%".$ingredient."%'";
		$entries--;
		if ($entries > 0) {
			$sql = $sql." AND ingredients LIKE";
		}
	}
	$sql = $sql." ORDER BY LENGTH(ingredients) ASC";
	echo "\n<table style=\"width:100%;overflow-x:auto\"><tr>";
	echo "<th>Recipe Name</th><th>Required Ingredients</th>"."<th>Match %</th>"."<th># of Reviews</th>".
		"</tr>";
	foreach($dbh->query($sql) as $row) {
		$total = sizeof(preg_split("/[,]+/", $row["ingredients"], -1, PREG_SPLIT_NO_EMPTY));
		$percentage = round(($number/$total)*100, 2);
		$name = ltrim($row['recipe_name'], "'");
		$name = rtrim($name, "'");
		$name2 = (time($row["total_time"]) <= 30)?$name2." &#9889;":$name2;
		$name2 = ((int)$row["review_count"] > 100)?$name2." &#10004;":$name2;
		echo "<tr><td><form action='action.php' method='get'><input type='hidden' name='id' value='".$row["recipeID"]."'><input type='submit' class='button1' name='recipe_info' value='".$name."'></form></td><td>".$row['ingredients'].$name2."</td>";
		echo "<td>".$percentage."%</td><td>".$row['review_count']."</td></tr>";
		$name2 = "";
	}
	echo "</table>\n";
	$_GET = array();
}

} catch (PDOException $e) {
	print "Error!: ".$e->getMessage()."<br/>";
	die();
}
?>
</body>
</html>

