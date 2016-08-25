<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactFormRequest;
use Validator;
use App\Http\Mailer\SendMail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $validator = $this->getValidator($request);
        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return ['error' => $error];
        }

        $name = $request->input('name');
        $email = $request->input('email');
        $subject = $request->input('subject');
        $message = $request->input('message');

        try {
            SendMail::contactMessage($name, $email, $subject, $message);
        } catch (Exception $e) {
            return ['error' => 'Sorry, an unexpected error occured.'];
        }

        return ['success' => 'Thank you for your message.'];
    }

    public function getValidator($request)
    {
        $messages = [
            'name.required'    => 'Please enter your name.',
            'email.required'   => 'Please enter an email address.',
            'email.email'      => 'Please enter a valid email address.',
            'subject.required' => 'Please enter a subject.',
            'message.required' => 'Please enter a message.',
        ];

        $rules = [
            'name'    => 'required|min:3',
            'email'   => 'required|email',
            'subject' => 'required|min:3',
            'message' => 'required|min:3',
        ];

        return Validator::make($request->all(), $rules, $messages);
    }
}
