# api-client-generator

[![CircleCI](https://circleci.com/gh/Photocreate/api-client-generator.svg?style=svg)](https://circleci.com/gh/Photocreate/api-client-generator)
[![Coverage Status](https://coveralls.io/repos/github/Photocreate/api-client-generator/badge.svg?branch=master)](https://coveralls.io/github/Photocreate/api-client-generator?branch=master)

## What is api-client-generator?
This is a toolset to generate API client from Swagger specification.

## Support languages
Supported languages are as below.

- PHP

## Run example

### Clone project

```bash
$ git clone git@github.com:Photocreate/api-client-generator.git
$ cd api-client-generator
```

### Run docker

```bash
$ cd example/petstore
$ docker-compose up -d
```

### Access Swagger-UI

See http://localhost:8002/

### Generate API client

```bash
$ cd /path/to/project
$ bin/api-client-generator api:client:generate \
> --spec http://localhost:8002/v2/swagger.json \
> --output example/petstore/Petstore.php \
> --class Petstore --namespace "Example\Petstore"
```

### Run test.

```bash
$ cd /path/to/project
$ vendor/bin/phpunit -c . example/petstore/PetstoreTest.php
```
