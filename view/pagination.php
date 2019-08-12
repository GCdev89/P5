<?php ob_start(); ?>

<div class="row col-12 mx-auto my-3">
    <nav class="mx-auto">
        <ul class="pagination mx-auto">
            <?php
            for($i = 1; $i <= $countPages; $i++) {
                if ($i == $currentPage) {
                    echo '<li class="page-item active"><a class="page-link bg-dark border-dark text-warning" href="index.php?action='. $action .'&amp;page=' .$i.'">'. $i . ' </a></li>';
                }
                else {
                    echo '<li class="page-item"><a class="page-link bg-light text-dark" href="index.php?action='. $action .'&amp;page=' .$i.'">'. $i . ' </a></li>';
                }
            }
            ?>
        </ul>
    </nav>
</div>

<?php $pagination = ob_get_clean(); ?>
