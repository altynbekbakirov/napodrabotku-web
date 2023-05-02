<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    private $user;

    public function __construct(Request $request)
    {
        $token = $request->header('Authorization');
        $this->user = User::where("password", $token)->firstOrFail();

        if(!$this->user) {
            return "token is not valid";
        }
    }

    public function index()
    {
        $result = [];

        if($this->user->type == 'USER') {

            $chats = Chat::where('user_id', $this->user->id)->where('deleted', false)->get();

            foreach ($chats as $chat) {
                $result[] = [
                    'id' => $chat->company->id,
                    'name' => $chat->company->name,
                    'avatar' => $chat->company->avatar,
                    'last_message' => $chat->messages->sortByDesc('created_at')->first() ? $chat->messages->sortByDesc('created_at')->first()->message : '',
                    'unread_messages' => $chat->messages->where('user_id', '<>', $this->user->id)->where('read', false)->count()
                ];
            }

        } else {
            $chats = Chat::where('company_id', $this->user->id)->where('deleted', false)->get();

            foreach ($chats as $chat) {
                $result[] = [
                    'id' => $chat->user->id,
                    'name' => $chat->user->name,
                    'avatar' => $chat->user->avatar,
                    'last_message' => $chat->messages->sortByDesc('created_at')->first() ? $chat->messages->sortByDesc('created_at')->first()->message : '',
                    'unread_messages' => $chat->messages->where('user_id', '<>', $this->user->id)->where('read', false)->count()
                ];
            }
        }

        return json_encode($result);
    }

    public function messages(Request $request, $receiver_id)
    {
        $result = [];

        if($this->user->type == 'USER') {
            $chat = Chat::where('user_id', $this->user->id)->where('company_id', $receiver_id)->where('deleted', false)->first();
            if(!$chat) {
                $chat = Chat::create([
                    'user_id' => $this->user->id,
                    'company_id' => $receiver_id
                ]);
            }
        } else {
            $chat = Chat::where('user_id', $receiver_id)->where('company_id', $this->user->id)->where('deleted', false)->first();
            if(!$chat) {
                $chat = Chat::create([
                    'user_id' => $receiver_id,
                    'company_id' => $this->user->id
                ]);
            }
        }

        $messages = Message::chat($chat->id)->get();

        if($messages){
            foreach ($messages as $message){
                $message->read = true;
                $message->save();

                $read = true;
                $from = false;

                if($message->user_id == $this->user->id){
                    $from = true;
                }
                $result[] = [
                    'message' => $message->message,
                    'date_time' => date('Y-m-d H:i', strtotime($message->created_at)),
                    'read' => $read,
                    'from' => $from
                ];
            }
        }

        return json_encode($result);
    }

    public function saveMessage(Request $request)
    {
        if($this->user->type == 'USER') {
            $chat = Chat::where('user_id', $this->user->id)->where('company_id', $request->receiver_id)->first();
        } else {
            $chat = Chat::where('user_id', $request->receiver_id)->where('company_id', $this->user->id)->first();
        }

        $message = Message::create([
            'user_id' => $this->user->id,
            'chat_id' => $chat->id,
            'message' => $request->message
        ]);

        return json_encode($message);
    }

    public function destroyChat(Request $request)
    {
        if($this->user->type == 'USER') {
            Chat::where('user_id', $this->user->id)->where('company_id', $request->receiver_id)->delete();
        } else {
            Chat::where('user_id', $request->receiver_id)->where('company_id', $this->user->id)->delete();
        }

        return 'OK';
    }
}
