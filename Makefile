up:
	docker-compose up nginx -d
start:
	docker-compose start nginx
stop:
	docker-compose stop
install:
	composer install --prefer-dist --no-progress --no-suggest --no-interaction
	npm install
	npm run dev

migrate:
	php artisan migrate --no-interaction --force

test:
	vendor/bin/phpunit

docker-build:
	docker build -t laravel-app .
