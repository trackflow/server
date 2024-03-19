server:
	docker run -it webdevops/php-dev:8.3 -w /var/www/html -v ./:/var/www/html php server.php