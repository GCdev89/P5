<?php ob_start(); ?>
<div class="row col-12 mx-auto px-0">
    <div class="col-12 mx-auto my-2 bg-dark text-light">
        <p>Commentaires à modérer  <span class="badge badge-warning"><?= $reportCount ?></span></p>
    </div>
    <table class="table table-responsive-md table-striped table-dark">
        <thead>
            <th scope="col">Auteur</th>
            <th scope="col">Titre du commentaire</th>
            <th scope="col">Contenu</th>
            <th scope="col">Date de création</th>
            <th scope="col">Signalements</th>
        </thead>
        <tbody>
            <?php if (!empty($comments)): ?>
                <?php foreach ($comments as $aComment): ?>
                    <tr>
                        <td><?=htmlspecialchars($aComment->userPseudo())?></td>
                        <td><?=htmlspecialchars($aComment->title())?></td>
                        <td><?=$aComment->content()?></td>
                        <td><?=htmlspecialchars($aComment->date())?></td>
                        <td><span class="badge badge-warning"><?=htmlspecialchars($aComment->report())?></span></td>
                        <td><a href="index.php?action=ignore&amp;id=<?=htmlspecialchars($aComment->id())?>" class="btn btn-primary btn-sm">Ignorer</a></td>
                        <td><a href="index.php?action=delete_reported&amp;id=<?=htmlspecialchars($aComment->id())?>" class="btn btn-danger btn-sm">Supprimer</a></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    <?php if (isset($countPages) && $countPages > 1): ?>
        <?= $pagination ?>
    <?php endif; ?>
</div>
<?php $content = ob_get_clean(); ?>
<?php
require('../view/navbar.php');
require('../view/backoffice/adminBar.php');
require('../view/template.php');
