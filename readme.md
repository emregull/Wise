## Project Name

Emre Gül - Wise - Backend Project

## Getting Started

Follow the steps below to run the project.

## Requirements

- Docker
- Postman

## Setup

Download or clone this repository:

git clone https://github.com/emregull/wise.git

Download the required Composer files:

composer install

Edit the .env file like .env.example:

.env

Start the Docker containers:

cd docker
docker-compose up -d

Navigate to the root directory of the Laravel project and run the migrations:

cd ..
php artisan migrate

Start the Laravel server:

php artisan serve

Open your browser and go to http://localhost:8000 to view the application.  
(You might need to generate a key if prompted by Laravel. You can do this easily by running `php artisan key:generate`.)

Alternatively, access phpMyAdmin in your browser at:

http://localhost:8080

Username: sirwiss  
Password: sirwiss

## Postman

You can access the required Postman collection from the project directory:

Sirwiss - EmreGul.postman_collection
