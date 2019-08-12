<?php ob_start(); ?>
<div class="row col-lg-12 mx-auto px-0">
    <form action="index.php?action=addPost" method="post" class="col-12 mx-auto mb-5 p-auto bg-dark text-light rounded">
        <div class="form-group">
            <label for="type">Type de billet</label>
            <select name="type" id="type" class="form-control col-md-2">
                <option value="NULL" selected="selected"></option>
                <option value="chapter">Chapitre</option>
                <option value="announcement">Annonce</option>
                <option value="general">Général</option>
            </select>
        </div>
        <div class="form-group" >
            <label for="title">Titre</label><br />
            <input type="text" id="title" name="title" class="form-control" />
        </div>
        <div class="form-group">
            <label for="content">Contenu</label><br />
            <textarea id="content" name="content" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-warning text-dark font-weight-bold">Envoyer</button>
        </div>
    </form>
</div>
<?php $content = ob_get_clean(); ?>
<?php
require('../view/navbar.php');
require('../view/backoffice/adminBar.php');
require('../view/template.php');
