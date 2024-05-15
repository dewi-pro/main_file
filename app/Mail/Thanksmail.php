<?php

namespace App\Mail;

use App\Models\FormValue;
use Spatie\MailTemplates\TemplateMailable;

class Thanksmail extends TemplateMailable
{
    public $title;
    public $thanksMsg;
    public $email;
    public $image;

    public function __construct(FormValue $form_value)
    {
        $this->title = $form_value->Form->title;
        $this->email = $form_value->Form->email;
        $this->thanksMsg = $form_value->Form->thanks_msg;
        if (!empty($form_value->Form->logo)) {
            $this->image =  asset('storage/app/' . $form_value->Form->logo);
        }
    }

    public function getHtmlLayout(): string
    {
        return view('emails.layout')->render();
    }
}
