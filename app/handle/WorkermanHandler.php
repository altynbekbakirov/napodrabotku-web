<?php
namespace handle;

use Illuminate\Console\Command;
use Workerman\Worker;
use App\Models\Region;

class WorkermanHandler
{

    protected $global_uid = 0;

    //Assign the uid when the client connects, save the link, and notify all clients
    public function handle_connection($connection){
        global $text_worker, $global_uid;
        // Assign a uid to this link
      $connection->uid = ++$global_uid;
      foreach($text_worker->connections as $conn){
          $conn->send("user:[{$connection->uid}] online");
      }
    }

    //When the client sends a message, it is forwarded to everyone.
    public function handle_message($connection,$data){
        Region::create([
            'name' => $data,
        ]);
        global $text_worker;
        foreach($text_worker->connections as $conn){
            $conn->send("user:[{$connection->uid}] said:$data");
        }
    }

// Broadcast to all clients when the client is disconnected
    public function handle_close($connection){
        global $text_worker;
        foreach($text_worker->connections as $conn){
            $conn->send("user:[{$connection->uid}] logout");
        }
    }

}
