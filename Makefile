preview:
	php artisan serve

deploy:
    composer install --optimize-autoloader --no-dev
	php artisan route:clear
	php artisan cache:clear
	php artisan config:clear
	php artisan view:clear
	serverless deploy
