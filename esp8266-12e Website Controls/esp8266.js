

var D0;
var D1;
var D2;
var D3;
var D4;
var D5;
var D6;
var D7;
var D8;


function start(){
	//do boot up stuff here
	initializeBooleans();
}


//////////////////////////////  BOOLEAN CONTROLS  ////////////////////////

function initializeBooleans(){
	let request = new XMLHttpRequest();
	request.open("POST", "tx_boolean.php?mode=x", true);
	request.send();
	request.onreadystatechange = function(){
		if(request.readyState == 4 && request.status == 200){
			let data = request.responseXML;
			let payload = data.getElementsByTagName('status');

			if(payload[0].childNodes[0].nodeValue == 0){
				D0 = false;
			}
			else if(payload[0].childNodes[0].nodeValue == 1){
				D0 = true;
			}
			else{
				D0 = payload[0].childNodes[0].nodeValue;
			}
			setButtonColor("btn0", D0);
			
			
			if(payload[1].childNodes[0].nodeValue == 0){
				D1 = false;
			}
			else if(payload[1].childNodes[0].nodeValue == 1){
				D1 = true;
			}
			else{
				D1 = payload[1].childNodes[0].nodeValue;
			}
			setButtonColor("btn1", D1);
			
			
			if(payload[2].childNodes[0].nodeValue == 0){
				D2 = false;
			}
			else if(payload[2].childNodes[0].nodeValue == 1){
				D2 = true;
			}
			else{
				D2 = payload[2].childNodes[0].nodeValue;
			}
			setButtonColor("btn2", D2);
			
			
			if(payload[3].childNodes[0].nodeValue == 0){
				D3 = false;
			}
			else if(payload[3].childNodes[0].nodeValue == 1){
				D3 = true;
			}
			else{
				D3 = payload[3].childNodes[0].nodeValue;
			}
			setButtonColor("btn3", D3);
			
			
			if(payload[4].childNodes[0].nodeValue == 0){
				D4 = false;
			}
			else if(payload[4].childNodes[0].nodeValue == 1){
				D4 = true;
			}
			else{
				D4 = payload[4].childNodes[0].nodeValue;
			}
			setButtonColor("btn4", D4);
			
			
			if(payload[5].childNodes[0].nodeValue == 0){
				D5 = false;
			}
			else if(payload[5].childNodes[0].nodeValue == 1){
				D5 = true;
			}
			else{
				D5 = payload[5].childNodes[0].nodeValue;
			}
			setButtonColor("btn5", D5);
			
			
			if(payload[6].childNodes[0].nodeValue == 0){
				D6 = false;
			}
			else if(payload[6].childNodes[0].nodeValue == 1){
				D6 = true;
			}
			else{
				D6 = payload[6].childNodes[0].nodeValue;
			}
			setButtonColor("btn6", D6);
			
			
			if(payload[7].childNodes[0].nodeValue == 0){
				D7 = false;
			}
			else if(payload[7].childNodes[0].nodeValue == 1){
				D7 = true;
			}
			else{
				D7 = payload[7].childNodes[0].nodeValue;
			}
			setButtonColor("btn7", D7);
			
			
			if(payload[8].childNodes[0].nodeValue == 0){
				D8 = false;
			}
			else if(payload[8].childNodes[0].nodeValue == 1){
				D8 = true;
			}
			else{
				D8 = payload[8].childNodes[0].nodeValue;
			}
			setButtonColor("btn8", D8);
		}
	}
}



function setButtonColor(btn, st){
	let b = document.getElementById(btn);
	if(st == true){
		b.style.backgroundColor = "green";
	}
	else if(st == false){
		b.style.backgroundColor = "red";
	}
	else{
		b.style.backgroundColor = "yellow";
		// maybe work value into the button label somehow
	}
	
}

function togglePin(btn, p){
	if(document.getElementById('pwmCheck').checked == true){
		let b = document.getElementById(btn);
		switch(p){
			case 0:
				document.getElementById('results').innerHTML = "Pin D0 on an ESP8266-12E does not support PWM";
				break;
			case 1:
				document.getElementById('results').innerHTML = "Pin D1 on an ESP8266-12E does not support PWM";
				break;
			case 2:
				D2 = document.getElementById('pwmSlider').value;
				setButtonColor(btn, D2);
				updateBooleanQuery("booleanControl", p, D2);
				break;
			case 3:
				document.getElementById('results').innerHTML = "Pin D3 on an ESP8266-12E does not support PWM";
				break;
			case 4:
				document.getElementById('results').innerHTML = "Pin D4 on an ESP8266-12E does not support PWM";
				break;
			case 5:
				D5 = document.getElementById('pwmSlider').value;
				setButtonColor(btn, D5);
				updateBooleanQuery("booleanControl", p, D5);
				break;
			case 6:
				D6 = document.getElementById('pwmSlider').value;
				setButtonColor(btn, D6);
				updateBooleanQuery("booleanControl", p, D6);
				break;
			case 7:
				document.getElementById('results').innerHTML = "Pin D7 on an ESP8266-12E does not support PWM";
				break;
			case 8:
				D8 = document.getElementById('pwmSlider').value;
				setButtonColor(btn, D8);
				updateBooleanQuery("booleanControl", p, D8);
				break;
			default:
				//don't do anything
		}
		document.getElementById('pwmCheck').checked = false;
	}
	else{
		let b = document.getElementById(btn);
		switch(p){
			case 0:
				D0 = !D0;
				setButtonColor(btn, D0);
				updateBooleanQuery("booleanControl", p, D0);
				break
			case 1:
				D1 = !D1;
				setButtonColor(btn, D1);
				updateBooleanQuery("booleanControl", p, D1);
				break
			case 2:
				if(D2 == true || D2 == false){
					D2 = !D2;
				}
				else{
					D2 = false;
				}
				setButtonColor(btn, D2);
				updateBooleanQuery("booleanControl", p, D2);
				break;
			case 3:
				D3 = !D3;
				setButtonColor(btn, D3);
				updateBooleanQuery("booleanControl", p, D3);
				break
			case 4:
				D4 = !D4;
				setButtonColor(btn, D4);
				updateBooleanQuery("booleanControl", p, D4);
				break
			case 5:
				if(D5 == true || D5 == false){
					D5 = !D5;
				}
				else{
					D5 = false;
				}
				setButtonColor(btn, D5);
				updateBooleanQuery("booleanControl", p, D5);
				break;
			case 6:
				if(D6 == true || D6 == false){
					D6 = !D6;
				}
				else{
					D6 = false;
				}
				setButtonColor(btn, D6);
				updateBooleanQuery("booleanControl", p, D6);
				break;
			case 7:
				D7 = !D7;
				setButtonColor(btn, D7);
				updateBooleanQuery("booleanControl", p, D7);
				break
			case 8:
				if(D8 == true || D8 == false){
					D8 = !D8;
				}
				else{
					D8 = false;
				}
				setButtonColor(btn, D8);
				updateBooleanQuery("booleanControl", p, D8);
				break;
			default:
				//don't do anything
		}
	}
}



function updateSlider(){
	let val = document.getElementById('pwmSlider').value;
	document.getElementById('pwmValue').innerHTML = val;
}

function clearResults(){
	document.getElementById('results').innerHTML = "";
}

function updateBooleanQuery(script, pin, state){
    let results = document.getElementById('results');
	let query = "UPDATE booleanControl SET status = " + state + " WHERE pinNumber = " + pin;
    let request = new XMLHttpRequest();
	request.open("POST", script + ".php?query=" + query, true);
	request.send();
	request.onreadystatechange = function(){
		if(request.readyState == 4 && request.status == 200){
			results.innerHTML = request.responseText;
			/*
			 * responseText should be either "success" or "failure"
			 */
		}
	}
}//end updateBooleanQuery()







//////////////////////////  TEXT CONTROLS  //////////////////////////////////



function sendCommand(){
    let command = document.getElementById('command').value;
	let results = document.getElementById('textResults');
	let request = new XMLHttpRequest();
	request.open("POST", "textControl.php?command=" + command, true);
	request.send();
	request.onreadystatechange = function(){
		if(request.readyState == 4 && request.status == 200){
			results.innerHTML = request.responseText;
		}
	}
	document.getElementById('command').value = "";
}//end sendCommand()


function clearCommands(){
	let request = new XMLHttpRequest();
	request.open("POST", "removeCommands.php", true);
	request.send();
	request.onreadystatechange = function(){
		if(request.readyState == 4 && request.status == 200){
			results.innerHTML = request.responseText;
		}
	}
	updateDisplay();
}//end clearCommands()



function clearTextResults(){
	document.getElementById('textResults').innerHTML = "";
}







//////////////////////////  OUTPUT FROM MICROCONTROLLER  ///////////////////////////

function updateDisplay(){
	let results = document.getElementById('output');
	let request = new XMLHttpRequest();
	request.open("POST", "updateDisplay.php", true);
	request.send();
	request.onreadystatechange = function(){
		if(request.readyState == 4 && request.status == 200){
			results.innerHTML = request.responseText;
		}
	}
}

