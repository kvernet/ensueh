function checkLength(tag, min_length, msg, span) {
    if (tag.value.length < min_length) {
        span.innerHTML = msg;
        return false;
    }
    return true;
}

function createCookie(name, value, days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000)); // Convert days to milliseconds
        expires = "; expires=" + date.toString();
    }
    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}

function emailValid (email) {
    var re = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    return re.test(email);
}

function passwordValid(password) {
    var re = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
    return re.test(password);
}

function phoneNumberValid(phone) {
    // various international formats
    var re = /^\+?\d{1,4}?[-.\s]?(\d{1,3}?[-.\s]?){1,4}\d{1,4}$/;
    return re.test(phone);
}

async function sendData(formData, page, spanTag, method) {
    try {
        const response = await fetch(page, {
            method: method,
            // Set the FormData instance as the request body
            body: formData
        });
        const data = await response.json();

        if(data['msg_id'] == data['msg_id_success']) {
            window.open(data['page'] + "?msg=" + data['msg'], "_self");
        }else {
            if(spanTag) {
                spanTag.innerHTML = data['msg'];
            }
        }
    } catch (e) {
        //alert(e);
    }
}

function sendForm(formData, page, spanTag, method = "POST") {
    sendData(formData, page, spanTag, method);
}

function setData(formData, page, tag, func=null, method="POST") {
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
            if(tag) {
                tag.innerHTML = request.responseText;
                console.log(request.responseText);
            }
            if(func) func();
        }
    };
    request.open(method, page);;
    request.send(formData)
}

function saveData(formData, page, method="POST", span=null, tag=null, func=null, funcCalledOnSucceed=true) {
    var request;
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        request = new XMLHttpRequest();
    }
    else {
        // code for IE6, IE5
        request = new ActiveXObject("Microsoft.XMLHTTP");
    }
    request.onreadystatechange = () => {
        if (request.readyState == 4 && request.status == 200) {
            var result = JSON.parse(request.responseText);
            if(span) {
                if(!result['success']) {
                    span.innerHTML = result['msg'];
                }
            }
            
            if(tag) {
                if(result['success']) {
                    tag.innerHTML = result['content'];
                }                
            }

            if(func) {
                if(funcCalledOnSucceed) {
                    if(result['success']) {
                        func();
                    }
                }else {
                    func();
                }
            }
        }
    };
    request.open(method, page);;
    request.send(formData)
}

async function fileExists(url) {
    try {
        const response = await fetch(url, { method: 'HEAD' });
        return response.ok;
    } catch (error) {
        console.error('Error checking file existence:', error);
        return false;
    }
}

function getRndInteger(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}