<?php ob_start(); ?>
<div class="row mt-3 mx-auto px-auto">

<?php foreach ($posts as $aPost): ?>
    <div class="post col-lg-12 my-auto">
        <div class="row d-flex justify-content-between bg-dark text-light rounded-top">
            <p class="m-2 pt-1 pb-0"><span class="h4 text-warning font-italic"><?= htmlspecialchars($aPost->title())?></span> par : <?= htmlspecialchars($aPost->userPseudo())?>, le : <?= htmlspecialchars($aPost->date())?></p>
            <p class="badge badge-warning m-2 my-md-auto p-2"><?= htmlspecialchars($aPost->type())?></p>
        </div>
        <div class="row">
            <div class="post_content_overlay col-lg-12 p-0">
                <div class="px-3 py-1 post_content" ><?= $aPost->content()?></div>
            </div>
        </div>
    </div>
    <div class="row col-lg-3 ml-2 mt-3">
        <p class="col-lg-12"><a href="index.php?action=post&amp;id=<?= htmlspecialchars($aPost->id())?>" class="comment_btn btn btn-warning btn-sm font-weight-bold">Voir les commentaires</a></p>
    </div>

<?php endforeach; ?>


</div>
<?php if (isset($countPages) && $countPages > 1): ?>
    <?= $pagination ?>
<?php endif; ?>

<?php $content = ob_get_clean(); ?>
<?php
require('../view/navbar.php');
require('../view/backoffice/adminBar.php');
require('../view/template.php');
