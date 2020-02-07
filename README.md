Lorsque vous clonez le projet, faites un: ```composer install```.

Dans la ligne 28, changer le ```db_user``` et le ```db_password``` par votre nom de connexion sur MySql, et changer ```db_name``` par le nom de la base de donnée que vous voulez.

Lorsque vous avez la configuration, tapez dans la commande: ```php bin/console doctrine:database:create``` il vous permettra de créer la base de donnée sur votre MySql.

Pour les migrations, faites un ```php bin/console make:migration```, puis un ```php bin/console doctrine:migrations:migrate```.

Pour la partie JWT, allez sur la doc de [JWT](https://github.com/lexik/LexikJWTAuthenticationBundle/blob/master/Resources/doc/index.md#generate-the-ssh-keys).

Pour démarrer le projet, tapez ```php bin/console server:run```

Maintenant enjoy ;)
