<?php

namespace App\Mail;
use Spatie\MailTemplates\TemplateMailable;


class TestMail extends TemplateMailable
{
    public function __construct()
    {
    }

    public function getHtmlLayout(): string
    {
        return view('emails.layout')->render();
    }
}
