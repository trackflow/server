# ![logo](public/logo.svg) Trackflow a php application debugging tool

Trackflow makes debugging an application easier and more pleasant so you can concentrate on your developments.

## Getting started

### With docker

```bash
docker run -p 8815:8815 -p 8816:8816 -p 5555:5555 -p 4343:4343 -p 1025:1025 trackflow/server:latest
```

#### Different docker network
If you are calling the tracking flow from a container with a different network, prefer to use the docker IP gateway
```bash
docker inspect bridge | grep Gateway
```

### With docker compose
```yaml
trackflow:
  image: trackflow/server:latest
  ports:
    - "8815:8815"
    - "8816:8816"
```

Open Trackflow in your browser http://127.0.0.1:8815

### Enable authenticate

Add these environments variables to enable login form authenticator

```
USERNAME=admin
PASSWORD=password
```

---

## Configuration

### Sentry

**Symfony**
```
SENTRY_DSN=http://sentry@127.0.0.1:8815/project1
```
**Laravel**
```
SENTRY_LARAVEL_DSN=http://sentry@127.0.0.1:8815/project1
```

### SMTP Mailer
An SMTP server as a mailtrap to catch emails

**Symfony**, **Laravel**
```
MAILER_DSN=smtp://127.0.0.1:1025
```

### Monolog
**Symfony**

Edit monolog package
```
# config/packages/dev/monolog.yaml
monolog:
  handlers:
    socket:
      level: debug
      type: socket
      formatter: monolog.formatter.json
      connection_string: '%env(MONOLOG_SOCKET_HOST)%'
```
Add new variable environment
```
MONOLOG_SOCKET_HOST=127.0.0.1:4343
```

### Dump
```
VAR_DUMPER_FORMAT=server
VAR_DUMPER_SERVER=127.0.0.1:5555
```
