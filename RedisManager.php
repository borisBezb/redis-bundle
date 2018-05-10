<?php

namespace Bezb\RedisBundle;

use Bezb\RedisBundle\Connection\Connection;
use Bezb\RedisBundle\Connector\{ ConnectorInterface, PhpRedisConnector, PRedisConnector };
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
     * @param string $name
     * @return Connection
     */
    public function getConnection(?string $name): Connection
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

    /**
     * @param $name
     */
    public function close($name)
    {
        if (!isset($this->connections[$name])) {
            return;
        }

        $this->connections[$name]->close();
        unset($this->connections[$name]);
    }
}