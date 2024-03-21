setup:
	docker compose up -d --force-recreate --remove-orphans
	docker compose exec trackflow composer install

server:
	@docker compose exec trackflow php server.php

test:
	docker compose exec trackflow composer run-script test

build:
	docker build . -f docker/Dockerfile -t trackflow/server --no-cache

run:
	@docker run \
		-p 8815:8815 \
		-p 8816:8816 \
		-p 5555:5555 \
		-p 4343:4343 \
		-p 1025:1025 \
		trackflow/server

run-auth:
	@docker run \
		-p 8815:8815 \
		-p 8816:8816 \
		-p 5555:5555 \
		-p 4343:4343 \
		-p 1025:1025 \
		-e USERNAME=admin \
		-e PASSWORD=lucky-dev \
		trackflow/server