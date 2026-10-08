<?php

declare(strict_types=1);

namespace App\Factories;

use DI\Attribute\Inject;
use DI\Container;
use Memcached;
use Redis;
use Symfony\Component\Cache\Adapter\ApcuAdapter;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Adapter\MemcachedAdapter;
use Symfony\Component\Cache\Adapter\PhpFilesAdapter;
use Symfony\Component\Cache\Adapter\RedisAdapter;
use Symfony\Contracts\Cache\CacheInterface;
use UnexpectedValueException;

class CacheFactory
{
    private const NAMESPACE = 'breve';

    #[Inject('cache_driver')]
    private string $cacheDriver;

    #[Inject('cache_lifetime')]
    private int $cacheLifetime;

    #[Inject('app_cache')]
    private string $appCache;

    public function __construct(
        private Container $container,
    ) {}

    public function __invoke(): CacheInterface
    {
        return match ($this->cacheDriver) {
            'apcu' => $this->getApcuAdapter(),
            'array' => $this->getArrayAdapter(),
            'file' => $this->getFilesystemAdapter(),
            'memcached' => $this->getMemcachedAdapter(),
            'php-file' => $this->getPhpFilesAdapter(),
            'redis' => $this->getRedisAdapter(),
            'valkey' => $this->getRedisAdapter(),
            default => throw new UnexpectedValueException(sprintf('Invalid cache driver [%s]', $this->cacheDriver))
        };
    }

    private function getApcuAdapter(): ApcuAdapter
    {
        return new ApcuAdapter(self::NAMESPACE, $this->cacheLifetime);
    }

    private function getArrayAdapter(): ArrayAdapter
    {
        return new ArrayAdapter($this->cacheLifetime);
    }

    private function getFilesystemAdapter(): FilesystemAdapter
    {
        return new FilesystemAdapter(self::NAMESPACE, $this->cacheLifetime, $this->appCache);
    }

    private function getMemcachedAdapter(): MemcachedAdapter
    {
        $this->container->call('memcached_config', [$memcached = new Memcached]);

        return new MemcachedAdapter($memcached, self::NAMESPACE, $this->cacheLifetime);
    }

    private function getPhpFilesAdapter(): PhpFilesAdapter
    {
        return new PhpFilesAdapter(self::NAMESPACE, $this->cacheLifetime, $this->appCache);
    }

    private function getRedisAdapter(): RedisAdapter
    {
        $this->container->call('redis_config', [$redis = new Redis]);

        return new RedisAdapter($redis, self::NAMESPACE, $this->cacheLifetime);
    }
}
