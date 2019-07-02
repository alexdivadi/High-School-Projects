<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="/style.css">
<script src="script.js"></script>
</head>
<body>
<div class="form-main">
<br>
<div class="form-card">
	<h1>Scouting Form</h1>
<form class="f" method="post" action="/action.php" target="_self" id="form1">
	<span class="error">*</span><b>Your Name: </b>
	<input type="text" name="name" placeholder="ex. John Doe" required>
	<hr><h2>Round Info:</h2>
	<p><b style="color:red">Important:</b> Make absolutely sure this information is correct! Otherwise the form may not send!</p>
	<h4><span class="error">*</span>Competition:</h4>
		<label class="container"> Yakima
			<input type="radio" name="competition" value="Yakima" required>
			<span class="checkmark"></span>
		</label>
		<label class="container"> West Valley
			<input type="radio" name="competition" value="WV" required>
			<span class="checkmark"></span>
		</label>
		<label class="container"> Tacoma
			<input type="radio" name="competition" value="Tacoma" required>
			<span class="checkmark"></span>
		</label>
		<label class="container"> Houston
			<input type="radio" name="competition" value="Houston" required>
			<span class="checkmark"></span>
		</label>
		<label class="container"> Other
			<input type="radio" name="competition" value="1" required>
			<span class="checkmark"></span>
		</label>
	<br><span class="error">*</span><b>Round Number:</b>
	<br><input type="number" name="round" min="0" placeholder="ex. 19" value="round" required>
	<br><span class="error">*</span><b>Team ID:</b>
	<br><input type="number" name="id" min="0" placeholder="ex. 4061" value="id" required>
	<hr><h2>Pre-Game:</h2>
	<h4>Starting Level:</h4>
		<label class="container"> One
			<input type="radio" name="starting-level" value="3">
			<span class="checkmark"></span>
		</label>
		<label class="container"> Two
			<input type="radio" name="starting-level" value="6">
			<span class="checkmark"></span>
		</label>
		<label class="container"> Fail (Did not cross HAB line)
			<input type="radio" name="starting-level" value="0">
			<span class="checkmark"></span>
		</label>
	<h4>Pre-Load Robot Piece:</h4>
		<label class="container"> Hatch
			<input type="radio" name="preload-bot" value="1">
			<span class="checkmark"></span>
		</label>
		<label class="container"> Cargo
			<input type="radio" name="preload-bot" value="0">
			<span class="checkmark"></span>
		</label>
	<h4>Pre-Load Bay Pieces:</h4>
		<label class="container"> Hatch + Hatch
			<input type="radio" name="preload-bay" value="4">
			<span class="checkmark"></span>
		</label>
		<label class="container"> Cargo + Hatch
			<input type="radio" name="preload-bay" value="5">
			<span class="checkmark"></span>
		</label>
		<label class="container"> Cargo + Cargo
			<input type="radio" name="preload-bay" value="6">
			<span class="checkmark"></span>
		</label>
	<br>
	<b>Game pieces delivered during Sandstorm:</b>
	<input id="counter1" type="hidden" name="s-hatch" value="0">
	<br> Hatch: <label id="disp1">0</label> 
	<input type="button" class="button" value="+" onclick="increment('counter1','disp1','minus1')">
	<input type="button" id="minus1" class="button" value="-" onclick="decrement('counter1','disp1','minus1')" disabled>
	<input id="counter4" type="hidden" name="s-cargo" value="0">
	<br> Cargo: <label id="disp4">0</label> 
	<input type="button" class="button" value="+" onclick="increment('counter4','disp4','minus4')">
	<input type="button" id="minus4" class="button" value="-" onclick="decrement('counter4','disp4','minus4')" disabled>
	<br><hr>
	
	<h2>Main Game:</h2>
	<b># of Hatches (NOT including sandstorm):</b>
	<input id="counter2" type="hidden" name="m-hatch" value="0">
	<br><label id="disp2">0</label> 
	<input type="button" class="button" value="+" onclick="increment('counter2','disp2','minus2')">
	<input type="button" id="minus2" class="button" value="-" onclick="decrement('counter2','disp2','minus2')" disabled>
	<br>
	<br><b># of Cargo (NOT including sandstorm):</b>
	<input id="counter3" type="hidden" name="m-cargo" value="0">
	<br><label id="disp3">0</label> 
	<input type="button" class="button" value="+" onclick="increment('counter3','disp3','minus3')">
	<input type="button" id="minus3" class="button" value="-" onclick="decrement('counter3','disp3','minus3')" disabled>
	<br>
	<h4>Completed rocket?:</h4>
		<label class="container"> Yes
			<input type="radio" name="rocket" value="1">
			<span class="checkmark"></span>
		</label>
		<label class="container"> No
			<input type="radio" name="rocket" value="0">
			<span class="checkmark"></span>
		</label>
		<br>
	<hr><h2>End Game:</h2>
	<h4>Ending Level:</h4>
		<label class="container"> One
			<input type="radio" name="ending-level" value="3">
			<span class="checkmark"></span>
		</label>
		<label class="container"> Two
			<input type="radio" name="ending-level" value="6">
			<span class="checkmark"></span>
		</label>
		<label class="container"> Three
			<input type="radio" name="ending-level" value="12">
			<span class="checkmark"></span>
		</label>
		<label class="container"> None (Not on habitat)
			<input type="radio" name="ending-level" value="0">
			<span class="checkmark"></span>
		</label>
	<h4>Was this robot on the winning team?:</h4>
		<label class="container"> Yes
			<input type="radio" name="win" value="1">
			<span class="checkmark"></span>
		</label>
		<label class="container"> No
			<input type="radio" name="win" value="0">
			<span class="checkmark"></span>
		</label>
		<hr>
	<h2>Notes:</h2>
	<h4>Anything unprecedented or worth mentioning?</h4>
	<textarea rows="5" cols="50" name="notes" placeholder="ex. dead bot, robot carry, three-piece auto etc..."></textarea><br><br>
	</form>
	<br>
	<input type="submit" class="button" style="background-color:orange" name="submit_scouting_form" value="Submit" form="form1">
	<button onclick="goBack()" class="button" style="float:right"><b>Back</b></button>
	<br>
	</div>
<br>
</div>

</body>
</html>
