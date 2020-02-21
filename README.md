#Chamada

git clone https://github.com/joaocarias/chamadadeaula.git chamada

composer install

npm install

cp .env.example .env

php artisan key:generate

configurar db em .env

php artisan migrate

php artisan db:seed

vendor\laravel\framework\src\Illuminate\Foundation\Auth\AuthenticatesUsers.php 

public function username()

php artisan storage:link

composer require doctrine/dbal