function checkLength(tag, min_length, msg, span) {
    if (tag.value.length < min_length) {
        span.innerHTML = msg;
        return false;
    }
    return true;
}

function sendLoginForm(form, page, spanTag) {
    sendData(form, page, spanTag);
}

async function sendData(form, page, spanTag, method = "POST") {
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