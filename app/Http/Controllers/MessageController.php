<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Http\Requests;
use App\Message;
use App\Http\Requests\MessageRequest;
use App\User;
use Auth;

class MessageController extends Controller
{
    public function msg()
    {
        // 管理者權限才可執行

        return view('interview.msg');
    }

    public function msgStore(MessageRequest $request)
    {
        // 管理者權限才可執行

        $m = new Message;

        $m->start_date = trim($request->date1);
        $m->end_date = trim($request->date2);
        $m->msg = trim($request->msg);
        $m->department = trim($request->department);

        $m->save();

        return redirect('/msg/list')->with('status', 'Messages submit OK!');
    }

    public function msgList(User $user)
    {
        // 管理者權限才可執行

        if ($user->isMKTG(Auth::user()->id)) {
            $msg = Message::where('department', 'm')
                ->orderBy('id', 'desc')->paginate(30);
        } else {
            $msg = Message::orderBy('id', 'desc')->paginate(30);
        }

        return view('interview.msg_list', compact('msg'));
    }

    function msgEdit(Message $msg)
    {
        // 管理者權限才可執行

        return view('interview.msg_edit', compact('msg'));
    }

    function msgUpdate(Message $msg, MessageRequest $request)
    {
        // 管理者權限才可執行

        $msg->start_date = trim($request->date1);
        $msg->end_date = trim($request->date2);
        $msg->msg = trim($request->msg);
        $msg->department = trim($request->department);

        $msg->save();

        return redirect('/msg/list')->with('status', 'Message update OK!');
    }

    function msgDestroy(Message $msg, User $user)
    {
        // 管理者權限才可執行

        Message::destroy($msg->id);

        return redirect('/msg/list')->with('status', 'Message delete OK!');
    }
}
