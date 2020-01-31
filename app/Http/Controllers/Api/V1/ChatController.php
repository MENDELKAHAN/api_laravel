<?php

namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\User;
use App\Chat;
use Auth;

class ChatController extends Controller
{
    public function __construct()
    {
        // parent::__construct();
         $this -> activeUserId = 1;
    }

//get users
    public function index()
    {
        $users = User::where('id', '<>', $this -> activeUserId)->get();
        $users = $this -> message_count($users);   
        foreach ($users as $user) {
            $chats = $this -> show($user -> id);
            $chatsOrder = array();
            foreach ($chats as $chat) {
                if($chat-> receiver == $this -> activeUserId){
                    $chatsOrder[] = array('from' => $chat);
                }else{
                     $chatsOrder[] = array('to' => $chat);
                }
            }
               $user -> chatHistory = $chatsOrder;
            }    
            
             return response()->json($users);
        
    }

// sending a chat
    public function store(Request $request )
    {
     
        $chat = new Chat;
        $chat->message = $request->message;
        $chat->receiver = $request->receiver;
        $chat->sender = $this -> activeUserId;
        $chat->status = 0;
        $chat->save();
        $return["success"] = "sent";
        echo json_encode($return);

    }


    public function show($id)
    {
        $this -> id = $id;
        //update chats mark as readauth
        Chat::where('receiver', '=', $this -> activeUserId)
        ->where('sender', '=', $this -> id)    
        ->update(['status' => 1]);

        //get chat
        $chat = Chat::Where(function($query)
        {
            $query->where('sender', '=', $this -> activeUserId)
                  ->where('receiver', '=', $this -> id);
        }) ->orWhere(function($query)
        {
            $query->where('receiver', '=', $this -> activeUserId)
                  ->where('sender', '=', $this -> id);
        })->get();

        return $chat;
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    
    // give array of users 
    // returns array of users with unread messages
    private function message_count($users)
    {
        foreach($users as $user){
            $user -> total = Chat::where('chats.sender' , '=', $user->id)
            ->where('status', '=', '0')
            ->where('receiver', '=', $this -> activeUserId)
            ->count();
        }
        return $users;
    }

    public function updateOnActiveChat($id)
    {
        $chat = Chat::where('receiver', '=', $this -> activeUserId)
        ->where('sender', '=', $id)
        ->where('status', '=', 0)
        ->exists();
        return $chat ? 'true' : 'false';
    }

    public function getNewMessagesAlert()
    {
        $chat = DB::table('chats')
            ->select(DB::raw('chats.message, chats.id as chat_id, users.name as name'))
            ->where('receiver', '=', $this -> activeUserId)
            ->where('notified', '=', 0)
            ->join('users', 'users.id', '=', 'chats.sender')
            ->first();

        if(is_null ($chat)){
            return response()
            ->json(['result' => 'false']);
        }else{
            $chat_update = Chat::find($chat -> chat_id);
            $chat_update->notified = 1;
            $chat_update->save();

         return response()
            ->json(['name' => $chat -> name, 'message' => $chat -> message]);
        }
    }
}