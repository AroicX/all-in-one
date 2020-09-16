<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Model\CorpPay\Emailer;

class EmailController extends Controller
{
    public function sendMail($type,$to)
    {
        $mail = Emailer::where('type', $type)->first();
        $recipient = $to;
        //get the $title and content from the 
        Mail::send(
            'CorpPay.emails.mail', ['title'=>null,'content'=>$mail->content], function ($message) use ($recipient) {
                //get $method->from() parameter from the company table
                $message->from('adekunleoseni47@gmail.com', 'Adekunle');
                $message->to($recipient);
            }
        );

        return response()->json(['message'=>'Request Completed']);
    }

    //test function to preview mail.blade 
    public function seeMail()
    {
        return view('CorpPay.emails.mail');
    }

    //methods for getting and setting Email Settings
    public function getEmailSettings()
    {
        return view('CorpPay.emails.set_email');
    }

    public function addEmailSettings(Request $request)
    {

        $template = Emailer::where('type', '=', $request->type)->first();
        if($template === null) {
            $new = new Emailer();
            $new->type = $request->type;
            $new->title = $request->title;
            $new->content = $request->get('content');
            $new->save();

            $success = "created";
            return view('CorpPay.emails.set_email', compact('success'));
        }
        else{
            $template->title = $request->title;
            $template->content = $request->get(content);
            $template->save();

            $success = "updated";
            return view('CorpPay.emails.set_email', compact('success'));
        }
        
    }
}
