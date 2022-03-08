# COMMENT CONTRIBUER AU PROJET ?

## Rédiger des Issues
Veuillez soumettre vos rapports de bug ou propositions de nouvelles fonctionnalités dans la section [Issues](https://github.com/AEcalle/ToDoAndCo/issues)
Avant de créer une nouvelle issue, veuillez vérifier qu'elle n'existe pas déjà. Pensez également à mettre à jour l'issue tout au long du processus.

## Workflow
### Installer le projet en local
Référez-vous au [Readme](https://github.com/AEcalle/ToDoAndCo#readme) pour les instructions d'installation du projet en local. 

### Créer une nouvelle branche
Avec Git, créez une nouvelle branche à partir de la branche `develop`. Merci de respecter la convention de nommage suivante pour votre branche : feature/functionnality-name.

### Implémenter et Tester
Implémentez votre fonctionnalité et testez votre code avant de pousser votre nouvelle fonctionnalité sur Github. Vous pouvez lancer la commande suivante pour lancer une série de tests automatisés : 
```
$ ./vendor/bin/phpunit
```
Ne jamais proposer de pull request si le code n'est pas testé.

### Pull Request
Pousser votre branch sur le repository github du projet et crééez une pull request (PR). Eventuellement reliez votre PR à une ou plusieurs issues correspondantes. 

### Code review
Avant d'être accepté, votre PR fera l'objet d'une revue de code. Nous vérifierons notamment le respect des bonnes pratiques listées ci-dessous.

## Bonnes pratiques
### Outils d'analyse de code
Aidez-vous d'outils d'analyse de code pour respecter les bonnes pratiques. Il est notamment recommandé d'utiliser [PHPStan](https://phpstan.org/) et d'obtenir 0 erreur au niveau 9. En complément vous pouvez utiliser [PHP CS Fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer) qui vous aidera à corriger le style de votre code. Pour la partie front, n'hésitez pas utiliser des outils égalements comme [TwigCS](https://github.com/friendsoftwig/twigcs) afin de vérifier le style de vos fichiers Twig.

### Règles à respecter
* Appliquer le [PSR-12](https://www.php-fig.org/psr/psr-12/)
* Respecter les [bonne pratiques de Symfony](https://symfony.com/doc/current/best_practices.html)
* Principes SOLID [Cours Openclassrooms](https://openclassrooms.com/fr/courses/7415611-ecrivez-du-php-maintenable-avec-les-principes-solid-et-les-design-patterns)
