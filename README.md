# News Broadcaster


Cette application vous permet de suivre l'actualité en mettant à disposition les derniers articles de la presse écrite. Vous pouvez, en personnalisant votre profil, filtrer vos sources et/ou sujets favoris ainsi que programmer vos alertes.     
</br>

## Prérequis
Avant de continuer, assurez-vous de:

* avoir installé PHP
* utiliser composer et symfony
* lancer WAMP/MAMP/LAMP

#### Composer
``` bash
composer install
```

#### Démarrez le serveur avec symfony
``` bash
symfony server:start
```

#### Générer le JWT
``` bash 
mkdir -p config/jwt
```

##### Clé privée
``` bash 
openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096
```

##### Clé publique
``` bash 
openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout
```

#### Créer son compte sur le site de l'API
[ApiNews](https://newsapi.org/)
Afin de récupérer le token que vous mettrez dans votre .env.local

#### Créez votre .env.local avec:
``` env
DATABASE_URL
JWT
APINEWS_TOKEN
```

#### Créez votre base de données
``` bash 
php app/console doctrine:migrations:migrate
```

#### Créez les fixtures dans la base de données
``` bash 
php bin/console doctrine:fixtures:load
```
</br>

#### Récupérer les vraies sources de l'API externe
``` bash
php bin/console app:fetch-sources
```


## Récupérez les données via l'API: 
https://newsapi.org/
Le nombre de requêtes est limité à 500 par utilisateur, par jour.
</br>  

## Récupérez la partie front de l'application
https://github.com/KellyGauthier/news-front
</br>  

## Fonctionalités

### Afficher les favoris dans le news feed principal

![news](images/screenshot.png "news feed favoris")

Si l'utilisateur possède un compte, il lui est possible de selectionner son news feed principal en choisissant d'afficher soit les articles relatifs à ses favoris, soit le news feed par défaut.


