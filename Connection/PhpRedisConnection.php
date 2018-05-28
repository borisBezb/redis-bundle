<?php

namespace Bezb\RedisBundle\Connection;

/**
 * Class PhpRedisConnection
 * @package Bezb\RedisBundle\Connection
 */
class PhpRedisConnection extends Connection
{
    /**
     * @return \Redis
     */
    protected function connect()
    {
        $client = new \Redis();

        $persistent = $this->config['persistent'] ?? false;

        $connectMethod = $persistent ? 'pconnect' : 'connect';

        $client->$connectMethod(
            $this->config['host'],
            $this->config['port'],
            $this->config['timeout']
        );

        $client->select($this->config['database']);

        if ($this->config['prefix']) {
            $client->setOption(\Redis::OPT_PREFIX, $this->config['prefix']);
        }

        $client->setOption(\Redis::OPT_SERIALIZER, $this->resolveSerializer($this->config['serializer']));

        return $client;
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