$(document).ready(function(){
	var errorraised = false;
	var passwordset = false;
	var getClickStarted = false;
	var autosubmit = true;
	var password;
    var centerX1;
    var centerY1;
    var curX = 0;
    var curY = 0;
    var getClickStarted = false;
    var htmlLine;
    var startpointnumber=0;
    var endpointnumber=0;

	/*(function checkIfPasswordIsSet() {
		if (localStorage.getItem("password")) {
			document.getElementById("heading").innerHTML = "Enter pattern to unlock screen";
			passwordset = true;
		}
		else {
			document.getElementById("heading").innerHTML = "Please set your pattern";
		}
	}());*/

	(function generatebuttons(){
		var patterncontainer  = document.getElementById("patterncontainers");
		for (var i = 1; i <=9; i++) {
			var button = document.createElement("div");
			button.className = "buttons";
			button.id = "buttons" + i;
			if (patterncontainer != null) {
			patterncontainer.appendChild(button);
			}

			startposition = document.getElementById("buttons" + i);
		}
	}());

	(function main(){
		if(!window.navigator.msPointerEnabled) {

			$(".buttons").on("mousedown", function (event){

				if(!getClickStarted){
					
					getClickStarted = true;

					var offset1 = $("#" + event.target.id).position();

					centerX1 = offset1.left + $("#" + event.target.id).innerWidth()/2 + 20.5; //22.5 is the margin of the button class
					centerY1 = offset1.top + $("#" + event.target.id).innerHeight()/2 + 20.5;

					//console.log("centerX1 " + centerX1);
					//console.log("centerY1 " + centerY1);

					if (event && event.preventDefault){
			               event.preventDefault();
		            }

					$("#" + event.target.id).removeClass("buttons").addClass("activebuttons");

					password = event.target.id.split("buttons").join("");
					startpointnumber = event.target.id.split("buttons").join("");

					//console.log("startpointnumber " + startpointnumber);

					addline(startpointnumber, centerX1, centerY1); //initiating a moving line
				}

			});

			$(document).bind("mousemove", function(event) {
			    if (getClickStarted){ //to avoid mousemove triggering before click

			        if (event && event.preventDefault){
			           event.preventDefault();
			        }

			        curX = event.clientX - $("#patterncontainers").offset().left;
			        curY = event.clientY - $("#patterncontainers").offset().top;

			        var width = Math.sqrt(Math.pow(curX - centerX1, 2) + Math.pow(curY - centerY1, 2)); //varying width and slope
			        var slope = Math.atan2(curY - centerY1, curX - centerX1)*180/3.14;

			        //setting varying width and slope to line
			        //alert(width);
			        width = 30;
			        $("#lines" + startpointnumber).css({"width": + width +"px", "height": "4px", "transform": "rotate(" + slope + "deg)", "-webkit-transform": "rotate(" + slope + "deg)", "-moz-transform": "rotate(" + slope + "deg)"});

			        //if button is found on the path
    	    		$(".buttons").bind("mouseover", function(e) {

    	    			if (getClickStarted){

    	    			endpointnumber = e.target.id.split("buttons").join("");

        				if (startpointnumber != endpointnumber) {
							if (e && e.preventDefault){
				               e.preventDefault();
				            }

				            if (e.target.className == "buttons") {
				            	$("#" + e.target.id).removeClass("buttons").addClass("activebuttons");
							} else {
								$("#" + e.target.id).removeClass("activebuttons").addClass("duplicatebuttons");
							}

				            password += e.target.id.split("buttons").join("");
				            // endpointnumber = e.target.id.split("button").join("");

				            $("#lines" + startpointnumber).attr("id", "lines" + startpointnumber + endpointnumber);

				            var offset2 = $("#" + e.target.id).position();
				            
				            var centerX2 = offset2.left + $("#" + e.target.id).innerWidth()/2 + 20.5;  //20.5 is the margin of activebutton class
				            var centerY2 = offset2.top + $("#" + e.target.id).innerHeight()/2 + 20.5;

				            var linewidth = Math.sqrt(Math.pow(centerX2 - centerX1, 2) + Math.pow(centerY2 - centerY1, 2));
				            var lineslope = Math.atan2(centerY2 - centerY1, centerX2 - centerX1)*180/3.14;

				            $("#lines" + startpointnumber + endpointnumber).css({"width": + linewidth +"px", "transform": "rotate(" + lineslope + "deg)", "-webkit-transform": "rotate(" + lineslope + "deg)", "-moz-transform": "rotate(" + lineslope + "deg)"});

				            startpointnumber = endpointnumber;
				            centerX1 = centerX2;
				            centerY1 = centerY2;

				            addline(startpointnumber, centerX1, centerY1);
        				}
                       }
    	    		});
			    }

				$("#patterncontainers").on("mouseup", function (event){

					if(getClickStarted) {
						if (event && event.preventDefault){
			               event.preventDefault();
			            }

			            $("#lines" + startpointnumber).remove();

			            if (autosubmit) {
			               	formsubmit();
			            }
					}
					getClickStarted = false;
				});
			});

		} else {
			alert ("INTERNET EXPLORER NOT SUPPORTED!!");
		}
	}());

	function addline(startpointnumber, centerX1, centerY1){
		var htmlLine = "<div id='lines" + startpointnumber + "' class='lines' style='position: absolute; top: " + centerY1 + "px; \
		            left: " + centerX1 + "px; -webkit-transform-origin: 2px 2px; -moz-transform-origin: 2.5% 50%; background-color: #FFF;'></div>"

		$("#patterncontainers").append(htmlLine);
	}

	function formsubmit(){
		$('#patterns').val(password);
	    var digits = getlength(password);
	    if(digits<5) {
	    	raiseerror("lengthTooSmall");
	    }

	    checkduplicatedigits(password);
	   
	    /*if (errorraised == false && passwordset == false) {
			localStorage.setItem("password", password);
			successmessage("patternStored");
	    }
	    else if ( errorraised == false && passwordset == true) {
	    	if (localStorage.getItem("password") == password) {
	    		successmessage("screenUnlocked");
	    		window.location = "./welcome.html";
	    		return false;
	    	}
	    	else {
	    		raiseerror("IncorrectPattern");
	    	}
	    }*/
	};

	function getlength(number) {
	    return number.toString().length;
	};

	function checkduplicatedigits(number) {
		var digits = getlength(number);
		numberstring = number.toString();
		var numberarray = numberstring.split("");
		var i; var j;
		for (i = 0; i < digits-1; i++) {
			for (j = i+1; j < digits; j++) {
				if(numberarray[i] == numberarray[j]) {
					raiseerror("repeatedEntry");
				}
			}
		}
	};

	/*function successmessage(successcode) {
		if(successcode == "screenUnlocked") {
			alert("You have unlocked the screen!");
		}
		if (successcode == "patternStored") {
			alert("Your pattern is stored. Thanks.");
			passwordset = true;	
		}
		if (successcode == "Success") {
			alert("Pattern Reset Success!");
		}
		location.reload();
	};*/

	function raiseerror(errorcode) {
		$('#patterns').val('');
		$('.lines').remove();
			$('.activebuttons').each(function(){
				$(this).removeClass("duplicatebuttons").addClass("buttons");
				$(this).removeClass("activebuttons").addClass("buttons");
			});
			$('.duplicatebuttons').each(function(){
				$(this).removeClass("duplicatebuttons").addClass("buttons");
				$(this).removeClass("activebuttons").addClass("buttons");
			});
		if(!errorraised){
			errorraised = true;
			if (errorcode == "lengthTooSmall") {
				alert("The pattern is too short. Please try again.");
			}
			if (errorcode == "repeatedEntry") {
				alert("You cannot use the same number twice. Please try again.");
			}
			if (errorcode == "IncorrectPattern") {
				alert("The entered pattern in incorrect. Please try again.");
			}
			if (errorcode == "emptyPassword") {
				alert("You did not set the password to reset it.");
			}
			errorraised = false;
			
			//location.reload();
		}
	};
});