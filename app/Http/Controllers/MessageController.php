<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Events\MessageSent;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index($roomId = 'geral')
    {
        return Message::with('user')
            ->where('room_id', $roomId)
            ->oldest()
            ->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'room_id' => 'required|string',
        ]);

        $message = $request->user()->messages()->create([
            'content' => $request->content,
            'room_id' => $request->room_id,
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return response()->json($message->load('user'));
    }
}
