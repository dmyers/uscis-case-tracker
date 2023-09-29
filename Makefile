setup:
	cp .env.local .env
	docker run -it --rm -v ${PWD}:/var/www/html dmyers/laravel:7.2 composer install
	nvm use
	npm install
	npm install -g serverless@2

preview:
	php artisan serve

watch:
	npm run hot

deploy:
	rm -f .env
	docker run -it --rm -v ${PWD}:/var/www/html dmyers/laravel:7.2 php artisan optimize:clear --env=local
	docker run -it --rm -v ${PWD}:/var/www/html dmyers/laravel:7.2 composer install --optimize-autoloader --no-dev
	docker run -it --rm -v ${PWD}:/var/www/html dmyers/laravel:7.2 composer dump-autoload
	nvm use
	serverless deploy
	npm run prod
	aws s3 cp public/img/browserconfig.xml s3://uscis-case-tracker
	aws s3 cp public/img/manifest.json s3://uscis-case-tracker
	aws s3 cp public/img/yandex-browser-manifest.json s3://uscis-case-tracker
	aws s3 sync public/img s3://uscis-case-tracker/img --delete
	aws s3 sync public/css s3://uscis-case-tracker/css --delete
	aws s3 sync public/js s3://uscis-case-tracker/js --delete

logs:
	serverless logs -f website
