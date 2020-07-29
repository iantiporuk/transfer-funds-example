cp .env.docker .env
php artisan migrate:fresh --seed
php-fpm
