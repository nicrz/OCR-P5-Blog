# Installation

## Contexte
Ça y est, vous avez sauté le pas ! Le monde du développement web avec PHP est à portée de main et vous avez besoin de visibilité pour pouvoir convaincre vos futurs employeurs/clients en un seul regard. Vous êtes développeur PHP, il est donc temps de montrer vos talents au travers d’un blog à vos couleurs.

## Description du besoin
Le projet est donc de développer votre blog professionnel. Ce site web se décompose en deux grands groupes de pages :

les pages utiles à tous les visiteurs ;
les pages permettant d’administrer votre blog.
Voici la liste des pages qui devront être accessibles depuis votre site web :

la page d'accueil ;
la page listant l’ensemble des blog posts ;
la page affichant un blog post ;
la page permettant d’ajouter un blog post ;
la page permettant de modifier un blog post ;
les pages permettant de modifier/supprimer un blog post ;
les pages de connexion/enregistrement des utilisateurs.
Vous développerez une partie administration qui devra être accessible uniquement aux utilisateurs inscrits et validés.

Les pages d’administration seront donc accessibles sur conditions et vous veillerez à la sécurité de la partie administration.

Commençons par les pages utiles à tous les internautes.

Sur la page d’accueil, il faudra présenter les informations suivantes :

votre nom et votre prénom ;
une photo et/ou un logo ;
une phrase d’accroche qui vous ressemble (exemple : “Martin Durand, le développeur qu’il vous faut !”) ;
un menu permettant de naviguer parmi l’ensemble des pages de votre site web ;
un formulaire de contact (à la soumission de ce formulaire, un e-mail avec toutes ces informations vous sera envoyé) avec les champs suivants :
nom/prénom,
e-mail de contact,
message,
un lien vers votre CV au format PDF ;
et l’ensemble des liens vers les réseaux sociaux où l’on peut vous suivre (GitHub, LinkedIn, Twitter…).
Sur la page listant tous les blogs posts (du plus récent au plus ancien), il faut afficher les informations suivantes pour chaque blog post :

le titre ;
la date de dernière modification ;
le châpo ;
et un lien vers le blog post.
Sur la page présentant le détail d’un blog post, il faut afficher les informations suivantes :

le titre ;
le chapô ;
le contenu ;
l’auteur ;
la date de dernière mise à jour ;
le formulaire permettant d’ajouter un commentaire (soumis pour validation) ;
les listes des commentaires validés et publiés.
Sur la page permettant de modifier un blog post, l’utilisateur a la possibilité de modifier les champs titre, chapô, auteur et contenu.

Dans le footer menu, il doit figurer un lien pour accéder à l’administration du blog.

## Identifiants administrateur
- ruiz.nico64@gmail.com
- Test64170

## Configuration nécessaire
- Serveur web local ou en ligne
- Système de gestion de base de données relationnelle MySQL

## Instructions d'installation

##### 1/ Importez les fichiers du projet dans votre serveur local
##### 2/ Installez Composer
##### 3/ Exécutez la commande "composer install" dans votre CLI pour charger toutes les dépendances du projet
##### 4/ Créez une base de donnée dans PHPMyAdmin puis importez le fichier "blog-p5.sql"
##### 5/ Renseignez les informations de votre base de donnée dans le fichier engine/config.php
##### 6/ Renseignez l'adresse racine de votre site dans le fichier controller/MainController.php à la ligne 31 :
![image](https://user-images.githubusercontent.com/65675067/147918367-a220af23-261f-494f-a7d3-57590254ea96.png)

