<?php $controlScript = '<script src="js/controlUpdate.js"></script>'; ?>

<?php ob_start(); ?>
<div class="col-12 mx-auto px-0">
    <div class="row">
        <table class="table table-responsive-md table-striped table-dark">
            <thead>
                <th scope="col">Pseudo</th>
                <th scope="col">Mail</th>
                <th scope="col">Date de création</th>
            </thead>
            <tbody>
                <tr>
                    <td><?= htmlspecialchars($user->pseudo()) ?></td>
                    <td><?= htmlspecialchars($user->mail()) ?></td>
                    <td><?= htmlspecialchars($user->date()) ?></td>

                </tr>
            </tbody>
        </table>
    </div>
    <div class="row mt-3 mx-auto px-0 bg-dark rounded">
        <div class="col-md-3 order-2 order-lg-1 mx-auto mr-lg-4">
            <h3 class=" text-light">Modifier votre mail</h3>
            <form id="mail_update" class="form ml-2" action="index.php?action=update_mail" method="post" >
                <div class="form-group">
                    <input class="form-control mr-2" type="mail" name="mail" placeholder="Nouveau mail"/>
                </div>
                <div class="form-group">
                    <input class="form-control mr-2" type="password" name="password" placeholder="Mot de passe" />
                </div>
                <div class="form-group">
                    <button class="btn btn-success" type="submit">Modifier</button>

                </div>
            </form>
        </div>
        <div id="registrationHelp" class="col-lg-3 order-1 order-lg-2 mt-5 mx-auto mb-5 pb-3 px-auto bg-light rounded">
            <h4 class="h5 mt-2 mb-3">Pour mettre à jour vos données vous devez :</h4>
            <ul class="list-group">
                <li id="updateMailHelp" class="list-group-item">Renseigner une adresse mail valide</li>
                <li id="updatePasswordHelp" class="list-group-item">Renseigner un mot de passe compris entre 8 et 14 caractères</li>
                <li id="verifPasswordHelp" class="list-group-item">Vérifier le mot de passe</li>
            </ul>
        </div>
        <div class="col-md-3 order-3 mx-auto ml-lg-4">
            <h3 class=" text-light">Modifier votre mot de passe</h3>
            <form id="password_update" class="form ml-2" action="index.php?action=update_password" method="post" >
                <div class="form-group">
                    <input class="form-control mr-2" type="password" name="password" placeholder="Mot de passe" />
                </div>
                <div class="form-group">
                    <input class="form-control mr-2" type="password" name="new_password" placeholder="Nouveau mot de passe"/>
                </div>
                <div class="form-group">
                    <input class="form-control mr-2" type="password" name="confirm_new_password" placeholder="Confirmer le nouveau mot de passe" />
                </div>
                <div class="form-group">
                    <button class="btn btn-success" type="submit">Modifier</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php
require('../view/navbar.php');
require('../view/backoffice/adminBar.php');
require('../view/template.php');
