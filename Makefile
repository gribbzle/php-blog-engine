.PHONY: help up down restart logs composer-install db-init db-seed clean ps bash mysql-bash

help:
	@echo "Available commands:"
	@echo "  make up              - Start all containers"
	@echo "  make down            - Stop all containers"
	@echo "  make restart         - Restart all containers"
	@echo "  make ps              - Show running containers"
	@echo "  make logs            - View Docker Compose logs"
	@echo "  make composer-install- Install PHP dependencies"
	@echo "  make db-init         - Initialize database schema"
	@echo "  make db-seed         - Seed database with sample data"
	@echo "  make bash            - Open PHP container bash"
	@echo "  make mysql-bash      - Open MySQL container bash"
	@echo "  make clean           - Remove containers, volumes, and logs"

up:
	docker compose up -d

down:
	docker compose down

restart:
	docker compose restart

ps:
	docker compose ps

logs:
	docker compose logs -f

composer-install:
	docker compose exec php composer install

db-init:
	docker compose exec mysql mysql -u root -p$${DB_PASSWORD:-secret} $${DB_NAME:-blog} < database/schema.sql

db-seed:
	docker compose exec php php database/seeder.php

bash:
	docker compose exec php sh

mysql-bash:
	docker compose exec mysql bash

clean:
	docker compose down -v
	rm -rf logs/*
	rm -rf vendor/
