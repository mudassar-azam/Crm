<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ActivityMail;
use App\Models\Email;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function sendMail(Request $request){
        $rules = [
            'email' => 'required',
            'email_body' => 'required',
            'subject' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errors = [];
            foreach ($validator->errors()->getMessages() as $field => $messages) {
                $errors[] = [
                    'field' => $field,
                    'message' => $messages[0]
                ];
            }

            return response()->json(['success' => false, 'errors' => $errors], 422);
        }
        $activity_id = $request->input('activity_id');
        $email = Email::create([
            'email' => $request->input('email'),
            'location' => $request->input('location'),
            'email_body' => $request->input('email_body'),
            'subject' => $request->input('subject'),
            'express' => $request->input('express'),
            'email_note' => $request->input('email_note'),
        ]);
        $emailData = $request->only(['email', 'location', 'email_body', 'subject', 'express', 'email_note']);
        Mail::to($request->input('email'))->send(new ActivityMail($emailData));
        return response()->json(['success' => true, 'message' => 'Email sent successfully!' , 'activityId' => $activity_id]);
    }
}
