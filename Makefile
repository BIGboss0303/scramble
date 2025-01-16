up:
	docker-compose up nginx -d
start:
	docker-compose start nginx
stop:
	docker-compose stop
test:
	docker-compose start mysql-test
	docker-compose run --rm artisan test
	docker-compose stop mysql-test