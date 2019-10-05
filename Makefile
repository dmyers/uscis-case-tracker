preview:
	php artisan serve

deploy:
	php artisan route:clear --env=local
	php artisan cache:clear --env=local
	php artisan config:clear --env=local
	php artisan view:clear --env=local
	composer install --optimize-autoloader --no-dev
	#aws s3 sync <directory> s3://uscis-case-tracker --delete
	serverless deploy
