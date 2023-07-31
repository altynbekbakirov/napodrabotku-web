<?php

namespace App\Http\Controllers\Admin;

use App\Charts\ActionChart;
use App\Charts\GenderChart;
use App\Charts\IntersexChart;
use App\Charts\SexChart;
use App\Charts\UserChart;
use App\Charts\YearChart;
use App\Events\SendChatMessage;
use App\Models\Chat;
use App\Models\QuickWord;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Cookie;
use DateTime;

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

    public function profile(Request $request)
    {
        $title = 'Профиль';



        // if ($request->file('image')) {

        //     if (auth()->user()->avatar) @unlink(auth()->user()->avatar);
        //     $file = $request->file('image');

        //     $dir  = 'assets/media/users/';
        //     if (!file_exists($dir)) {
        //         mkdir($dir, 0777, true);
        //     }

        //     $name = Str::slug(auth()->user()->name, '-') . '.' . $file->getClientOriginalExtension();

        //     Image::make($file)->fit(400, 400)->save($dir . $name, 75);

        //     $user->avatar = $dir . $name;
        // }

        // $user->save();

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

        $chats = Chat::where('company_id', auth()->user()->id)->where('deleted', false)->with('messages')->orderByDesc(
            Message::select('created_at')
                ->whereColumn('chat_id', 'chats.id')
                ->orderByDesc('created_at')
                ->limit(1)
        )->get();

        $chat_id = $request->id;
        $selected_chat = null;
        $words = [];

        if ($chat_id) {
            $selected_chat = Chat::findOrFail($chat_id);
            $messages = Message::chat($chat_id)->get();
            $words = QuickWord::where('user_id', auth()->user()->id)->get();

            if ($messages) {
                foreach ($messages as $message) {
                    $message->read = true;
                    $message->save();
                }
            }
        }

        return view('admin.chat', compact('title', 'chats', 'selected_chat','words'));
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

    public function ajax_message(Request $request)
    {

        if ($request->new_message) {
            $current_date = date('Y-m-d H:i:s');
            $chat = Chat::where('id', $request->chat_id)->first();
            $chat->updated_at = $current_date;
            $chat->save();

            $message = new Message();
            $message->user_id = $request->user_id;
            $message->chat_id = $request->chat_id;
            $message->message = $request->new_message;
            $message->read = 0;
            $message->save();

            return $message;
        }

        return 'Failed';
    }

    public function add_quick_word(Request $request)
    {
        if ($request->word && $request->user_id) {
            $words = QuickWord::where('user_id', $request->user_id)->where('word', $request->word)->get();
            if (count($words) == 0) {
                $word = new QuickWord();
                $word->word = $request->word;
                $word->user_id = $request->user_id;
                $word->save();
                return $word;
            } else {
                return 'Failed';
            }
        }
        return 'Failed';
    }

    public function delete_quick_word(Request $request)
    {
        if ($request->word && $request->user_id) {
            $words = QuickWord::where('user_id', $request->user_id)->where('word', $request->word)->get();
            foreach ($words as $word) {
                $word->delete();
            }
            return 'Ok';
        }
        return 'Failed';
    }


    public function page($slug)
    {
        return abort(404);
    }
}
