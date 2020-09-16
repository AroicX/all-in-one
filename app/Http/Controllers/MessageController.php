<?php

namespace App\Http\Controllers;

use App\Message;
use App\Models\CorpHRM\Employee;
use App\Models\CorpHRM\EmployeeProfile;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Pusher\Pusher;
use DB;


class MessageController extends Controller
{
   

    public function getUsers()
    {
        // get users in company expect loggedin user
        $my_id  = Auth::id();
        // return $my_id;
        $company_id = Auth::User()->company_id;
        $employees = User::where('company_id',$company_id)->where('id','!=',$my_id)->get();


        //count how many are unread from the selected ueser

        // $employees = DB::select("select users.id users.name, users.email, count(is_unread) as unread
        // from users LEFT JOIN messages ON users.id = message.from and is_unread = 0 and messags.to =  " . Auth::id()."
        // where users.id != " .Auth::id() ."
        // group by users.id, users,name,users.email");


        return view('message.index',compact('employees'));


    }

    public function getMessage($user_id)
    {
         $my_id  = Auth::id();
         $company_id = Auth::User()->company_id;


        // return $user_id;

        $messages = Message::where(function ($query) use ($user_id,$my_id ){
            $query->where('from', $my_id)->where('to',$user_id);
        })->orWhere(function ($query) use ($user_id,$my_id ){
            $query->where('from', $user_id)->where('to',$my_id);

        })->get();

        $user = User::where('company_id',$company_id)->where('id',$user_id)->first();


        // return $messages;

        return view('message.message',compact('messages','user'));

    }

    public function sendMessage(Request $request)
    {
       $from = Auth::id();
       $to = $request->receiver_id;
       $message = $request->message;

       $msg = new Message;
       $msg->from = $from;
       $msg->to = $to;
       $msg->message = $message;
       $msg->save();

      //pusher

      $options = array(
          'cluster' => 'eu',
          'useTLS' => true
      );

      $pusher = new Pusher(
          env('PUSHER_APP_KEY'),
          env('PUSHER_APP_SECRET'),
          env('PUSHER_APP_ID'),
          $options
      );

      $data = ['from' => $from, 'to' => $to]; //sending
      $pusher->trigger('my-channel', 'my-event',$data);
     

    }




}
