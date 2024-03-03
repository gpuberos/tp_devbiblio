<?php 

require_once "controllers/LivresController.controller.php";
$livreController = new LivresController;

// Routeur
if (empty($_GET['page'])) {
    require_once "views/accueil.view.php";
} else {
    switch ($_GET['page']) {
        case 'accueil':
            require_once "views/accueil.view.php";
            break;
        case 'livres':
            $livreController->afficherLivres();
            break;
    }
}
