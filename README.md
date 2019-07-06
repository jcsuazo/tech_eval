# tech_eval
Technical Evaluation for applab
## Installation
Clone or Download repo

Install composer files
```bash
composer install
```
Intall Dependencies
```bash
npm install
```

Create a new .env file and Copy .env.example to .env and set the good values inside .env

Create a new Application key

```bash
php artisan key:generate
```

Run migrations And Seed Databse
```bash
php artisan migrate --seed
```
This Command will:
1.create all the tables for database
2.seed your database with dummy data
3.Create a admin user: email: admin@me.com password:02Vend@r

Create Access Clients
```bash
php artisan passport:install
```
