<?php

namespace Bezb\RedisBundle\Connection;

use Predis\Client;

/**
 * Class PRedisConnection
 * @package Bezb\RedisBundle\Connection
 */
class PRedisConnection extends Connection
{
    /**
     * PRedisConnection constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @return Client
     */
    protected function connect()
    {
        return new Client([
            'host'                  => $this->config['host'],
            'port'                  => $this->config['port'],
            'password'              => $this->config['password'],
            'database'              => $this->config['database'],
            'persistent'            => $this->config['persistent'] ?? true,
            'timeout'               => $this->config['timeout'],
            'read_write_timeout'    => $this->config['read_timeout']
        ]);
    }
}