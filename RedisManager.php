<?php

namespace Bezb\RedisBundle;

use Bezb\RedisBundle\Connection\Connection;
use Bezb\RedisBundle\Connector\{ ConnectorInterface, PhpRedisConnector, PRedisConnector };

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
     * @var array
     */
    protected $config = [];

    /**
     * @var array
     */
    protected $connections = [];

    /**
     * RedisManager constructor.
     * @param string $driver
     * @param array $config
     */
    public function __construct(string $driver, array $config)
    {
        $this->driver = $driver;
        $this->config = $config;
    }

    /**
     * @param string $name
     * @return Connection
     * @throws \Exception
     */
    public function getConnection(string $name = 'default'): Connection
    {
        if (!isset($this->connections[$name])) {
            $this->connections[$name] = $this->resolveConnection($name);
        }

        return $this->connections[$name];
    }

    /**
     * @param $name
     * @return \Bezb\RedisBundle\Connection\Connection
     * @throws \Exception
     */
    public function resolveConnection($name): Connection
    {
        if (!isset($this->config[$name])) {
            throw new \Exception("Connection $name does not configured");
        }

        return $this->getConnector()->connect($this->config[$name]);
    }

    /**
     * @return ConnectorInterface
     */
    protected function getConnector(): ConnectorInterface
    {
        switch ($this->driver) {
            case 'predis':
                return new PRedisConnector();

            case 'redis':
                return new PhpRedisConnector();
        }
    }
}