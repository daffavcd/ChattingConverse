<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Broadcast;
use Pusher\Pusher;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $contacts = DB::table('users as u')
            ->select('u.*')
            ->where('u.id', '!=', Auth::id())
            ->orderByDesc('id')
            ->get();

        $myprofile = \App\User::where('id', Auth::id())->first();
        return view('chat/parent-chat', ['contacts' => $contacts, 'myprofile' => $myprofile]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $data = new \App\Message;

        $data->text = $request->text;
        $data->sender_id = $user->id;
        $data->sent_on = date("Y-m-d h:i:s");
        $data->has_read = 0;
        $data->recipient_id = $request->recepient_id;

        $data->save();

        $to = $data->recipient_id;
        $from = $data->sender_id; // sending from and to user id when pressed enter
        event(new \App\Events\MessageSent($to, $from));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($user_id)
    {
        $my_id = Auth::id();
        $to = \App\User::where('id', $user_id)->first();
        return view('chat/index', ['to' => $to]);
    }
    public function showContact($id)
    {  
        $contacts = DB::table('users as u')
            ->select('u.*')
            ->where('u.id', '!=', Auth::id())
            ->orderByDesc('id')
            ->get();

        return view('chat/contacts', ['contacts' => $contacts,'recipient_id'=>$id]);
    }
    public function showMessages($user_id)
    {
        $my_id = Auth::id();
        \App\Message::where(['sender_id' => $user_id, 'recipient_id' => $my_id])->update(['has_read' => 1]);

        DB::enableQueryLog();
        // ambil message
        $messages = DB::table('messages as m')
            ->select('m.*', 'u.name as sender_name', 'u2.name as recipient_name', 'u.profile_picture as sender_pp')
            ->leftJoin('users as u', 'u.id', '=', 'm.sender_id')
            ->leftJoin('users as u2', 'u2.id', '=', 'm.recipient_id')
            ->where([
                ['m.recipient_id', '=', $user_id],
                ['m.sender_id', '=', $my_id],
            ])
            ->orWhere([
                ['m.recipient_id', '=', $my_id],
                ['m.sender_id', '=', $user_id],
            ])
            ->orderBy('m.id', 'asc')
            ->get();
        // dd($messages);
        $to = \App\User::where('id', $user_id)->first();
        return view('chat/messages', ['messages' => $messages], ['to' => $to]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
