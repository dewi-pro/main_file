<?php

namespace App\Mail;

use App\Models\BookingValue;
use Hashids\Hashids;
use Spatie\MailTemplates\TemplateMailable;

class BookingThanksmail extends TemplateMailable
{
    public $title;
    public $thanksMsg;
    public $image;
    public $link;

    public function __construct(BookingValue $bookingValue)
    {
        $this->title = $bookingValue->Booking->business_name;
        if (!empty($bookingValue->Booking->business_logo)) {
            $this->image = asset('storage/app/' . $bookingValue->Booking->business_logo);
        }
        $this->thanksMsg  = strip_tags('Your booking is successfully completed!');
        $hashids          = new Hashids('', 20);
        $id               = $hashids->encodeHex($bookingValue->id);
        $route            = route('appointment.edit', $id);
        $this->link       = $route;
    }

    public function getHtmlLayout(): string
    {
        return view('mails.layout')->render();
    }
}
