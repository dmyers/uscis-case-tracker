preview:
	php artisan serve

deploy:
	php artisan route:clear
	php artisan cache:clear
	php artisan config:clear
	php artisan view:clear
	serverless deploy
