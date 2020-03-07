# xiaopay
An DEMO project

## API Document:

https://kingshark.gitbook.io/xiaopay-api-document/


## Design

- tech stack: via Laravel 7.0 (use PHP7.2) + MySql 5.7 + Nginx.

- follow REST API conventions.

- layers: routes -> controller -> service -> data transform (api resource).

- users, accounts table's id use compressed uuid instead of auto-increment id, to avoid db id exposure.

- validations to ensure data correction.

- there is a centralized error handler class at `app/Exceptions/Handler.php`. Robust error handling, with different error_code, error_message, http_staus_code to help finding where goes wrong.

- including unit tests and feature tests (API test) 

- use docker to deploy.

- ~IMPORTANT sensitive deploy config are using `.env` and not put on git.


## Install And Usage

> @[xiaopay home] means at xiaopay project home path.

### Prerequisite 

- installed docker and docker-compose

### First time execute

- edit `docker-config/{php|mysql|nginx}/*` based on different env.

> MUST config `docker-config/mysql/.env`, refer to `docker-config/mysql/.env.example`

- set Laravel `.env` file:

@[xiaopay home], run `cp src/.env.example src/.env`. then edit `.env` file.

> DB setting should match docker's settings, e.g host(mysql), port(3306, not external port!), username, password

- other init 

@[xiaopay home], execute

`sudo chmod 777 -R src/storage/`

`sudo chmod 777 -R src/bootstrap/cache/`

`sudo docker run --rm -v $(pwd)/src:/app composer install`

- launch docker containers

@[xiaopay home], execute

`docker-compose up -d`

`docker-compose exec app php artisan key:generate`

- migrate

@[xiaopay home], execute

`docker-compose exec app php artisan migrate`

- (optional) seed for local or testing env

`docker-compose exec app php artisan db:seed`

- All done

you can request to api root GET `http://0.0.0.0:8080/api/v1`. if has

```
{"message":"welcome to access XiaoPay API (v1)."}
```

 with 200 http status code, then all setup succeed.


## Testing

run `docker-compose exec app php artisan test`