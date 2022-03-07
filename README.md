# ToDoList
  
Work carried out as part of the training course "Application Developer - PHP / Symfony" on OpenClassrooms.  

## Table of Contents
1.  __[Prerequisite](#prerequisite)__
2.  __[Installation](#installation)__
  * [Clone](#clone)
  * [Configure environment variables](#configure-environment-variables)
  * [Install the project](#install-the-project)
  * [Create the database](#create-the-database)
3.  __[Tests](#tests)__
  * [Database](#database)
  * [Run the tests](#run-the-tests)
4. __[Contribution](#contribution)__

---
## PREREQUISITE

* PHP >= 8.0.2
* Apache 2.4
* A database management system (ex MYSQL)
* Composer

This application is built on Symfony 6.0.

See more information on technical requirements in the [Symfony official documentation](https://symfony.com/doc/current/setup.html#technical-requirements).

---
## INSTALLATION

### __Clone__
Copy project on your system
```
git clone https://github.com/AEcalle/ToDoAndCo.git
```

### __Configure environment variables__
Create env.local file and configure DATABASE_URL
```env.local
DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=5.7"
```

### __Install the project__
Run these commands in your project's directory
```
$ composer install
$ npm install
$ npm run build
```

### __Create the database__
Run these commands

```
$ php bin/console doctrine:database:create

$ php bin/console doctrine:schema:update -f

$ php bin/console doctrine:fixtures:load -n
```
Your database should be updated with fake tasks and users.

---
## TESTS

### __Database__
Create env.test.local file and configure DATABASE_URL
```env.test.local
DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=5.7"
```
Run these commands
```
$ php bin/console doctrine:database:create --env=test

$ php bin/console doctrine:schema:update -f --env=test

$ php bin/console doctrine:fixtures:load -n --env=test
```

```
### __Run the tests__
To run all tests, use the following command:
```
$ ./vendor/bin/phpunit
```
---
## CONTRIBUTION

See [Contributing file](CONTRIB.md).