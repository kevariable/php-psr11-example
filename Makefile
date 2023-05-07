build:
	docker-compose up -d --build

setup:
	make build
	docker exec -it psr11-app composer install

up:
	docker-compose up -d

down:
	docker-compose down

shell:
	docker exec -it psr11-app /bin/bash