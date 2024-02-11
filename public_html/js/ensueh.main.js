/***
*	Author: Kinson VERNET, 2022
*/

// check element length
function checkByLength(elementId, minLength, spanId, message) {
	const element = document.getElementById(elementId);
	const span = document.getElementById(spanId);
	if(element.value.length < minLength) {
		span.innerHTML = message;
		span.hidden = false;
		element.focus();
		return false;
	}
	else {
		span.hidden = true;
		return true;
	}
}

// check element format
function checkByFormat(elementId, validRegex, spanId, message) {
	const element = document.getElementById(elementId);
	const span = document.getElementById(spanId);
	const length = validRegex.length;
	for(i = 0; i < length; i++) {
		if ( element.value.match(validRegex[i]) ) {
			span.hidden = true;
			return true;
		}
	}	
	span.innerHTML = message;
	span.hidden = false;
	element.focus();
	return false;
}

function checkSelect(elementId, invalidValue, spanId, message) {
    const element = document.getElementById(elementId);
	const span = document.getElementById(spanId);
    if( element.value == invalidValue ) {
        span.innerHTML = message;
        span.hidden = false;
        element.focus();
        return false;
    }
    span.hidden = true;
	return true;
}

// check password format
function checkPassword(passId, rpassId, minLength, spanId, message) {
	const password = document.getElementById(passId);
	const rpassword = document.getElementById(rpassId);
	const span = document.getElementById(spanId);
	var valid = true;	
	if( checkByLength(passId, minLength, spanId, message[0]) ) {
		// check if strong
		span.innerHTML = "";
		const regex = [];
		regex[0] = /.*\d/;
		regex[1] = /.*[A-Z]/;
		regex[2] = /.*[!@#$%^&*() =+_-]/;		
		for(i = 0; i < 3; i++) {
			if( password.value.search(regex[i]) < 0 ) {
				if(span.innerHTML === "") span.innerHTML = '- ' + message[i + 1];
				else span.innerHTML += '<br>-' + message[i + 1];
				valid = false;
			}
		}		
		if(!valid) {
			span.hidden = false;
			password.focus();
			return false;
		}		
		if(password.value != rpassword.value) {
			span.innerHTML = message[4];
			span.hidden = false;
			rpassword.focus();
			return false;
		}		
		return true;
	}	
	return false;
}


function sendData(formData, spanId = "details", action = "", method = "POST") {
	//showProgress();
	const span = document.getElementById(spanId);
    var request;
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		request = new XMLHttpRequest();
	}
	else {
		// code for IE6, IE5
		request = new ActiveXObject("Microsoft.XMLHTTP");
	}
	request.onreadystatechange = function () {
		if (request.readyState == 4 && request.status == 200) {
			const result = JSON.parse( request.responseText );
			
			if( result["status"] == 1 ) {
				if(result["url"] != null) window.open(result["url"], "_self");
			}
			else {
				span.innerHTML = result["message"];
				span.hidden = false;
			}
		}
	};
	request.open(method, action);
	request.send(formData);
}