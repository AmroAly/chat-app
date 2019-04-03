<?php

namespace App\Http\Controllers;

use App\Events\MessagePushed;
use Illuminate\Http\Request;
use App\Conversation;
use App\Message;
use Redis;

class MessageController extends Controller
{
    /**
     *  Save a message into the database
     *  @param Request
     * @return Response
     */
    public function store(Request $request)
    {
        $conversation = Conversation::findOrFail($request->conversation_id);
        if($conversation->user1 == $request->user()->id || $conversation->user2 == $request->user()->id){
            $message = new Message;
            $message->conversation_id = $request->conversation_id;
            $message->user_id = $request->user()->id;
            $message->text = $request->text;
            $message->is_read = 0;
            $message->save();

            $receiver_id = ($conversation->user1 == $request->user()->id)? $conversation->user2 : $conversation->user1;
            $data = [
                'conversation_id' =>$request->conversation_id,
                'text'=> $request->text,
                'client_id' => $receiver_id
            ];
            $redis = Redis::connection();
            $redis->publish('message', json_encode($data));
            // event(new MessagePushed($data));

            return response()->json([
                "message" => $message
            ]);
        }
        return response()->json("permission error");
    }
}
