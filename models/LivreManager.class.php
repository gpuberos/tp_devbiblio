<?php

// Inclusion des classes Model & Livre
require_once "Model.class.php";
require_once "Livre.class.php";

// Définition de la classe LivreManager qui hérite de la classe Model
class LivreManager extends Model
{
    // Déclaration d'une propriété privée pour stocker une liste de livres (tableau)
    private array $listeLivres = [];

    // Méthode pour ajouter un livre à la liste (attend un objet de la classe Livre comme argument)
    public function addLivre(Livre $livre): void
    {
        // Ajout du livre passé en paramètre à la liste des livres
        $this->listeLivres[] = $livre;
    }

    // Méthode pour obtenir la liste des livres
    public function getLivres(): array
    {
        // Retourne la liste des livres
        return $this->listeLivres;
    }

    // Méthode pour charger les livres depuis la base de données
    public function loadLivres(): void
    {
        // Préparation de la requête SQL pour sélectionner tous les livres
        $req = $this->getBdd()->prepare("SELECT * FROM livres");
        // Exécution de la requête
        $req->execute();
        // Récupération de tous les livres sous forme d'un tableau associatif
        $livresDepuisBDD = $req->fetchAll(PDO::FETCH_ASSOC);
        // Fermeture du curseur de la requête
        $req->closeCursor();

        // Parcours de chaque livre récupéré depuis la base de données
        foreach ($livresDepuisBDD as $livre) {
            // Création d'un nouvel objet Livre avec les informations du livre
            $newLivre = new Livre($livre['id'], $livre['titre'], $livre['nbPages'], $livre['image']);
            // Ajout du nouvel objet Livre à la liste des livres
            $this->addLivre($newLivre);
        }
    }

    // Méthode pour obtenir un livre par son id (retourne soit un objet de Livre ou null)
    public function getLivreById(int $id): ?Livre
    {
        // Parcourir chaque livre dans la liste des livres
        foreach ($this->listeLivres as $livre) {
            // Si l'ID du livre correspond à l'ID recherché
            if ($livre->getId() === $id) {
                // Retourner le livre correspondant
                return $livre;
            }
        }
        // S'il n'existe pas retourne null
        return null;
    }

    public function addLivreBdd(string $titre, int $nbPages, string $image): void
    {
        $req = "INSERT INTO livres (`titre`, `nbPages`, `image`)
        VALUES (:titre, :nbPages, :image)";
        $sth = $this->getBdd()->prepare($req);
        $sth->bindValue(":titre", $titre, PDO::PARAM_STR);
        $sth->bindValue(":nbPages", $nbPages, PDO::PARAM_INT);
        $sth->bindValue(":image", $image, PDO::PARAM_STR);
        $result = $sth->execute();
        $sth->closeCursor();

        if ($result > 0) {
            $id = $this->getBdd()->lastInsertId();
            $livre = new Livre($id, $titre, $nbPages, $image);
            $this->addLivre($livre);
        } else {
            throw new Exception("L'ajout du livre à la base de données a échoué");
        }
    }

    public function deleteLivreBdd(int $id): void
    {
        $req = "DELETE FROM livres WHERE id = :idLivre";
        $sth = $this->getBdd()->prepare($req);
        $sth->bindValue(":idLivre", $id, PDO::PARAM_INT);
        $result = $sth->execute();
        $sth->closeCursor();

        if ($result > 0) {
            $livre = $this->getLivreById($id);
            // Unset prend une variable en paramètre et non une valeur
            unset($livre);
        } else {
            throw new Exception("La suppression du livre de la base de données a échoué");
        }
    }
}
