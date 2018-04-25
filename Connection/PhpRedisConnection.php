<?php

namespace Bezb\RedisBundle\Connection;

/**
 * Class PhpRedisConnection
 * @package Bezb\RedisBundle\Connection
 */
class PhpRedisConnection extends Connection
{
    /**
     * PhpRedisConnection constructor.
     * @param \Redis $client
     */
    public function __construct(\Redis $client)
    {
        $this->client = $client;
    }
}