<?php

namespace App\Http\Controllers;

use Mail;
use App\Http\Controllers\Controller;

class MailController extends Controller
{
    public function basic_email()
    {
        $data = array('name' => "Virat Gandhi");
        Mail::send(['text' => 'mail'], $data, function ($message) {
            $message->to('abc@gmail.com', 'Tutorials Point')->subject('Laravel Basic Testing Mail');
            $message->from('xyz@gmail.com', 'Virat Gandhi');
        });
        echo  __('Basic email sent. check your inbox.');
    }

    public function html_email()
    {
        $data = array('name' => "Virat Gandhi");
        Mail::send('mail', $data, function ($message) {
            $message->to('abc@gmail.com', 'Tutorials Point')->subject('Laravel HTML Testing Mail');
            $message->from('xyz@gmail.com', 'Virat Gandhi');
        });
        echo  __('HTML email sent. check your inbox.');
    }

    public function attachment_email()
    {
        $data = array('name' => "Virat Gandhi");
        Mail::send('mail', $data, function ($message) {
            $message->to('abc@gmail.com', 'Tutorials Point')->subject('Laravel Testing Mail with Attachment');
            $message->attach('C:\laravel-master\laravel\public\uploads\image.png');
            $message->attach('C:\laravel-master\laravel\public\uploads\test.txt');
            $message->from('xyz@gmail.com', 'Virat Gandhi');
        });
        echo  __('Email sent with attachment. check your inbox.');
    }
}
