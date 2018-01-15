Commercetools PHP training repository
=========

This project aims to get a quick intro to the Commercetools Platform.
To achieve this the project uses a preconfigured Symfony 3.2 application with the Commercetools Symfony Bundle.

https://github.com/commercetools/commercetools-php-training

Setup project:

```bash
composer install
```
Start the application
```bash
env $(cat parameters.env | xargs) bin/console server:run
```

Open in browser

[http://localhost:8000/training](http://localhost:8000/training)

Running Training tests:

```bash
vendor/bin/phpunit
```

### Docker

Setup:
```bash
docker run --rm -v${PWD}:/app -w /app jaysde/php-test-base composer install
```

Start the application
```bash
docker-compose up
```

### Vagrant

Setup:
```bash
composer install
```

Start the application:
```bash
vagrant up
```

### PhpStorm Configuration

```
Languages > Frameworks > PHP : Select CLI interpreter
```

```
Languages > Frameworks > PHP > Testframeworks :

Add local entry for PHPUnit: Use composer autoloader
Default configuration file: phpunit.xml.dist

```

```
Run/Debug Configurations
Add PHPUnit entry: defined in the configuration file
```
