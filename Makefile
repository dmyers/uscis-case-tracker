setup:
	composer install
	npm install

preview:
	php artisan serve

watch:
	npm run hot

deploy:
	rm .env
	php artisan route:clear --env=local
	php artisan cache:clear --env=local
	php artisan config:clear --env=local
	php artisan view:clear --env=local
	composer install --optimize-autoloader --no-dev
	npm run prod
	aws s3 sync public/css s3://uscis-case-tracker/css --delete
	aws s3 sync public/js s3://uscis-case-tracker/js --delete
	serverless deploy
