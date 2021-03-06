<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Events\ChatEvent;
class ChatController extends Controller
{
    public function send(Request $request){
    	$user=User::find(Auth::id());
    	event(new ChatEvent($request->message,$user));
    }
}
