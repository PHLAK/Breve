# Installation

## Breve Compose

> [!IMPORTANT] Requirements
> - [Docker Compose](https://docs.docker.com/compose/)
> - [Git Version Control](https://git-scm.com)
> - [GNU Make](https://www.gnu.org/software/make/)

For a long-term installation we provide [Breve Compose](https://github.com/PHLAK/breve-compose)
as a quick and easy way of getting up and running with a pre-configured
[Docker Compose](https://docs.docker.com/compose/) configuration.

1. Clone the repository to a location of your choosing

    ```console
    git clone https://github.com/PHLAK/breve-compose.git /path/to/breve
    ```

2. Switch to your installation directory and initialize the configuration files

    ```console
    cd /path/to/breve
    make init
    ```

3. Modify the environment variables in `.env` for your installation

4. Run `docker compose config` to validate and confirm your configuration

5. Run `docker compose up -d` to start the containers

## Docker Compose

> [!IMPORTANT] Requirements
> - [Docker Compose](https://docs.docker.com/compose/)

If you prefer a manual [Docker Compose](https://docs.docker.com/compose/)
installation you may create a directory for your Breve app and, in that
directory, add a `docker-compose.yaml` file and a folder (e.g. `data`) to 
contain your data.

```text{4}
/path/to/breve
├── data
│   └── [your data will go here]
└── docker-compose.yaml
```

::: code-group
```yaml [docker-compose.yaml]
services:

  breve:
    image: phlak/breve:latest
    environment:
      SITE_TITLE: My Amazing Blog
      # See configuration docs for additional variables
    ports:
      - <host_port>:80
    volumes:
      - ./data:/var/www/html/data
      - ./themes:/var/www/html/themes
      - breve-cache:/var/www/html/cache/app
    user: www-data
    restart: unless-stopped

volumes:
  breve-cache: {}
```
:::

> [!IMPORTANT]
> Replace `<host_port>` with the port on which you would like the application to be exposed.

> [!TIP]
> See [Environment Variables](configuration/environment-variables.md) for a full
> list of the available environment variables.

Once created, start the container by running `docker compose up -d` from the
same directory as the `docker-compose.yaml` file.

## Docker Run

> [!IMPORTANT] Requirements
> - [Docker](https://docs.docker.com)

You may use `docker run` to launch a stand-alone Docker container from the
official Docker image. This is a good way to test Breve for the first time but
is _not recommended_ for long-term use. Instead we recommend using either the
[Breve Compose](#breve-compose) or [Docker Compose](#docker-compose)
installation method instead.

```console
docker run --detach --publish <host_port>:80 \
    [--env ENVIRONMENT_VARIABLE=value] \
    --volume ./data:/var/www/html/data \
    phlak/breve:latest
```

> [!IMPORTANT]
> Replace `<host_port>` with the port on which you would like the application to
> be exposed.

> [!TIP]
> You may pass multiple environment variables by repeating the `--env` flag.

## Manual Installation

> [!IMPORTANT] Requirements
> - [PHP](https://www.php.net)
> - [Composer](https://getcomposer.org)
> - [Node.js](https://nodejs.org) and npm

If you prefer to run Breve without Docker you may install it manually from
source.

1. Clone the repository to a location of your choosing

    ```console
    git clone https://github.com/PHLAK/Breve.git /path/to/breve
    ```

2. Switch to your installation directory and install the PHP dependencies

    ```console
    cd /path/to/breve
    composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader
    ```

3. Install the front-end dependencies and build the assets

    ```console
    npm install --no-audit --no-fund
    npm run build
    ```

4. Copy the example `.env` file and modify the environment variables for your
   installation

    ```console
    cp .env.example .env
    ```

    > [!TIP]
    > See [Environment Variables](configuration/environment-variables.md) for a
    > full list of the available environment variables.


5. Ensure the `data` and `cache` directories are writable by your web server

    ```console
    chown --recursive www-data:www-data data cache
    ```

    > [!IMPORTANT]
    > The web server user varies by platform (e.g. `www-data` on Debian/Ubuntu,
    > `apache` on Fedora/RHEL). Replace it in the example above accordingly.

Once configured you may test your installation by serving the application with
PHP's built-in web server. Run `composer serve` from your installation
directory, then browse to `http://localhost:8080`.


> [!TIP]
> Posts and pages must be published from the command line by running
> `php breve publish` from your installation directory. See
> [Getting Started](getting-started.md) for more information.

## Reverse Proxy

It's recommended to run Breve behind a reverse proxy. The following examples
assume Breve is accessible on the host at `127.0.0.1:8076`.

> [!TIP]
> Replace `8076` with the port you configured for your Breve installation.

### NGINX

```nginx
server {
    listen 80;
    server_name example.com;

    location / {
        proxy_pass http://127.0.0.1:8076;

        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
    }
}
```

### Apache

```apache
<VirtualHost *:80>
    ServerName example.com

    ProxyPass / http://127.0.0.1:8076/
    ProxyPassReverse / http://127.0.0.1:8076/
</VirtualHost>
```

### Caddy

```caddyfile
example.com

reverse_proxy 127.0.0.1:8076
```
