<?php

namespace ArmandGarot\LaravelWorkerman;

use Illuminate\Support\Facades\Config;
use Workerman\Worker;
use PHPSocketIO\SocketIO;

class LaravelWorkermanServer extends SocketIO
{

    /**
     * Start SocketIO server.
     */
    public static function start() {
        $port = Config::get('laravel-workerman.server.port');
        $events = Config::get('laravel-workerman.events');

        $server = new Self($port);

        foreach ($events as $event) {
            new $event($server);
        }

        Worker::runAll();
    }

    /**
     * Stop SocketIO server.
     */
    public static function stop() {
        Worker::stopAll();
    }

    /**
     * Get SocketIO server status.
     */
    public static function getStatus() {
        return Worker::getStatus();
    }
}
