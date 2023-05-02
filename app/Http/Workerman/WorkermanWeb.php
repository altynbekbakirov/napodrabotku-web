<?php
//
//namespace App\Http\Workerman;
//
//
//use Workerman\Lib\Timer;
//use Workerman\Worker;
//
//class WorkermanWeb
//{
//    public static function workerman_init($action = null)
//    {
//        global $argv;
//        $argv[0] ='workerman:websocket'; //It doesn't matter what to write, just make up the number
//        $argv[1] = $action;
//        if ($action == 'daemon') {
//            $argv[1] = 'start';
//            $argv[2] = '-d';
//        }
//        //Heartbeat
//        define('HEARTBEAT_TIME', 30);
//        //Initialization
//        $worker = new Worker("websocket://0.0.0.0:8002");
//        $worker->name = 'Infusion Alarm';
//        //Linux user online is www
//        //$worker->user = 'www';
//        //Daemon mode information output file address
//        //$worker->stdoutFile = "./workerman.log";
//        //Total number of work processes 4 test environments
//        $worker->count = 4;
//        //Formal environment
//        //$ws->count = 10;
//        //Establish link processing logic
//        $worker->onConnect = function ($connection) {
//            self::onConnect($connection);
//        };
//        //Accept message processing logic
//        $worker->onMessage = function ($connection, $data) {
//            self::onMessage($connection, $data);
//        };
//        //Close the link processing logic
//        $worker->onClose = function ($connection) {
//            self::onClose($connection);
//        };
//        // Set a timer that runs every 30 seconds after the process starts
//        $worker->onWorkerStart = function ($worker) {
//            Timer::add(30, function () use ($worker) {
//                $time_now = time();
//                foreach($worker->connections as $connection) {
//                    // It is possible that the connection has not received a message yet, then lastMessageTime is set to the current time
//                    if (empty($connection->lastMessageTime)) {
//                        $connection->lastMessageTime = $time_now;
//                        continue;
//                    }
//                    // The last communication time interval is greater than the heartbeat interval, then the client is considered offline and the connection is closed
//                    if ($time_now - $connection->lastMessageTime > HEARTBEAT_TIME) {
//                        $connection->close();
//                    }
//                }
//            });
//        };
//        // begin
//        Worker::runAll();
//    }
//
//    //Establish link processing logic
//    public static function onConnect($connection)
//    {
//        $connection->send(json_encode([
//            'code' => 20001,
//            'massage' =>'Request successful',
//            'data' => [],
//        ]));
//
//
//        //Test once every 5 seconds and once online 30 seconds
//        //Timer::add(10, function () use ($connection) {
//
//        //});
//    }
//
//    //Receive message processing logic
//    public static function onMessage($connection, $data)
//    {
//        // Temporarily set a lastMessageTime attribute to the connection to record the time of the last message received
//        $connection->lastMessageTime = time();
//        //Analytical data
//        if (!empty($data)) {
//            $data = json_decode($data, true);
//            switch ($data['type']) {
//                // The client responds to the heartbeat of the server
//                case 'ping':
//                    $connection->send(json_encode([
//                        'code' => 30000,
//                        'massage' =>'service alive',
//                        'data' => [],
//                    ]));
//                    break;
//                case 'alarm_list':
//                    //Business logic can be processed here
//                    $connection->send(json_encode([
//                        'code' => 20000,
//                        'massage' =>'Get the alarm list successfully',
//                        'data' => [],
//                    ]));
//                    break;
//                default:
//                    break;
//            }
//        } else {
//            $connection->send(json_encode([
//                'code' => 201,
//                'massage' =>'Data request is empty',
//                'data' => [],
//            ]));
//        }
//    }
//
//    //Close the link processing logic
//    public static function onClose($connection)
//    {
//
//    }
//}
