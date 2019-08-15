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
                        <td>
                            <?php if ($user->role() != 'admin'): ?>
                                <form class="form-inline" action="index.php?action=update_role" method="post">
                                    <input id="user_id" name="user_id" type="hidden" value="<?= htmlspecialchars($user->id()) ?>"/>
                                    <select name="role" id="role" class="form-control">
                                        <option value="<?= htmlspecialchars($user->role())?>" selected="selected"><?= htmlspecialchars($user->role())?></option>
                                        <option value="common_user">Utilisateur</option>
                                        <option value="writer">Rédacteur</option>
                                        <option value="editor">Editorialiste</option>
                                        <option value="moderator">Modérateur</option>
                                    </select>
                                    <button class="btn btn-success ml-2 mb-2 mb-lg-0" type="submit">Valider</button>
                                </form>
                            <?php endif; ?>
                        </td>
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
