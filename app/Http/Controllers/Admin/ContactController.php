<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Mail\Mailer;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Brian2694\Toastr\Facades\Toastr;

class ContactController extends Controller
{
    public function contact(Request $request)
    {
        Contact::where('has_read', null)->update(['has_read' => 1]);

        if($request->search){
            $contact = Contact::where('email', 'like', "%$request->search%")
            ->orWhere('address', 'like', "%$request->search%")
            ->orWhere('phone', 'like', "%$request->search%")
            ->orWhere('message', 'like', "%$request->search%")
            ->orWhere('name', 'like', "%$request->search%")->paginate(20);
        }else{
            $contact = Contact::paginate(20);
        }
        
        $page_data['contacts'] = $contact;
        return view('admin.contact.index', $page_data);
    }
    public function contact_delete($id)
    {
        Contact::where('id', $id)->delete();
        Session::flash('success', get_phrase('Contact delete successfully!'));
        return redirect()->back();
    }
    public function contact_reply_form($id){
        $page_data['contact'] = Contact::where('id', $id)->first();
        return view('admin.contact.reply', $page_data);
    }
    public function contact_reply_send(Request $request)
    {
        $email = Contact::where('id', $request->send_to)->first();
        $this->send_mail($email->email, $request->subject, $request->reply_message);
        $data['replied'] = 1;
        $email           = Contact::where('id', $request->send_to)->update($data);
        Session::flash('success', get_phrase('Email sent successfully'));
        return redirect()->route('admin.contact');
    }

    public function send_mail($user_email, $subject, $description)
    {
        config([
            'mail.mailers.smtp.transport'  => get_settings('smtp_protocol'),
            'mail.mailers.smtp.host'       => get_settings('smtp_host'),
            'mail.mailers.smtp.port'       => get_settings('smtp_port'),
            'mail.mailers.smtp.encryption' => get_settings('smtp_crypto'),
            'mail.mailers.smtp.username'   => get_settings('smtp_username'),
            'mail.mailers.smtp.password'   => get_settings('smtp_password'),
            'mail.from.address'            => get_settings('smtp_username'),
            'mail.from.name'               => get_settings('system_title'),
        ]);


        $mail_data['subject']     = $subject;
        $mail_data['description'] = $description;

        $send = Mail::to($user_email)->send(new Mailer($mail_data));
        return $send;
    }
}
