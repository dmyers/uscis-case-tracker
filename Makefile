preview:
	php artisan serve

deploy:
	php artisan route:clear --env=local
	php artisan cache:clear --env=local
	php artisan config:clear --env=local
	php artisan view:clear --env=local
	composer install --optimize-autoloader --no-dev
	npm run prod
	#aws s3 sync public s3://uscis-case-tracker --delete
	serverless deploy
