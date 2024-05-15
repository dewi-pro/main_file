<?php

namespace App\Mail;

use Spatie\MailTemplates\TemplateMailable;

class PasswordReset extends TemplateMailable
{
    public $url;

    public function __construct($user, $url)
    {
        $this->url = $url;
    }
    
    public function getHtmlLayout(): string
    {
        return view('emails.layout')->render();
    }
}
