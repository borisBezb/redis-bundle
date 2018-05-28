<?php

namespace Bezb\RedisBundle;

use Bezb\RedisBundle\Connection\{ Connection, PhpRedisConnection, PRedisConnection };
use Bezb\RedisBundle\Exception\RedisException;

/**
 * Class RedisManager
 * @package Bezb\RedisBundle\Redis
 */
class RedisManager
{
    /**
     * @var string
     */
    protected $driver;

    /**
     * @var string
     */
    protected $default;

    /**
     * @var array
     */
    protected $config = [];

    /**
     * @var Connection[]
     */
    protected $connections = [];

    /**
     * RedisManager constructor.
     * @param string $driver
     * @param string $default
     * @param array $config
     */
    public function __construct(string $driver, string $default, array $config)
    {
        $this->driver = $driver;
        $this->default = $default;
        $this->config = $config;
    }

    /**
     * @param null|string $name
     * @return Connection
     * @throws RedisException
     */
    public function getConnection(?string $name = null): Connection
    {
        if (!$name) {
            $name = $this->default;
        }

        if (!isset($this->connections[$name])) {
            $this->connections[$name] = $this->resolveConnection($name);
        }

        return $this->connections[$name];
    }

    /**
     * @param $name
     * @return \Bezb\RedisBundle\Connection\Connection
     * @throws RedisException
     */
    public function resolveConnection($name): Connection
    {
        if (!isset($this->config[$name])) {
            throw new RedisException("Connection $name does not configured");
        }

        switch ($this->driver) {
            case 'predis':
                return new PRedisConnection($this->config[$name]);

            case 'redis':
                return new PhpRedisConnection($this->config[$name]);
        }
    }
}