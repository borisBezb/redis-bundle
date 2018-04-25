<?php

namespace Bezb\RedisBundle\Redis;

use Bezb\RedisBundle\Connector\ConnectorInterface;
use Bezb\RedisBundle\Connector\PhpRedisConnector;
use Bezb\RedisBundle\Connector\PRedisConnector;

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
     * @return mixed
     * @throws \Exception
     */
    public function getConnection(string $name = 'default')
    {
        if (!isset($this->connections[$name])) {
            $this->connections[$name] = $this->resolveConnection($name);
        }

        return $this->connections[$name];
    }

    /**
     * @param $name
     * @return \Bezb\RedisBundle\Connection\Connection|mixed
     * @throws \Exception
     */
    public function resolveConnection($name)
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