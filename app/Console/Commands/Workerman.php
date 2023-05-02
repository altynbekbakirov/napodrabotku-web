<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Workerman\WorkermanUdp; //The content of this file is basically the same as WorkermanWeb, which is used to enable 2 workerman services at the same time, which can be ignored
use App\Http\Workerman\WorkermanWeb;
use Workerman\Worker;

class Workerman extends Command
{
    protected $action = array('start','daemon', 'stop', 'reload', 'status', 'connections');

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'workerman {action}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start a Workerman:websocket server.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $action = $this->argument('action');
        if (!in_array($action, $this->action)) {
            $this->error('Error Action');
            exit;
        }
        WorkermanWeb::workerman_init($action);

        //If you need to start two workerman services at the same time, put the head and tail in the file, if you don't need it, you can ignore it.
        //Rewrite the parameters in cli mode
        //global $argv;
        //$argv[0] = 'workerman';
        //$argv[1] = $action;
        //if ($action == 'daemon') {
        //  $argv[1] = 'start';
        //  $argv[2] = '-d';
        //}
        //define('HEARTBEAT_TIME', 30);//heartbeat

        //WorkermanWeb::workerman_init($action);
        //WorkermanUdp::workerman_init($action);

        //Worker::runAll();

    }
}
