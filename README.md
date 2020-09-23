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

#### Créez une base de données localement

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

#### Créez votre compte sur le site de l'API
[ApiNews](https://newsapi.org/)
Afin de récupérer le token que vous mettrez dans votre .env.local.
Le nombre de requêtes est limité à 500 par utilisateur, par jour.

#### Créez votre .env.local avec:
``` env
DATABASE_URL=mysql://login_base_de_donnes:mot_de_passe@adresse_base_de_donnes/nom_base_de_donnes?serverVersion=5.7
JWT_PASSPHRASE=phrase_que_vous_avez_définie_précédemment
APINEWS_TOKEN=token_de_votre_compte
```

#### Créez les tables dans votre base de données
``` bash 
php app/console doctrine:migrations:migrate
```

#### Créez les fixtures dans la base de données
``` bash 
php bin/console doctrine:fixtures:load
```
</br>

#### Récupérez les vraies sources de l'API externe
``` bash
php bin/console app:fetch-sources
```

#### Récupérez les vrais articles de l'API externe
``` bash
php bin/console app:fetch-articles
``` 

## Récupérez la partie front de l'application
https://github.com/KellyGauthier/news-front
</br>  
