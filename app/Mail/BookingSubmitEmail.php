<?php

namespace App\Mail;

use App\Models\FormValue;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingSubmitEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $bookingValue;
    protected $bookingValueArray;

    public function __construct($bookingValue, $bookingValueArray)
    {
        $this->bookingValue = $bookingValue;
        $this->bookingValueArray = $bookingValueArray;
    }

    public function build()
    {
        return $this->markdown('emails.booking_submit')->with(['booking_value' => $this->bookingValue, 'booking_valuearray' => $this->bookingValueArray])->subject('New survey Submited - ' . $this->bookingValue->Booking->business_name);
    }
}
