build:
	docker-compose up -d --build

setup:
	make build
	docker compose exec app composer install
up:
	docker-compose up -d

down:
	docker-compose down

shell:
	docker compose exec app /bin/bash

pest:
	docker compose exec -it app ./vendor/bin/pest --compact --parallel