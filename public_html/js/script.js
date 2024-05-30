function checkLength(tag, min_length, msg, span) {
    if (tag.value.length < min_length) {
        span.innerHTML = msg;
        return false;
    }
    return true;
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

async function sendData(form, page, spanTag, method) {
    // Associate the FormData object with the form element
    const formData = new FormData(form);

    try {
        const response = await fetch(page, {
            method: method,
            // Set the FormData instance as the request body
            body: formData
        });
        const data = await response.json();
        console.log(data);

        if(data['msg_id'] == data['msg_id_success']) {
            window.open(data['page'], "_self");
        }else {
            spanTag.innerHTML = data['msg'];
        }
    } catch (e) {
        //alert(e);
    }
}

function sendLoginForm(form, page, spanTag, method = "POST") {
    sendData(form, page, spanTag, method);
}