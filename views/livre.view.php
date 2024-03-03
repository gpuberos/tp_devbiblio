<?php ob_start(); // Ouverture du buffer PHP pour mettre en temporisation du code pour plutard 
?>
<div class="row">
    <div class="card mb-3">
        <div class="row g-0">
            <div class="col-md-4">
                <img src="<?= URL ?>/public/assets/images/<?= $livre->getImage() ?>" class="img-fluid rounded-start" alt="Couverture du livre <?= $livre->getTitre() ?>">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <p class="card-title">Titre : <?= $livre->getTitre() ?></p>
                    <p class="card-text">Nombres de pages : <?= $livre->getNbPages() ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

$content = ob_get_clean(); // Va déverser tout ce qui est entre ob_start() et ob_get_clean()
$titre = $livre->getTitre();

require_once "template.php";

?>