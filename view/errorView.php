<?php ob_start(); ?>
<div id="error_message" class="col-lg-6 mx-auto my-auto bg-dark rounded text-light">
    <p class="my-auto pt-2 text-center text-light"><span class="text-danger font-weight-bold">Erreur :</span> <?= $errorMessage?></p>
</div>
<?php $content = ob_get_clean(); ?>
<?php
require('view/navbar.php');
require('view/backoffice/adminBar.php');
require('view/frontoffice/template.php');
