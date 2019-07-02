<html>
<head>
</head>
<body>
<?php
function teamsTable($user, $pass, $dbh, $sql)
{
	echo "\n<div style=\"overflow-x:auto;\"><table style=\"width:100%\"><tr>";
	echo "<th>Id</th><th>Name</th>".
		"<th>City</th><th>State</th><th>Yakima</th><th>West Valley</th></tr>";
	foreach($dbh->query($sql) as $row) {

		echo "<tr><td><form action=\"action.php\" method=\"get\">
		<input type=\"hidden\" name=\"team_Stats\" value=\"".$row['id']."\">
		<button type=\"submit\" class=\"link-button\">".$row['id']."</button>
		</form></td>";
		echo "<td>".$row['name']."</td>";
		echo "<td>".$row['city']."</td>";
		echo "<td>".$row['state']."</td>";
		echo "<td>".($row['Yakima']?"&#10004":"&#10006")."</td>";
		echo "<td>".($row['WV']?"&#10004":"&#10006")."</td></tr>";
	}
	echo "</table></div>\n";
}

function execDDL($user, $pass, $dbh, $sql){
	$dbh->exec($sql);
	echo "<p>New record created successfully!</p>";

}
function countRows($user, $pass, $dbh, $sql){
	
	if ($result = $dbh->query($sql)) {
		$count = $result->fetchColumn();
	}
	return $count;
}

?>
</body>
</html>
