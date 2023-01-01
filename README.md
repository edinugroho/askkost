## About askkost

askkost is a backend service which build with Laravel v.8.x for serving kost data. this service provide authentication to secure between users role.

## ERD

![erd](/erd.png)

## Prerequisites 

- Composer ^v2.5.1
- MySQL ^v15.1
- PHP ^v7.3.1
- Xdebug ^v3.1.6 (extension for generate code coverage)

    > For eaisily develop on you can use [xampp](https://www.apachefriends.org/download.html)


## How to install

- open terminal and clone this repo

    ```
    git clone git@github.com:edinugroho/askkost.git
    ```

    go to inside directory

    ```
    cd askkost
    ```

- install dependency
    
    ```
    composer install
    ```

- setup database
  
    > this project is build with unit test too. so, if you want to run the unit test you should setup 2 database for test and for production.

    create database
    
    ```
    CREATE DATABASE <database_name>
    ```

    fill `<database_name>` with name what you want spesify.

- setup .env

    > env separated with 2 environment (for test and production)

    to create .env just copy `.env.example` with this following command

    ```
    cp .env.example .env
    ```
    to test environment you should create new copy of `.env` file with name `.env.test`
    
    ```
    cp .env.example .env.test
    ```
    >you can update your `.env` and `env.test` as you want.

- migrate the table

    ```
    php artisan migrate
    ```

## How to run test

- with artisan
   
    ```
    php artisan test
    ```
- with generated code coverage

    ```
    vendor/bin/phpunit --coverage-html reports/
    ```
    > code coverage will generate as html format and can seen in the browser, the file is saved in `/reports/dashboard.html`

## Scheduler

command to run task scheduler in this project

```
php artisan schedule:run
```

to mannualy resets user credits you can run artisan comand

```
php artisan reset:credits
```
> for run on the server you should add cronjob

## Postman resource

[Api Docs](https://documenter.getpostman.com/view/1001255/2s8Z6zyriU)