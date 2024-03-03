<?php

require_once "models/LivreManager.class.php";

class LivresController
{
    private LivreManager $livreManager;

    public function __construct()
    {
        $this->livreManager = new LivreManager;
        $this->livreManager->loadLivres();
    }

    public function viewLivres(): void
    {
        $livres = $this->livreManager->getLivres();
        require "views/livres.view.php";
    }

    public function viewLivre(int $id): void
    {
        $livre = $this->livreManager->getLivreById($id);

        if ($livre !== null) {
            require "views/livre.view.php";
        } else {
            echo "Aucun livre trouvé avec l'id : {$id}";
        }
    }

    public function addLivre(): void
    {
        require "views/addLivre.view.php";
    }

    public function addLivreValidation(): void
    {
        $file = $_FILES['image'];
        $dir = "public/assets/images/";
        $addImageName = $this->addImage($file, $dir);
        $this->livreManager->addLivreBdd($_POST['titre'], $_POST['nbPages'], $addImageName);
        header('Location: ' . URL . "livres");
    }
    
    public function deleteLivre(int $id): void
    {
        $ImageName = $this->livreManager->getLivreById($id)->getImage();
        unlink("public/assets/images/{$ImageName}");
        $this->livreManager->deleteLivreBdd($id);
        header('Location: ' . URL . "livres");
    }

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
