<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function sendWelcomeEmail()
    {
        $title = 'Email text';
        $body = 'Thank you for participating!';

        Mail::to('eliphas.sn@gmail.com')->send(new WelcomeMail($title, $body));

        return "Email sent successfully!";
    }
}
