<?php

namespace App\Http\Controllers;

use App\DataTables\BookingValueDataTable;
use App\Models\Booking;
use App\Models\BookingValue;
use App\Models\SeatWiseBooking;
use App\Models\TimeWiseBooking;
use Carbon\Carbon;
use Hashids\Hashids;

class BookingValueController extends Controller
{
    public function showBookingsForms($bookingId, BookingValueDataTable $dataTable)
    {
        $booking = Booking::find($bookingId);
        return $dataTable->with('booking_id', $bookingId)->render('booking-value.index', compact('booking'));
    }

    public function timingBookingvaluesShow($id)
    {
        try {
            $bookingValue   = BookingValue::find($id);
            $booking        = Booking::find($bookingValue->booking_id);
            $array          = json_decode($bookingValue->json);
        } catch (\Throwable $th) {
            return redirect()->back()->with('errors', $th->getMessage());
        }
        return view('booking-value.timing-view', compact('booking', 'bookingValue', 'array'));
    }

    public function seatsBookingvaluesShow($id)
    {
        try {
            $bookingValue   = BookingValue::find($id);
            $booking        = Booking::find($bookingValue->booking_id);
            $array          = json_decode($bookingValue->json);
        } catch (\Throwable $th) {
            return redirect()->back()->with('errors', $th->getMessage());
        }
        return view('booking-value.seats-view', compact('booking', 'bookingValue', 'array'));
    }

    public function destroy($id)
    {
        BookingValue::find($id)->delete();
        return redirect()->back()->with('success',  __('Booking deleted successfully.'));
    }

    public function editappoinment($id)
    {
        $hashids                    = new Hashids('', 20);
        $id                         = $hashids->decodeHex($id);
        $bookingValue               = BookingValue::find($id);
        $booking                    = Booking::find($bookingValue->booking_id);
        $array                      = json_decode($bookingValue->json);
        if ($booking->booking_slots == 'seats_wise_booking') {
            $seatWiseBooking        = SeatWiseBooking::where('booking_id', $booking->id)->first();
            $timeZone               = $seatWiseBooking->time_zone;
            $currdate               = Carbon::now($timeZone);
            $seatsessionJsons       = [];
            if ($seatWiseBooking->session_time_status == 1) {
                $seatsessionJsons   = json_decode($seatWiseBooking->session_time_json, true);
            }
            $sessionhtml            = '';
            $oldStartTime           = null;
            $nearestSlotKey         = null;
            $bookingStartDate       = $currdate->format('Y-m-d');
            $bookingEndDate         = $currdate->copy()->endOfYear()->format('Y-m-d');
            if ($seatWiseBooking->limit_time_status == 1) {
                $bookingStartDate   = $seatWiseBooking->start_date;
                $bookingEndDate     = $seatWiseBooking->end_date;
            }
            if ($seatWiseBooking->rolling_days_status == 1) {
                $bookingStartDate   = $currdate->format('Y-m-d');
                $bookingEndDate     = $currdate->copy()->addDays($seatWiseBooking->rolling_days)->format('Y-m-d');
            }
            if ($bookingStartDate <= $currdate->format('Y-m-d') && $bookingEndDate >= $currdate->format('Y-m-d')) {
                foreach ($seatsessionJsons as $seatsessionJsonkey => $seatsessionJson) {
                    $startTime     = Carbon::parse($seatsessionJson['start_time'], $timeZone);
                    $endTime       = Carbon::parse($seatsessionJson['end_time'], $timeZone);
                    $Attribute = '';
                    $class = '';
                    if ($startTime < $currdate) {
                        $Attribute = 'disabled';
                        $class = 'disabled';
                    } else {
                        if ($nearestSlotKey === null || ($oldStartTime != null && $startTime->diffInMinutes($currdate) < $oldStartTime->diffInMinutes($currdate))) {
                            $nearestSlotKey = $seatsessionJsonkey;
                        }
                    }
                    if ($bookingValue->booking_seats_date == $currdate->format('Y-m-d')) {
                        if ($bookingValue->booking_seats_session == $startTime->format('H:i') . '-' . $endTime->format('H:i')) {
                            $Attribute = 'checked';
                        }
                    } else {
                        if ($nearestSlotKey === $seatsessionJsonkey) {
                            $Attribute = 'checked';
                        }
                    }
                    $oldStartTime = $startTime;
                    $timeFormatValue = $startTime->format('H:i') . '-' . $endTime->format('H:i');
                    if ($seatWiseBooking->time_format  == '24_hour') {
                        $timeFormatLabel = $startTime->format('H:i') . ' to ' . $endTime->format('H:i');
                    } else {
                        $timeFormatLabel =  $startTime->format('h:i') . ' ' . $startTime->format('A') . ' to ' . $endTime->format('h:i') . ' ' . $endTime->format('A');
                    }
                    $sessionhtml .= '<input class="btn-check ' . $class . '" id="session_' . $timeFormatValue . '" name="session_time" ' . $Attribute . '
                                                type="radio" value="' . $timeFormatValue . '">
                                            <label for="session_' . $timeFormatValue . '"
                                                class="my-2 btn btn-outline-primary">' . $timeFormatLabel . '</label>';
                }
            }
            return view('booking-value.appointment.seat', compact('booking', 'bookingValue', 'seatWiseBooking', 'array', 'sessionhtml'));
        } elseif ($booking->booking_slots == 'time_wise_booking') {
            $timeWiseBooking        = TimeWiseBooking::where('booking_id', $booking->id)->first();
            $timeZone               = $timeWiseBooking->time_zone;
            $currdate               = Carbon::now($timeZone);
            $bookingStartDate       = $currdate->format('Y-m-d');
            $bookingEndDate         = $currdate->copy()->endOfYear()->format('Y-m-d');
            if ($timeWiseBooking->limit_time_status == 1) {
                $bookingStartDate   = $timeWiseBooking->start_date;
                $bookingEndDate     = $timeWiseBooking->end_date;
            }
            if ($timeWiseBooking->rolling_days_status == 1) {
                $bookingStartDate   = $currdate->format('Y-m-d');
                $bookingEndDate     = $currdate->copy()->addDays($timeWiseBooking->rolling_days)->format('Y-m-d');
            }
            $dayMapping = [
                'sunday'        => 0,
                'monday'        => 1,
                'tuesday'       => 2,
                'wednesday'     => 3,
                'thursday'      => 4,
                'friday'        => 5,
                'saturday'      => 6,
            ];
            $daysArray = explode(',', $timeWiseBooking->week_time);
            $selectedDays = array_map(function ($day) use ($dayMapping) {
                return $dayMapping[strtolower(trim($day))];
            }, $daysArray);
            return view('booking-value.appointment.time', compact('booking', 'bookingValue', 'array', 'timeWiseBooking', 'bookingStartDate', 'bookingEndDate', 'selectedDays', 'currdate'));
        }
    }

    public function SlotCancel($id)
    {
        $bookingValue                       = BookingValue::find($id);
        $bookingValue->booking_slots_date   = null;
        $bookingValue->booking_slots        = null;
        $bookingValue->booking_status       = 0;
        $bookingValue->save();
        return redirect()->back()->with('success', __('Slots cancelled successfully.'));
    }

    public function SeatCancel($id)
    {
        $bookingValue                           = BookingValue::find($id);
        $bookingValue->booking_seats_date       = null;
        $bookingValue->booking_seats_session    = null;
        $bookingValue->booking_seats            = null;
        $bookingValue->booking_status           = 0;
        $bookingValue->save();
        return redirect()->back()->with('success', __('Seats cancelled successfully.'));
    }
}
