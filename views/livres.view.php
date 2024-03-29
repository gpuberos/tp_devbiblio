<?php
ob_start(); // Ouverture du buffer PHP pour mettre en temporisation du code pour plutard

// Vérifie si la session 'alert' n'est pas vide
if (!empty($_SESSION['alert'])) :
?>

    <div class="row">
        <div class="alert alert-<?= $_SESSION['alert']['type'] ?>" role="alert">
            <?= $_SESSION['alert']['msg'] ?>
        </div>
    </div>

<?php
    // Supprime la session 'alert' après l'affichage du message
    unset($_SESSION['alert']);
endif;
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
                    <td class="align-middle"><a href="<?= URL ?>livres/update/<?= $livre->getId() ?>" class="btn btn-warning">Modifier</a></td>
                    <td class="align-middle">
                        <form action="<?= URL ?>livres/delete/<?= $livre->getId() ?>" method="post" onSubmit="return confirm('Voulez-vous vraiment supprimer ce livre ?')">
                            <button type="submit" class="btn btn-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="m-2 p-2">
        <a class="btn btn-success d-block" href="<?= URL ?>livres/add">Ajouter</a>
    </div>
</div>

<?php

$content = ob_get_clean(); // Va déverser tout ce qui est entre ob_start() et ob_get_clean()
$titre = "Nos livres";

require_once "template.php";

?>