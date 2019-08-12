<?php $controlScript = '<script src="js/controlRegistration.js"></script>'; ?>

<?php ob_start(); ?>
<div class="row col-lg-12 mx-auto px-0 py-auto">
    <div id="registrationHelp" class="col-lg-4 mt-5 mx-auto mb-3 my-md-auto pb-3 px-auto bg-light rounded">
        <p class="h5 mt-lg-2">Pour vous inscrire vous devez :</p>
        <ul class="list-group">
            <li id="registrationPseudo" class="list-group-item">Renseigner un Pseudo</li>
            <li id="registrationMail" class="list-group-item">Renseigner une adresse mail valide</li>
            <li id="registrationPassword" class="list-group-item">Renseigner un mot de passe compris entre 8 et 14 caractères</li>
            <li id="registrationVerifPassword" class="list-group-item">Vérifier le mot de passe</li>
        </ul>
    </div>
    <div class="col-md-5 col-lg-4 mx-auto my-auto px-auto">
        <form action="index.php?action=registration&amp;sent=yes" method="post" id="register" class="col-lg-12 mx-auto mt-lg-5 px-auto py-2 bg-light rounded">
            <div class="form-group">
                <label for="pseudo">Pseudo</label><br />
                <input type="text" id="pseudo" name="pseudo" class="form-control" required="required" />
            </div>
            <div class="form-group" >
                <label for="mail">Adresse email</label><br />
                <input type="email" id="mail" name="mail" class="form-control" required="required" />
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label><br />
                <input type="password" id="password" name="password" class="form-control" required="required" />
            </div>
            <div class="form-group">
                <label for="confirm_pass">Confirmation du mot de passe</label><br />
                <input type="password" id="confirm_password" name="confirm_password" class="form-control" required="required" />
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-warning font-weight-bold">Inscription</button>
            </div>
        </form>
    </div>
</div>

<?php $content = ob_get_clean(); ?>
<?php
require('../view/navbar.php');
require('../view/backoffice/adminBar.php');
require('../view/template.php');
