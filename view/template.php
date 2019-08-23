<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <title>Projet 5</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="tinymce/tinymce.js" referrerpolicy="origin"></script>
        <script>
        tinymce.init({
            language : "fr_FR",
            selector: '#content'
        });
        </script>

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../public/css/styleMain.css" rel="stylesheet" />
    </head>

    <body>

        <?= $nav ?>

        <div class="container-fluid mb-5">
            <div class="row">
                <div class="jumbotron mx-auto mt-4 px-auto">
                    <div class="container">
                        <h1 class="display-5  font-italic "><a href="index.php" class="text-warning text-decoration-none"><img id="main_logo" class="img-fluid" src="../public/images/logo/x1.png" /></a></h1>
                    </div>
                </div>
                <div class="row col-lg-12 mx-0 px-0 mx-md-auto">
                    <div class="col-lg-8 mx-0 mx-md-auto mb-2">
                            <?= $content ?>
                    </div>
                </div>
            </div>
        </div>
        <?php if (isset($_SESSION['role'])): ?>
            <?php if ($_SESSION['role'] == 'admin' OR $_SESSION['role'] == 'editor' OR $_SESSION['role'] == 'writer' OR $_SESSION['role'] == 'moderator'): ?>
                <?= $adminBar ?>
            <?php endif; ?>
        <?php endif; ?>


        <?php if (isset($controlScript)) {
            echo $controlScript;
        } ?>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    </body>
</html>
