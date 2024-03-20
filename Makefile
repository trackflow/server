dev:
	docker run \
		-v $(shell pwd)/:/app \
		-w /app \
		-p 8815:8080 \
		-p 8816:8888 \
		-p 5555:5555 \
		-p 4343:4343 \
		-p 1025:1025 \
		webdevops/php-dev:8.3 ./server

build:
	docker build . -f docker/Dockerfile -t trackflow/server --no-cache

run:
	docker run \
		-p 8815:8080 \
		-p 8816:8888 \
		-p 5555:5555 \
		-p 4343:4343 \
		-p 1025:1025 \
		trackflow/server

run-auth:
	docker run \
		-p 8815:8080 \
		-p 8816:8888 \
		-p 5555:5555 \
		-p 4343:4343 \
		-p 1025:1025 \
		-e USERNAME=admin \
		-e PASSWORD=lucky-dev \
		trackflow/server