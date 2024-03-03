<?php ob_start(); // Ouverture du buffer PHP pour mettre en temporisation du code pour plutard 
?>

<div class="row">
    <table class="table text-center">
        <thead class="table-dark">
            <tr>
                <th>Couverture</th>
                <th>Titre</th>
                <th>Nombre de pages</th>
                <th colspan="2">Actions</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($livres as $livre) : ?>
                <tr>
                    <td class="align-middle"><img src="<?= URL ?>/public/assets/images/<?= $livre->getImage() ?>" width="120" height="120" alt="Couverture <?= $livre->getTitre()  ?>"></td>
                    <td class="align-middle"><a href="<?= URL ?>/livres/details/<?= $livre->getId() ?>"><?= $livre->getTitre() ?></a></td>
                    <td class="align-middle"><?= $livre->getNbPages() ?></td>
                    <td class="align-middle"><a href="#" class="btn btn-warning">Modifier</a></td>
                    <td class="align-middle"><a href="#" class="btn btn-danger">Supprimer</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="m-2 p-2">
        <a class="btn btn-success d-block" href="#">Ajouter</a>
    </div>
</div>

<?php

$content = ob_get_clean(); // Va déverser tout ce qui est entre ob_start() et ob_get_clean()
$titre = "Nos livres";

require_once "template.php";

?>