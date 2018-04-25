<?php

namespace Bezb\RedisBundle\Connector;

use Bezb\RedisBundle\Connection\Connection;
use Bezb\RedisBundle\Connection\PhpRedisConnection;

/**
 * Class PhpRedisConnector
 * @package Bezb\RedisBundle\Connector
 */
class PhpRedisConnector implements ConnectorInterface
{
    /**
     * @param array $config
     * @return Connection
     */
    public function connect(array $config): Connection
    {
        $client = new \Redis();

        $persistent = $config['persistent'] ?? false;

        $connectMethod = $persistent ? 'pconnect' : 'connect';

        $client->$connectMethod(
            $config['host'],
            $config['port'],
            $config['timeout']
        );

        $client->select($config['database']);

        if ($config['prefix']) {
            $client->setOption(\Redis::OPT_PREFIX, $config['prefix']);
        }

        $client->setOption(\Redis::OPT_SERIALIZER, $this->resolveSerializer($config['serializer']));

        return new PhpRedisConnection($client);
    }

    /**
     * @param $serializer
     * @return int
     */
    protected function resolveSerializer($serializer): int
    {
        switch ($serializer) {
            case 'none':
                return \Redis::SERIALIZER_NONE;

            case 'php':
                return \Redis::SERIALIZER_PHP;

            case 'igbinary':
                return \Redis::SERIALIZER_IGBINARY;
        }
    }
}