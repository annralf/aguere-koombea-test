# aguere-koombea-test
Evaluate technical knowledge, use of good practices, and creativity when facing development problems. Good use of databases and testing will be taken into consideration. The tasks will be presented in the form of user stories to facilitate the understanding of the exercise.

# Contact Importer Test

## Features

- Upload CSV File to S3 bucket
- CSV file validation
- User registration

## Tech

- [Laravel 8] - API implementation
- [MySQL 8] - Database engine
- [Heroku ] - API/Database deploy
- [Amazon S3 ] - Serve Static files and uploaded files storage
- [Docker ] - Serve dev environment

## Installation

Clone project from [GIT](https://github.com/annralf/aguere-koombea-test.git) 

Once Clone finished go to 

```sh
cd koombea-test-ana-guere
```

Next Execute the container APP 
```sh
./vendor/bin/sail up
```

To RUN the  [Docker File setup](https://github.com/annralf/aguere-koombea-test/blob/dev/docker-compose.yml) v10+ to run.

After build containers, populate database with schemas structure

Create an alias name to execute docker commands throught container 

```sh
alias sail='bash vendor/bin/sail'
```
Then create database schema  

```sh
sail artisan migrate
```


