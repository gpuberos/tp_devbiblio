<?php

require_once "models/LivreManager.class.php";

class LivresController
{
    private LivreManager $livreManager; // Gestionnaire de livres

    public function __construct()
    {
        // Création d'une nouvelle instance de LivreManager
        $this->livreManager = new LivreManager;
         // Chargement des livres
        $this->livreManager->loadLivres();
    }

    // Méthode pour afficher les livres
    public function viewLivres(): void
    {
        // Récupération des livres
        $livres = $this->livreManager->getLivres();
        // Affichage de la vue des livres
        require_once "views/livres.view.php";
    }

    // Méthode pour afficher un livre
    public function viewLivre(int $id): void
    {
        // Récupération du livre par son id
        $livre = $this->livreManager->getLivreById($id);
        // Affichage de la vue du livre
        require_once "views/livre.view.php";
    }

    // Méthode pour ajouter un livre
    public function addLivre(): void
    {
        // Affichage de la vue pour ajouter un livre
        require_once "views/addLivre.view.php";
    }

    // Méthode pour valider l'ajout d'un livre
    public function addLivreValidation(): void
    {
        // Récupération de l'image du livre
        $file = $_FILES['image'];
        $dir = "public/assets/images/";
        $addImageName = $this->addImage($file, $dir);
        // Ajout du livre à la base de données
        $this->livreManager->addLivreBdd($_POST['titre'], $_POST['nbPages'], $addImageName);

        // Création d'une alerte de succès
        $_SESSION['alert'] = [
            "type" => "success",
            "msg" => "Ajout réalisée avec succès"
        ];

        // Redirection vers la page des livres
        header('Location: ' . URL . "livres");
    }

    // Méthode pour supprimer un livre
    public function deleteLivre(int $id): void
    {
        // Récupération de l'image du livre
        $ImageName = $this->livreManager->getLivreById($id)->getImage();
        // Suppression de l'image du livre
        unlink("public/assets/images/{$ImageName}");
        // Suppression du livre de la base de données
        $this->livreManager->deleteLivreBdd($id);

        // Création d'une alerte de succès
        $_SESSION['alert'] = [
            "type" => "success",
            "msg" => "Suppression réalisée avec succès"
        ];

        // Redirection vers la page des livres
        header('Location: ' . URL . "livres");
    }

    // Méthode pour mettre à jour un livre
    public function updateLivre(int $id): void
    {
        // Récupération du livre par son id
        $livre = $this->livreManager->getLivreById($id);
        // Affichage de la vue pour mettre à jour un livre
        require_once "views/updateLivre.view.php";
    }

    // Méthode pour valider la mise à jour d'un livre
    public function updateLivreValidation(): void
    {
        // Récupération de l'image actuelle du livre
        $currentImage = $this->livreManager->getLivreById($_POST['idLivre'])->getImage();
        // Récupération de la nouvelle image du livre
        $newFile = $_FILES['image'];

        // Si une nouvelle image a été téléchargée
        if($newFile['size'] > 0) {
            // Suppression de l'image actuelle
            unlink("public/assets/images/{$currentImage}");
            $dir = "public/assets/images/";
            // Ajout de la nouvelle image
            $imageNameToAdd = $this->addImage($newFile, $dir);
        } else {
            // Si aucune nouvelle image n'a été téléchargée, conserver l'image actuelle
            $imageNameToAdd = $currentImage;
        }
        
        // Mise à jour du livre dans la base de données
        $this->livreManager->updateLivreBdd($_POST['idLivre'], $_POST['titre'], $_POST['nbPages'], $imageNameToAdd);

        // Création d'une alerte de succès
        $_SESSION['alert'] = [
            "type" => "success",
            "msg" => "La mise à jour a été réalisée avec succès"
        ];

        // Redirection vers la page des livres
        header('Location: ' . URL . "livres");
    }

    // Méthode pour ajouter une image
    private function addImage(array $file, string $dir): string
    {
        // Vérifie si le nom du fichier est défini et non vide
        if (!isset($file['name']) || empty($file['name']))
            throw new Exception("Vous devez indiquer une image");
        // Si le répertoire n'existe pas, le crée
        if (!file_exists($dir)) mkdir($dir, 0777);

        // Récupère l'extension du fichier
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        // Génère un identifiant unique
        $random = uniqid();
        // Construit le chemin du fichier cible
        $target_file = $dir . $random . "-" . $file['name'];

        // Vérifie si le fichier est une image
        if (!getimagesize($file["tmp_name"]))
            throw new Exception("Le fichier n'est pas une image");
        // Vérifie si l'extension du fichier est reconnue
        if ($extension !== "jpg" && $extension !== "jpeg" && $extension !== "webp" && $extension !== "png" && $extension !== "gif")
            throw new Exception("L'extension du fichier n'est pas reconnu");
        // Vérifie si le fichier existe déjà
        if (file_exists($target_file))
            throw new Exception("Le fichier existe déjà");
        // Vérifie si la taille du fichier est supérieure à 500000
        if ($file['size'] > 500000)
            throw new Exception("Le fichier est trop gros");
        // Déplace le fichier téléchargé vers le répertoire cible
        if (!move_uploaded_file($file['tmp_name'], $target_file))
            throw new Exception("l'ajout de l'image n'a pas fonctionné");
        // Si tout se passe bien, retourne le nom du fichier
        else return ($random . "-" . $file['name']);
    }
}
