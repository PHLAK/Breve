# Advanced Configuration

Some configuration values do not have corresponding environment variables. These
values can only be controlled through their entries in the `app/config` files.

> [!IMPORTANT]
> To persist changes to files in `app/config` you must add a volume definition
> for this directory. Without it, any modifications will be lost when the
> container restarts.

## Application Configs

The application configs are broken up into separate files based on their use and
give you full control over every application option and even allows full PHP
code if desired.

> [!TIP]
> Breve utilizes [PHP-DI](https://php-di.org) for its configuration. See the
> [PHP Definitions documentation](https://php-di.org/doc/php-definitions.html)
> for more info on writing manual configuration definitions.

For additional information about individual configuration options reference the
individual config documentation below.

## Configuration Options

### `memcached_config`

The Memcached configuration [anonymous function](https://www.php.net/manual/en/functions.anonymous.php)
(i.e. closure) is evaluated when the `cache_driver` configuration option is set
to `memcached`. The closure receives a `Memcached` object as it's only
parameter. You may use this object to configure a connection to one or more
Memcached servers. At a minimum you must connect one Memcached server via the
`addServer()` or `addServers()` methods.

> [!TIP]
> Reference the [PHP Memcached documentation](https://secure.php.net/manual/en/book.memcached.php)
> for Memcached configuration options.

- **Possible Values:** A `ValueDefinition` containing an anonymous function that
  receives and configures a `Memcached` object.

  ```php
  DI\value(function (Memcached $memcached): void {
      // Configure the $memcached object
  })
  ```

- **Default Value:** A `ValueDefinition` that contains a closure that will
  connect to a server defined by `memcached_host` and `memcached_port`.

  ```php
  DI\value(function (Memcached $memcached, Config $config): void {
      $memcached->addServer(
          $config->get('memcached_host'),
          $config->get('memcached_port')
      );
  })
  ```

### `redis_config`

The Redis configuration [anonymous function](https://www.php.net/manual/en/functions.anonymous.php)
(i.e. closure) is evaluated when the `cache_driver` configuration option is set
to `redis`. The closure receives a `Redis` object as its only parameter. You
may use this object to configure a connection to one or more Redis servers. At a
minimum you must connect to one Redis server via the `connect()` or `pconnect()`
methods.

> [!TIP]
> Reference the [phpredis documentation](https://github.com/phpredis/phpredis#readme)
> for Redis configuration options.

- **Possible Values:** A `ValueDefinition` containing an anonymous function that
  receives and configures a `Redis` object.

  ```php
  DI\value(function (Redis $redis): void {
      // Configure the $redis object
  })
  ```

- **Default Value:** A `ValueDefinition` that contains a closure that will
  connect to a server defined by `redis_host` and `redis_port`.

  ```php
  DI\value(function (Redis $redis, Config $config): void {
      $redis->pconnect(
          $config->get('redis_host'),
          $config->get('redis_port')
      );
  })
  ```
