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
            window.open(data['page'], "_self");
        }else {
            spanTag.innerHTML = data['msg'];
        }
    } catch (e) {
        //alert(e);
    }
}

function sendForm(formData, page, spanTag, method = "POST") {
    sendData(formData, page, spanTag, method);
}