<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Events\MessageSent;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    public function sendMessage(Request $request) {
        //Log::info('Incoming data:', $request->all());
        //dump($request->all());
        
        $message = Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'group_id' => $request->group_id,
            'content' => $request->content,
        ]);
    
        broadcast(new MessageSent($message))->toOthers();
    
        return response()->json(['message' => $message]);
    }
}
?>
