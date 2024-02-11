/***
*	Author: Kinson VERNET, 2023
*/

const firstName = document.getElementById("first_name");
const lastName = document.getElementById("last_name");
const genderId = document.getElementById("gender");
const email = document.getElementById("email");
const phone = document.getElementById("phone");
const statusId = document.getElementById("status");
const departmentId = document.getElementById("department");
const gradeId = document.getElementById("grade");
const userName = document.getElementById("user_name");
const password = document.getElementById("password");
const confirmPassword = document.getElementById("confirm_password");
const details = document.getElementById("details");


function btSignupClick() {
    const message = "Votre prénom doit avoir au moins 3 caractères.";
    if( checkByLength("first_name", 3, "details", message) ) {
        const message = "Votre nom doit avoir au moins 3 caractères.";
        if( checkByLength("last_name", 3, "details", message) ) {
            const message = "Choisissez votre sexe.";
            if( checkSelect("gender", -1, "details", message) ) {
                const message = "Veuillez entrer un émail correcte.";
                const validRegex = [];
                validRegex[0] = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
                if( checkByFormat("email", validRegex, "details", message) ) {
                    const message = "Veuillez entrer un numéro de téléphone valide.";
                    const validRegex = [];
                    validRegex[0] = /^\d{8}$/;
				    validRegex[1] = /^\d{10}$/;
                    if( checkByFormat("phone", validRegex, "details", message) ) {
                        const message = "Choisissez votre statut.";
                        if( checkSelect("status", -1, "details", message) ) {
                            const message = "Choisissez votre département.";
                            if( checkSelect("department", -1, "details", message) ) {
                                const message = "Choisissez votre niveau.";
                                if( checkSelect("grade", -1, "details", message) ) {
                                    const message = "Votre identifiant doit contenir au moins 5 caractères.";
                                    if( checkByLength("user_name", 5, "details", message) ) {
                                        const message = [];
                                        message[0] = "Votre mot de passe doit contenir au moins 7 caractères.";
                                        message[1] = "Votre mot de passe doit contenir au moins 1 chiffre.";
                                        message[2] = "Votre mot de passe doit contenir au moins une majuscule.";
                                        message[3] = "Votre mot de passe doit contenir au moins un de ces caractères: !@#$%^&*()=+_- ";
                                        message[4] = "Les mots de passe ne se correspondent pas.";
                                        if( checkPassword("password", "rpassword", 7, "details", message) ) {
                                            var formData = new FormData();
                                            formData.append('firstName', firstName.value);
                                            formData.append('lastName', lastName.value);
                                            formData.append('genderId', genderId.value);
                                            formData.append('email', email.value);
                                            formData.append('phone', phone.value);
                                            formData.append('statusId', statusId.value);
                                            formData.append('departmentId', departmentId.value);
                                            formData.append('gradeId', gradeId.value);
                                            formData.append('userName', userName.value);
                                            formData.append('password', password.value);
                                            sendData(formData, "details", "./../inscription/signup.php", "POST");
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    
    return false;
}