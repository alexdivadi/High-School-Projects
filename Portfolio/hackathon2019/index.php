<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="styles.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</head>
<body>
<div  class="wheatbackground"></div>
<div class="bigheader"><h1>Obtain The Grain</h1></div>
<div class="row">
	<div class = "col-2"></div>
	<div class = "col-8">

		<div class="jumbotron">
  		<h1 class="display-4">Welcome to Obtain The Grain!</h1>
  		<p class="lead">Search for a list of recipes with the ingredients you have!</p>
  		<hr class="my-4">
  		<p>It's the college student's cookbook!</p>
	</div>
	</div>

	<div class = "col-2"></div>
</div>

<div class = "row">
	<div class="col">
		<div class="form-card">
		<form class="f" action="action.php" method="get" autocomplete="off">
			<label>Enter ingredients separated by commas (No spaces!)</label><br>
			<input type="textarea" name="ingredients" placeholder="ex. apple,milk" required>
			<input type="submit" name="submit_search">
		</form>
		</div>
	</div>

</div>

</body>
</html>
