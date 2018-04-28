<?php

namespace Bezb\RedisBundle\Connector;

use Bezb\RedisBundle\Connection\Connection;

/**
 * Interface ConnectorInterface
 * @package Bezb\RedisBundle\Connector
 */
interface ConnectorInterface
{
    /**
     * @param array $config
     * @return Connection
     */
    public function connect(array $config): Connection;
}