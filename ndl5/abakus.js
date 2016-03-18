window.onload = function() {
	var pallid = new Array();
	pallid = document.getElementsByClassName("bead");
	
	for (var i=0; i < pallid.length; i++){
		pallid[i].innerHTML = i+1;
		pallid[i].style.textAlign = "center";
	}
	
	for (var i=0; i< pallid.length ; i++){
		var koht = window.getComputedStyle(pallid[i]).getPropertyValue("float");
		if (koht=="right"){
			//console.log(i + " paremal");
			pallid[i].style.cssFloat="left";
		} else if (koht=="left"){
			//console.log(i + " vasakul");
			pallid[i].style.cssFloat="right";
		} else {
			console.log("pole kuskil");
		}
	}
}