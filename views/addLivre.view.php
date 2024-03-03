<?php

ob_start(); // Ouverture du buffer PHP pour mettre en temporisation du code pour plutard 

?>

<div class="row">
    <form action="<?= URL ?>livres/addvalid" method="post" enctype="multipart/form-data">
        <fieldset>
            <div class="mb-3">
                <label for="titre" class="form-label">Titre : </label>
                <input type="text" name="titre" id="titre" class="form-control">
            </div>
            <div class="mb-3">
                <label for="nbPages" class="form-label">Nombre de pages : </label>
                <input type="number" min="0" step="1" name="nbPages" id="nbPages" class="form-control">
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image : </label>
                <input type="file" name="image" id="image" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Valider</button>
        </fieldset>
    </form>
</div>

<?php
$content = ob_get_clean(); // Va déverser tout ce qui est dans la variable $content (entre ob_start() et ob_get_clean())
$titre = "Ajouter un livre";

require_once "template.php";
?>