# News Broadcaster


Cette application vous permet de suivre l'actualité en mettant à disposition les derniers articles de la presse écrite. Vous pouvez, en personnalisant votre profil, filtrer vos sources et/ou sujets favoris ainsi que programmer vos alertes.     
</br>

## Prérequis
Avant de continuer, assurez-vous de:

* avoir installer PHP
* utiliser composer et symfony

Composer
``` bash
composer install
```
Démarrez le serveur avec symfony
``` bash
symfony server:start
```
</br>

Créez votre .env.local avec:
``` env
DATABASE_URL
JWT
```

Créez votre base de données
``` bash 
php app/console doctrine:migrations:migrate
```

Créez une entité dans la base de données
``` bash 
php bin/console doctrine:fixtures:load
```
</br>

## Récupérez les données via l'API: 
https://newsapi.org/
Le nombre de requêtes est limité à 500 par utilisateur, par jour.
</br>

## Fonctionalités

### Afficher les favoris dans le news feed principal

![news](images/screenshot.png "news feed favoris")

Il est possible de selectionner son news feed principal en choisissant d'afficher soit les articles relatifs aux favoris de l'utilisateur, soit le news feed par défaut.


