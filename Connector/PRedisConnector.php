<?php

namespace Bezb\RedisBundle\Connector;

use Bezb\RedisBundle\Connection\Connection;
use Bezb\RedisBundle\Connection\PRedisConnection;
use Predis\Client;

/**
 * Class PRedisConnector
 * @package Bezb\RedisBundle\Connector
 */
class PRedisConnector implements ConnectorInterface
{
    /**
     * @param array $config
     * @return Connection
     */
    public function connect(array $config): Connection
    {
        $client = new Client([
            'host'                  => $config['host'],
            'port'                  => $config['port'],
            'password'              => $config['password'],
            'database'              => $config['database'],
            'persistent'            => $config['persistent'] ?? true,
            'timeout'               => $config['timeout'],
            'read_write_timeout'    => $config['read_timeout']
        ]);

        return new PRedisConnection($client);
    }
}