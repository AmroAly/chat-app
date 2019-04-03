<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Conversation;
use App\User;

class ConversationController extends Controller
{
     /**
     *  Store a conversation
     *  @param Request
     * @return Response
     */
    public function store(Request $request)
    {
        $c1 = Conversation::where('user1',$request->user()->id)->where('user2',$request->user_id)->count();
        $c2 = Conversation::where('user2',$request->user()->id)->where('user1',$request->user_id)->count();

        if($c1 == 0 and $c2 == 0) {
            $c = new Conversation();
            $c->user1 = $request->user()->id;
            $c->user2 = $request->user_id;
            $c->save();
    
            return response()->json(['success' => true], 201);
        }
    }

    /**
     *  get a conversation
     *  @param Request
     *  @param id
     * @return Response
     */
    public function getConversationByUserId(Request $request, $id)
    {
        $c1 = Conversation::where('user1',$request->user()->id)->where('user2',$id)->first();
        $c2 = Conversation::where('user2',$request->user()->id)->where('user1',$id)->first();

        if($c1) 
            return response()->json([
                'messages' => $c1->messages,
                'conv_id' => $c1->id    
            ]);
        if($c2)
            return response()->json([
                'messages' => $c2->messages,
                'conv_id' => $c2->id
            ]);

        // we have not found any conversation between
        // the two users so we will create one and 
        // send its id
        if(User::find($id)) {
            $c = new Conversation();
            $c->user1 = $request->user()->id;
            $c->user2 = $id;
            $c->save();
    
            return response()->json([
                'messages' => [],
                'conv_id' => $c->id    
            ]);
        }
    }
}
