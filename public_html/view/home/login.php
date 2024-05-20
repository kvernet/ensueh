<?php
include_once("header.php");
?>

<div class="jumbotron bg-dark py-5">

<div class="container py-5">
  <h3 class="lead display-6 text-light">Formulaire d'inscription</h3>
  <p class="lead text-light">
    Pour pouvoir proceder a votre inscription sur le site de l'ecole. Veuiller fournir les informations demandees dans les différents champs suivants: 
  </p>
</div>


  <div class="container py-3 bg-light rounded-5">
      <div class="row"> 

      </div>

    

      <div class="row">
        <form class="row g-3">
          <p class="lead font-redressed display-6">
              Informations personnelles
            </p>
          <div class="col-md-4">
            
            <label for="validationServer01" class="form-label">Prenom</label>
            <input type="text" class="form-control is-valid" id="validationServer01" value="Jean Rony" required>
          <div class="valid-feedback">
        Bien!
          </div>
      </div>
        <div class="col-md-4">
          <label for="validationServer02" class="form-label">Nom</label>
          <input type="text" class="form-control is-valid" id="validationServer02" value="Felix" required>
        <div class="valid-feedback">
        Bien!
        </div>
    </div>
    <div class="col-md-4">
      <label for="validationServerUsername" class="form-label">Email</label>
      <div class="input-group has-validation">
        <span class="input-group-text" id="inputGroupPrepend3">@</span>
        <input type="text" class="form-control is-invalid" id="validationServerUsername" aria-describedby="inputGroupPrepend3 validationServerUsernameFeedback" required>
        <div id="validationServerUsernameFeedback" class="invalid-feedback">
          Entrez votre email s'il vous plait.
        </div>
      </div>
    </div>

    <div class="col-md-4">
    <label for="validationServer06" class="form-label">Telephone</label>
            <input type="text" class="form-control is-valid" id="validationServer06" value="+50944097683" required>
            <div class="valid-feedback">
        Inserez votre numero de telephone
          </div>
    </div>
    <div class="col-md-3"></div>
    <div class="col-md-2 d-inline">
      <label for="validationServer04" class="form-label">Sexe</label>
      <div class="form-check">
  <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" checked>
  <label class="form-check-label" for="flexRadioDefault1">
    Masculin
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" >
  <label class="form-check-label" for="flexRadioDefault2">
    Feminin
  </label>
</div>
    </div>
   
    <p class="lead font-redressed display-6">
              Informations academiques
            </p>

            <div class="col-md-4">
      <label for="validationServer04" class="form-label">Departement</label>
      <select class="form-select is-invalid" id="validationServer04" aria-describedby="validationServer04Feedback" required>
        <option selected disabled value="">Faire un choix...</option>
        <option>Mathématiques</option>
        <option>Physiques</option>
        <option>Sciences naturelles</option>
        <option>Philosophie</option>
        <option>Lettres modernes</option>
        <option>Sciences sociales</option>
        <option>Langues vivantes</option>
      </select>
      <div id="validationServer04Feedback" class="invalid-feedback">
        Selectionnez un choix valide s'il vous plait.
      </div>
    </div>
    <div class="col-md-4">
      <label for="validationServer04" class="form-label">Niveau d'etude</label>
      <select class="form-select is-invalid" id="validationServer04" aria-describedby="validationServer04Feedback" required>
        <option selected disabled value="">Faire un choix...</option>
        <option>année preparatoire</option>
        <option>premiere annee</option>
        <option>deuxieme annee</option>
        <option>troisieme annee</option>
      </select>
      <div id="validationServer04Feedback" class="invalid-feedback">
      Selectionnez un choix valide s'il vous plait.
      </div>
    </div>
    <div class="col-md-4">
      <label for="validationServer05" class="form-label">Section</label>
      <input type="text" class="form-control is-invalid" id="validationServer05" aria-describedby="validationServer05Feedback" required>
      <div id="validationServer05Feedback" class="invalid-feedback">
      veuillez communiquer votre section s'il vous plait.
      </div>
    </div>

    <p class="lead font-redressed display-6">
              Informations de connexion
            </p>

            <div class="col-md-4">
            <label for="validationServerUsername" class="form-label">Nom d'utilisateur</label>
      <div class="input-group has-validation">
        <span class="input-group-text" id="inputGroupPrepend3">@</span>
        <input type="text" class="form-control is-invalid" id="validationServerUsername" aria-describedby="inputGroupPrepend3 validationServerUsernameFeedback" required>
        <div id="validationServerUsernameFeedback" class="invalid-feedback">
          Entrez votre email s'il vous plait.
        </div>
      </div>
    </div>
    <div class="col-md-4">
    <label for="validationServer05" class="form-label">Mot de passe</label>
      <input type="text" class="form-control is-invalid" id="validationServer05" aria-describedby="validationServer05Feedback" required>
      <div id="validationServer05Feedback" class="invalid-feedback">
      veuillez communiquer votre section s'il vous plait.
      </div>
    </div>
    <div class="col-md-4">
    <label for="validationServer05" class="form-label">Confirmez votre mot de passe</label>
      <input type="text" class="form-control is-invalid" id="validationServer05" aria-describedby="validationServer05Feedback" required>
      <div id="validationServer05Feedback" class="invalid-feedback">
      veuillez communiquer votre section s'il vous plait.
      </div>
    </div>

<div class="row g-3 mt-5 mx-2 border bg-secondary text-light">
    <div class="col-md-4 mt-4">
            <p class="border border-2 shadow-lg bg-primary opacity-75 text-center lead rounded-3 ">
              Termes et conditions applicables
            </p>

    </div>
    <div class="col-md-8 ">
            <p class="mx-1">Les informations fournies seront sauvegarder dans la base de donnees de l'ecole</p>
            <p class="mx-1">L'ecole se donne le droit d'utiliser ces informations dans le cadre academique</p>
    </div>
    
  </div>          

  <div class="col-md-5"> 

  </div>
    <div class="col-md-7 ">
      <div class="form-check">
        <input class="form-check-input is-invalid" type="checkbox" value="" id="invalidCheck3" aria-describedby="invalidCheck3Feedback" required>
        <label class="form-check-label" for="invalidCheck3">
          Agree to terms and conditions
        </label>
        <div id="invalidCheck3Feedback" class="invalid-feedback">
          You must agree before submitting.
        </div>
      </div>
    </div>

    <div class="col-md-9"> 

</div>

    <div class="col-md-2 my-4">
      <button class="btn btn-primary" type="submit">Submit form</button>
    </div>
  </form>

      </div>

  </div>
</div>

    
<?php
include_once("footer.php");
?>

<!-- <div class="jumbotron bg-dark py-5">

<div class="container py-5">
  <h3 class="lead display-6 text-light">Formulaire d'inscription</h3>
  <p class="lead text-light">
    Pour pouvoir proceder a votre inscription sur le site de l'ecole. Veuiller fournir les informations demandees dans les différents champs suivants: 
  </p>
</div>


  <div class="container py-3 bg-light rounded-5">
      <div class="row"> 

      </div>

    

      <div class="row">
        <form class="row g-3">
          <p class="lead font-redressed display-6">
              Informations personnelles
            </p>
          <div class="col-md-4">
            
            <label for="validationServer01" class="form-label">Prenom</label>
            <input type="text" class="form-control is-valid" id="validationServer01" value="Jean Rony" required>
          <div class="valid-feedback">
         Looks good! 
          </div>
      </div>
        <div class="col-md-4">
          <label for="validationServer02" class="form-label">Nom</label>
          <input type="text" class="form-control is-valid" id="validationServer02" value="Felix" required>
        <div class="valid-feedback">
        Looks good!
        </div>
    </div>
    <div class="col-md-4">
      <label for="validationServerUsername" class="form-label">Username</label>
      <div class="input-group has-validation">
        <span class="input-group-text" id="inputGroupPrepend3">@</span>
        <input type="text" class="form-control is-invalid" id="validationServerUsername" aria-describedby="inputGroupPrepend3 validationServerUsernameFeedback" required>
        <div id="validationServerUsernameFeedback" class="invalid-feedback">
          Please choose a username.
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <label for="validationServer03" class="form-label">City</label>
      <input type="text" class="form-control is-invalid" id="validationServer03" aria-describedby="validationServer03Feedback" required>
      <div id="validationServer03Feedback" class="invalid-feedback">
        Please provide a valid city.
      </div>
    </div>
    <div class="col-md-3">
      <label for="validationServer04" class="form-label">State</label>
      <select class="form-select is-invalid" id="validationServer04" aria-describedby="validationServer04Feedback" required>
        <option selected disabled value="">Choose...</option>
        <option>...</option>
      </select>
      <div id="validationServer04Feedback" class="invalid-feedback">
        Please select a valid state.
      </div>
    </div>
    <div class="col-md-3">
      <label for="validationServer05" class="form-label">Zip</label>
      <input type="text" class="form-control is-invalid" id="validationServer05" aria-describedby="validationServer05Feedback" required>
      <div id="validationServer05Feedback" class="invalid-feedback">
        Please provide a valid zip.
      </div>
    </div>
    <div class="col-12">
      <div class="form-check">
        <input class="form-check-input is-invalid" type="checkbox" value="" id="invalidCheck3" aria-describedby="invalidCheck3Feedback" required>
        <label class="form-check-label" for="invalidCheck3">
          Agree to terms and conditions
        </label>
        <div id="invalidCheck3Feedback" class="invalid-feedback">
          You must agree before submitting.
        </div>
      </div>
    </div>
    <div class="col-12">
      <button class="btn btn-primary" type="submit">Submit form</button>
    </div>
  </form>

      </div>

  </div>
</div> -->