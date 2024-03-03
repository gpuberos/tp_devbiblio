<?php ob_start(); // Ouverture du buffer PHP pour mettre en temporisation du code pour plutard ?>

<div class="row">
    <form action="<?= URL ?>livres/updatevalid" method="post" enctype="multipart/form-data">
        <fieldset>

            <div class="mb-3">
                <label for="titre" class="form-label">Titre : </label>
                <input type="text" name="titre" value="<?= $livre->getTitre() ?>" id="titre" class="form-control">
            </div>
            <div class="mb-3">
                <label for="nbPages" class="form-label">Nombre de pages : </label>
                <input type="number" min="0" step="1" name="nbPages" value="<?= $livre->getNbPages() ?>" id="nbPages" class="form-control">
            </div>
            <div class="mb-3">
                <div class="card px-0 border border-light-subtle">
                    <div class="row flex-md-row-reverse">
                        <div class="col-auto">
                            <img src="<?= URL ?>/public/assets/images/<?= $livre->getImage() ?>" class="img-fluid rounded-end" alt="Couverture de <?= $livre->getTitre() ?>" />
                        </div>
                        <div class="col">
                            <div class="card-body">
                                <label for="image" class="form-label">Changer l'image : </label>
                                <input type="file" name="image" id="image" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <input type="hidden" name="idLivre" value="<?= $livre->getId() ?>">
            <button type="submit" class="btn btn-primary">Valider</button>
        </fieldset>
    </form>
</div>

<?php
$content = ob_get_clean(); // Va déverser tout ce qui est dans la variable $content (entre ob_start() et ob_get_clean())
$titre = "Modification du livre : {$livre->getId()}";

require_once "template.php";
?>