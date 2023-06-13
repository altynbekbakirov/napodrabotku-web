<?php

namespace App\Http\Controllers\Admin;

use App\Charts\ActionChart;
use App\Charts\GenderChart;
use App\Charts\IntersexChart;
use App\Charts\SexChart;
use App\Charts\UserChart;
use App\Charts\YearChart;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Cookie;

//use App\Models\Question;

use App\Models\Page;
use function GuzzleHttp\Psr7\str;

class HomeController extends Controller
{
    public function index()
    {
        if (auth()->user()->type == 'COMPANY') {
            return redirect()->route('vacancies.index');
        }
        $title = 'Главная';
        return view('admin.index', compact('title'));
    }

    public function nav_toggle(Request $request)
    {
        $minutes = 1440;
        if ($request->mini == '1') {
            Cookie::queue('mini', 'm-brand--minimize m-aside-left--minimize', $minutes);
        } else if ($request->mini == '0') {
            Cookie::queue(Cookie::forget('mini'));
        }
    }

    public function menu()
    {
        return view('admin.menus.index');
    }

    public function profile()
    {
        $title = 'Профиль';
        return view('admin.profile', compact('title'));
    }

    public function account()
    {
        $title = 'Личный кабинет';
        return view('admin.account', compact('title'));
    }


    public function chat(Request $request)
    {
        $title = 'Чаты';

        $chats = Chat::where('company_id', auth()->user()->id)->where('deleted', false)->get();

        $chat_id = $request->id;
        $selected_chat = null;

        if ($chat_id) {
            $selected_chat = Chat::findOrFail($chat_id);
            $messages = Message::chat($chat_id)->get();

            if ($messages) {
                foreach ($messages as $message) {
                    $message->read = true;
                    $message->save();
                }
            }
        }

        return view('admin.chat', compact('title', 'chats', 'selected_chat'));
    }

    public function destroy($chat)
    {
        $title = 'Чаты';
        $chats = Chat::where('company_id', auth()->user()->id)->where('deleted', false)->get();
        $selected_chat = null;

        $chat_delete = Chat::where('id', $chat)->first();
        $chat_delete->delete();

        return redirect()->route('admin.chat');
    }

    public function message(Request $request)
    {
        $title = 'Чаты';
        $chats = Chat::where('company_id', auth()->user()->id)->where('deleted', false)->get();
        $selected_chat = Chat::where('id', $request->chat_id)->first();

        if ($request->new_message) {

            $message = new Message();
            $message->user_id = $request->user_id;
            $message->chat_id = $request->chat_id;
            $message->message = $request->new_message;
            $message->read = 0;
            $message->save();
        }

        return view('admin.chat', compact('title', 'chats', 'selected_chat'));
    }


    public function page($slug)
    {
        return abort(404);
    }
}
