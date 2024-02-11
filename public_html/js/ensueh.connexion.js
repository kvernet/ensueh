/***
*	Author: Kinson VERNET, 2023
*/

const userName = document.getElementById("user_name");
const password = document.getElementById("password");

function btSigninClick() {
    const message = "Votre identifiant doit avoir au moins 5 caractères.";
    if( checkByLength("user_name", 5, "details", message) ) {
        const message = "Votre mot de passe doit contenir au moins 7 caractères.";
        if( checkByLength("password", 7, "details", message) ) {
            var formData = new FormData();
            formData.append('userName', userName.value);
            formData.append('password', password.value);
            sendData(formData, "details", "./../connexion/signin.php", "POST");
        }
    }

    return false;
}