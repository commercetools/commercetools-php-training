Commercetools PHP training repository
=========

This project aims to get a quick intro to the Commercetools Platform.

https://github.com/commercetools/commercetools-php-training

Setup project:
```bash
composer install
```

Running Training tests:
```bash
env $(cat parameters.env | xargs) vendor/bin/phpunit
```

### Docker

Setup:
```bash
docker run --rm -v${PWD}:/app -w /app jenschude/php-test-base composer install
```

Running Training tests:
```bash
docker-compose up
```
or
```bash
docker run --rm  --env-file parameters.env -v${PWD}:/app -w /app jenschude/php-test-base vendor/bin/phpunit
```

### Vagrant

Setup and starting the application:
```bash
vagrant up
```

Running Training tests:
```bash
vagrant ssh -c 'cd training; env $(cat parameters.env | xargs) vendor/bin/phpunit'
```

### PhpStorm Configuration

```
Languages > Frameworks > PHP : Select CLI interpreter
```

#### Local
```
Languages > Frameworks > PHP > Testframeworks :

Add local entry for PHPUnit: Use composer autoloader
Default configuration file: phpunit.xml.dist

```

#### Vagrant

```
Languages > Frameworks > PHP > Testframeworks :

Add remote entry for PHPUnit: Use composer autoloader
Default configuration file: phpunit.xml.dist

```


```
Run/Debug Configurations
Add PHPUnit entry: defined in the configuration file
```
