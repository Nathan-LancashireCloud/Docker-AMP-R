# Docker AMP+ (R)

A modern, production-ready **AMP** stack (Apache, MySQL, PHP) with Redis, built for local development and lightweight production use. This stack provides a hardened PHP/Apache image with optional MySQL, Redis, and PHPMyAdmin services—all orchestrated via Docker Compose.

---

## Features

* **Single hardened PHP/Apache image** with PHP 8.2, production `php.ini`, and common extensions.
* **PHP extensions included:** `gd`, `pdo`, `pdo_mysql`, `mysqli`, `zip`, `mbstring`, `redis`.
* **System libraries** for common PHP apps (CMS, frameworks, custom code): image handling, compression, multibyte strings, Git, Curl.
* **Security-focused Apache configuration:** `ServerTokens Prod`, `ServerSignature Off`, HTTPS-ready headers, custom virtual host.
* **Non-root runtime user** (`webuser`) for safer container operation.
* **Healthchecks** for all services (web, MySQL, Redis, phpMyAdmin).
* **Configurable via `.env`** with build-time PHP args, ports, database credentials, and Redis settings.

---

## Included Services

* **Web (PHP/Apache)** – Custom build with system dependencies, extensions, and hardening.
* **MySQL 8.0** – Persistent storage via Docker volumes, native password auth.
* **Redis 7.0** – Alpine-based Redis server for caching or session storage.
* **phpMyAdmin** – Optional database GUI for local development.

---

## System Dependencies

Installed in the PHP image:

* `libpng-dev`, `libjpeg-dev`, `libfreetype6-dev`, `libwebp-dev` – for GD image support.
* `libzip-dev`, `zlib1g-dev` – ZIP and compression libraries.
* `libonig-dev` – Multibyte string and regex support.
* `curl`, `git`, `unzip` – HTTP requests, version control, archive handling.
* `sendmail` – Basic mail support.

---

## PHP & Apache Configuration

**PHP:**

* Production `php.ini` enabled.
* Configurable via build args:

  * `PHP_MEMORY_LIMIT` (default `256M`)
  * `PHP_MAX_EXECUTION_TIME` (default `30`)
  * `PHP_UPLOAD_MAX_FILESIZE` (default `20M`)
  * `PHP_POST_MAX_SIZE` (default `20M`)

**Apache:**

* Modules: `rewrite`, `headers`, `ssl`, `remoteip`.
* Security hardening via `Configuration/apache-security.conf`.
* Virtual host defined in `Configuration/apache-host.conf`.
* Non-root user `webuser` runs Apache processes.
* Public access is restricted to www/public_html; other folders like configs are not accessible via the web.

---

## Project Structure

```
.
├── Dockerfile                 # PHP/Apache build
├── docker-compose.yml         # Stack orchestration
├── .env                       # Environment variables
├── Configuration/
│   ├── apache-host.conf       # Virtual host config
│   └── apache-security.conf   # Security and headers
├── www/                       # Mount your PHP app here
│   ├── public_html            # Publicly accessible directory
│   └── configs                # Secure from public access
```

---

## Getting Started

1. **Clone the repository**

```bash
git clone https://github.com/Nathan-LancashireCloud/Docker-AMP-R.git
cd Docker-AMP-R
```

2. **Configure environment**

* Copy `.env` and adjust credentials, ports, PHP settings, and Redis host/port as needed.

3. **Build and start the stack**

```bash
docker compose up -d --build
```

4. **Access your app**

* PHP/Apache: `http://localhost:${APACHE_PORT}`
* phpMyAdmin: `http://localhost:${PHPMYADMIN_PORT}`

---

## Production Considerations

* Recommended for small to medium deployments.
* For production, use an external reverse proxy (Nginx, Traefik) for HTTPS, caching, and routing.
* Store MySQL data in persistent volumes and maintain regular backups.
* Use CI/CD pipelines to build and test the Docker image before deploying.

---

## Environment Variables

Defined in `.env`:

* Database: `MYSQL_DATABASE`, `MYSQL_USER`, `MYSQL_PASSWORD`, `MYSQL_ROOT_PASSWORD`
* phpMyAdmin: `PMA_HOST`, `PMA_USER`, `PMA_PASSWORD`
* Ports: `APACHE_PORT`, `MYSQL_PORT`, `PHPMYADMIN_PORT`
* PHP: `PHP_MEMORY_LIMIT`, `PHP_MAX_EXECUTION_TIME`, `PHP_UPLOAD_MAX_FILESIZE`, `PHP_POST_MAX_SIZE`
* Redis: `REDIS_HOST`, `REDIS_PORT`
* Website root: `SERVER_ROOT`

---

## License

This project is licensed under the MIT License. See `LICENSE` f
