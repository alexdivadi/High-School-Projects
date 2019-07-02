function openNav() {
	document.getElementById("myNav").style.width = "250px";
}
function closeNav() {
	document.getElementById("myNav").style.width = "0";
}
function goBack() {
	window.history.back()
}
function increment(id1, id2, id3) {
	var newvalue = parseInt(document.getElementById(id1).value);
	newvalue++;
	document.getElementById(id1).value = newvalue;
	document.getElementById(id2).innerHTML = newvalue;
	document.getElementById(id3).disabled = false;
}
function decrement(id1, id2, id3) {
	var newvalue = parseInt(document.getElementById(id1).value);
	if (newvalue > 0) {
	newvalue--;
	document.getElementById(id1).value = newvalue;
	document.getElementById(id2).innerHTML = newvalue;
		if (newvalue == 0){
			document.getElementById(id3).disabled = true;
		}
	}
}
