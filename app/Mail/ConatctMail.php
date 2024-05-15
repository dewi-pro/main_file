<?php

namespace App\Mail;

use Spatie\MailTemplates\TemplateMailable;

class ConatctMail extends TemplateMailable
{
    public $email;
    public $name;
    public $contactNo;
    public $message;

    public function __construct($details)
    {
        $this->name         = $details['name'];
        $this->email        = $details['email'];
        $this->contactNo    = $details['contact_no'];
        $this->message      = $details['message'];
    }

    public function getHtmlLayout(): string
    {
        return view('emails.layout')->render();
    }
}
