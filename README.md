# Création d'une bibliothèque pour développeurs

## MVC : Modèle Vue Controlleur

L'architecture MVC va permettre de séparer les parties de l'application en plusieurs morceaux.

Elle se décompose en 3 parties :
- Modèle : correspond à la partie des données
- Vue : correspond à la partie affichage
- Contrôleur : correspond à la partie pilotage

Avantages :
- Meilleur sécurisation du code
- Maintenabilité améliorée
- Cohérence globale de l'application entre les données et les traitements

Le site n'aura plus qu'une seule page : la page index.php.
Les contrôleurs vont assembler les morceaux des pages qui seront ensuite toujours affiché sur cette même URL index.php.
> [!IMPORTANT] 
> Il n'y a aucun lien entre les vues et les modèles c'est le contrôleur qui met en place la cohérence entre la partie data (modèle) et la partie affichage (Vue).

Dans le cadre des sites internet on ajoute ensuite l'aspect Routage. Quand un utilisateur veut accéder à une ressource il en fera la demande via une URL. Le routeur va permettre de récupérer cette demande de l'utilisateur et va router vers le bon canal mise à disposition dans le code serveur. Ce fichier ne fera que ça, notre routeur sera le fichier index.php.