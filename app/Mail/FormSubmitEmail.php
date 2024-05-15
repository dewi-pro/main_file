<?php

namespace App\Mail;

use App\Models\FormValue;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FormSubmitEmail extends Mailable
{
    use Queueable, SerializesModels;
    protected $formValue;
    protected $formValueArray;

    public function __construct(FormValue $formValue, $formValueArray)
    {
        $this->formValue        = $formValue;
        $this->formValueArray   = $formValueArray;
    }

    public function build()
    {
        return $this->markdown('emails.form-submit')->with(['form_value' => $this->formValue, 'form_valuearray' => $this->formValueArray])->subject('New survey Submited - ' . $this->formValue->Form->title);
    }
}
