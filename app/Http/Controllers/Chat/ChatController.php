<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $data = new \App\Chat;

        $data->text = $request->text;
        $data->sender_id = $user->id;
        $data->recipient_id = $request->recipient_id;

        $data->save();
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
        DB::enableQueryLog();
        // Setelah diklik langsung update sudah dibaca
        \App\Message::where(['sender_id' => $user_id, 'recipient_id' => $my_id])->update(['has_read' => 1]);

        // ambil message
        $messages = DB::table('messages as m')
            ->select('m.*', 'u.name as sender_name', 'u2.name as recipient_name', 'u.profile_picture as sender_pp', 'u2.profile_picture as recipient_pp')
            ->leftJoin('users as u', 'u.id', '=', 'm.sender_id')
            ->leftJoin('users as u2', 'u2.id', '=', 'm.recipient_id')
            ->where('m.recipient_id',$my_id)
            ->where('m.sender_id',$user_id)
            ->orderByDesc('m.id')
            ->get();
        // dd($messages);
        return view('chat/index', ['messages' => $messages]);
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
