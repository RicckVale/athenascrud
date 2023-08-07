# ATHENAS CRUD - RESTFull API e CRUD

## Index

## About Repository<a name="about-repository"></a>

This repository is a project of a API RESTful with Laravel 8. 
The project is a CRUD of Clients. 

## Tech Specification <a name="tech-specification"></a>

- PHP 8.1
- Laravel 10
- MySQL 8
- Docker with Laravel Sail
- PHPUnit 10

## Features <a name="features"></a>

- Pessoas:
  - POST, PUT, PATCH, GET List with Pagination, GET with id, Delete
- Categorias:
  - POST, PUT, PATCH, GET List with Pagination, GET with id, Delete

## Install with Docker <a name="install-with-docker"></a>

- `docker-compose up -d`
- `docker exec -it api-tdd /bin/bash`
- `composer install`
- `cp .env.example .env`
- `php artisan key:generate`
- `php artisan migrate`
- `php artisan db:seed`
- `php artisan serve`
- Local http://localhost:8000/

## Unit Test <a name="unit-test"></a>

#### run PHPUnit in local <a name="run-phpunit-in-local"></a>

```bash
# run PHPUnit all test cases
vendor/bin/phpunit
# Feature test only
vendor/bin/phpunit --testsuite Feature
# Unit test only
vendor/bin/phpunit --testsuite Unit
```

### Postman Documentation <a name="postman-documentation"></a>

Access: [Athenas CRUD - Documentation Postman](https://documenter.getpostman.com/view/20890833/2s9XxztsD9)

### API Endpoints <a name="api-endpoints"></a>

- Pessoas:
  - POST
    - /api/pessoas
  - PUT
    - /api/pessoas/<id>
  - PATCH
    - /api/pessoas/<id>
  - GET List with Pagination
    - /api/pessoas
  - GET one
    - /api/pessoas/<id>
  - Delete
    - /api/pessoas/<id>
- Categorias:
  - POST
    - /api/categorias
  - PUT
    - /api/categorias/<id>
  - PATCH
    - /api/categorias/<id>
  - GET List with Pagination
    - /api/categorias
  - GET with id
    - /api/categorias/<id>
  - Delete
    - /api/categorias/<id>
