# Groupe : Arthur Djikpo & Etienne Crespi & Aissatou Diop #TeamRocket

# Thème: 
[![CircleCI](https://circleci.com/gh/alborq/ipssi-sf-tp.svg?style=svg)](https://circleci.com/gh/alborq/ipssi-sf-tp) 

Création d'une platform de pari eu ligne

## Regles : 
  - Groupe de 3 Max
  - Le Projet doit être démarrable via 'make start' sur un docker
  - Un jeu de test (fixtures) doit être présent, couvrant l'ensemble du scope du projet
  - Le rendu se faire sur Github,
	- Une PR par groupe sur le dépot de base : https://github.com/alborq/ipssi-sf-tp ( Créer votre fork)
	- La PR doit être ouvert dés Lundi, Elle porte le nom des membres du groupe.
	- Je fais des review régulière sur les PR mis a jour régulièrement		
  - Créer le fichier suivant :
    - rendu_lib.txt :
       - Une ligne par dépendences dans le projet (basé sur le composer.json)
       - Pour chaque dépendences, Un fichier qui l'utilise + une description court de 'A quoi il VOUS sert.'


## Technologies : 
  - Symfony (pas de version full) 
  - Docker
  - Make
  - Boostwatch, théme au choix : https://bootswatch.com/ (Base bootstrap)
  - Libs a votre convenance. Sauf les lib Interdite : FOS User, Sonata****, 
  - CircleCI doit être configurer sur votre projet, et lancer les test de Code Style (Php CS, PhpStan niveau 6)
    - https://github.com/phpstan/phpstan
    - https://symfony.com/doc/current/contributing/code/standards.html  


## Fonctionnalité attendu : 
  - Une zone de blog
	  - Liste des articles paginé (10 par page)
	  - Consultation d'un article.
	  - Une zone de commentaire sous chaque article. (Nom de l'utilisateur, Date, message full text) 
	  - Un administrateur peut censuré (et dé-censuré) un commentaire (Il n'est plus visible pour les utilisateur sauf admin qui a un indicateur) 
	  - Un Flux RSS est mis a disposition. 

  - Gestion de compte: 
   - Possibilité de créer un compte Utilisateur - Email, Mot de passe, Niveau de droit(Standard ou Admin), Montant
    - mot de passe oublié
    - Login
    - Une liste des parti auquel le joueur a participé et ces gain/perte

  - Zone de jeu. 
    - Chaque joueur peut parier a la roulette (Même regle que sur le premier cours)
      - Une fois parié, le joueur a un récap de sont paris, les montant engagné, les gain potentiel, et le montant total de la table. 

	- Toutes les deux heures (Ou sous entend un CRON) la roulettes est lancer.
		- Les gains sont distribué au joueur
		- Un Article de blog est publié avec les résultat du tirage
		- Un Mail est envoyer a tout les joueurs avec leur résultat personnel

  -Zone admin ( sur `/admin/`)
  - Interface de gestion des compte utilisateur VIA EasyAdminBundle 
	- Zone de création d'article de blog en MarkDown via un editeur Markdown (https://github.com/KnpLabs/KnpMarkdownBundle, https://github.com/Grafikart/JS-Markdown-Editor)
		Un Article aura un Titre et une photo d'accroche
		On pourra réglé si les commentaire sont activé ou pas
		On pourra choisir la date et l'heure de parution

	- Dashboard 
		- les top articles par page vue. (soutent le comptage de 'page vue', (Nombre de fois que la page 'Consultation d'un article' est afficher)
		- Le montant actuel de la maison
		- Les top/flop joueurs (Montant les plus haut)
		- Les top/flop de la semaine (Plus de gain sur les 7 dernier jour)
		- Un Graph des 7 dernier jour avec le nombre de parti joué par demi journée (Graph en bar groupé par 2(AM, PM))
		- Un Graph des finances de la maison. 

- Bonus: 
	- Ajouter Stripe comme systeme de payement pour pouvoir remplir le compte de l'utilisateur
	- Ajouter Une page d'historique de transaction sur le profil du joueur

