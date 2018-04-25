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
}