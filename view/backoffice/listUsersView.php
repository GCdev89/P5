<?php ob_start(); ?>
<div class="col-12 mx-auto px-auto">
    <div class="row">
        <table class="table table-responsive-md table-striped table-dark">
            <thead>
                <th scope="col">Pseudo</th>
                <th scope="col">Role</th>
                <th scope="col">Mail</th>
                <th scope="col">Date de création</th>
                <th scope="col">Action</th>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user->pseudo()) ?></td>
                        <td><?= htmlspecialchars($user->role()) ?></td>
                        <td><?= htmlspecialchars($user->mail()) ?></td>
                        <td><?= htmlspecialchars($user->date()) ?></td>
                        <?php if ($user->role() != 'admin'): ?>
                        <td><a href="index.php?action=delete_user&amp;id=<?=htmlspecialchars($user->id())?>" class="btn btn-danger btn-sm">Supprimer</a></td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php if (isset($countPages) && $countPages > 1): ?>
        <?= $pagination ?>
    <?php endif; ?>
</div>
<?php $content = ob_get_clean(); ?>
<?php
require('../view/navbar.php');
require('../view/backoffice/adminBar.php');
require('../view/template.php');
