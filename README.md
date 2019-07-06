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
## Usage
request access token
send post request to http://127.0.0.1:8000/oauth/token
with the following data
```bash
'form_params' => [
        'grant_type' => 'client_credentials',
        'client_id' => 'client-id',
        'client_secret' => 'client-secret',
    ],
```
### Mobile Api End Points
Onces you have your access_token you can send a request to:

1.Create user

The user for this access token need to be admin if not will not allow to create a user
```bash
Header
-Accept => application/json
-Authorization => Bearer 'access_token'

form
'form_params' => [
        'email' => 'user_email',
        'password' => 'user_password',
        'role' => 'admin or user',
        'name" => 'user_name',
        'last' => 'user_lastname',
        'age' => 'user_age'
    ],
```

2.get a user data

make a get request to /getUsers
```bash
Header
-Accept => application/json
-Authorization => Bearer 'access_token'


```
3.Add Favorite Movie

make a Post request to api/favorites
```bash
Header
-Accept => application/json
-Authorization => Bearer 'access_token'

'form_params' => [
        'user_id' => 'user_id',
        'movie_id' => 'movie_id',
        'favorite' => 'boolean',
    ],
```
4.Get user Favorite Movies

make a Get request to /api/user/{user_id}
```bash
Header
-Accept => application/json
-Authorization => Bearer 'access_token'
```
5.Get Movie By name

make a Get request to /api/findMovie?q={movie_title}
```bash
Header
-Accept => application/json
-Authorization => Bearer 'access_token'
```
