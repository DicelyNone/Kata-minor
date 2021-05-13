include .env
export

.PHONY: up down bash composer-install cc

up:
	docker-compose up -d

down:
	docker-compose down

re:
	make down
	make up

bash:
	docker-compose exec --user=application php bash

composer-install:
	docker-compose exec -T --user=application php composer install

cc:
	rm -rf app/var/cache/
	docker-compose exec -T --user=application php bin/console ca:cl

validate-schema:
	docker-compose exec --user=application php bin/console doctrine:schema:validate

create-db:
	docker-compose exec --user=application php bin/console doctrine:database:create --if-not-exists

update-schema:
	docker-compose exec -T --user=application php bin/console doctrine:schema:update --force

install:
	cp .env .env.local
	docker-compose up -d
	make composer-install
	make create-db
	make update-schema
	make cc

update:
	git pull
	make composer-install
	make update-schema
	make cc

sg:
	docker-compose exec -T --user=application php bin/console app:start-game