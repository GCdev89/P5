<?php ob_start(); ?>
<div class="row col-12 mx-auto px-auto">
    <div class="row col-12 mt-4">
        <p><a href="index.php?action=post&amp;id=<?= htmlspecialchars($comment->postId()); ?>">Retour au billet</a></p>
        <form action="index.php?action=comment_updated&amp;id=<?= htmlspecialchars($comment->postId()); ?>&amp;id_comment=<?= $comment->id(); ?>" method="post" class="col-12 mx-auto mb-5 p-auto bg-light">
            <div class="form-group" >
                <label for="title">Titre du commentaire</label><br />
                <input type="text" id="title" name="title" value="<?= htmlspecialchars($comment->title()); ?>" class="form-control" />
            </div>
            <div class="form-group">
                <label for="content">Commentaire</label><br />
                <textarea id="content" name="content" class="form-control"><?= $comment->content(); ?></textarea>
            </div>
            <div class="form-group d-flex justify-content-around mb-2">
                <button type="submit" class="btn btn-primary">Envoyer</button>
                <a href="index.php?action=delete_comment&amp;id=<?= $comment->id()?>" class="btn btn-danger">Supprimer</a>
            </div>
        </form>
    </div>
</div>

<?php $content = ob_get_clean(); ?>
<?php
require('../view/navbar.php');
require('../view/backoffice/adminBar.php');
require('../view/template.php');
