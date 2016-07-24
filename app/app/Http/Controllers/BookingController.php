<?php

namespace App\Http\Controllers;

//use phpcent\Client as Centrifugo;
use App\Place;
use App\Booking;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Redis as Redis;

class BookingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function getFire()
    {
        $redis = Redis::connection();
        $keys = $redis->keys('*');
        print_r($keys);

/*                $redis = Redis::connection();
                $redis->flushall();*/
    }

    public function getBooking($id, Request $request)
    {
        $validator = Validator::make(['id' => $id], [
            'id' => ['required', 'exists:places,id', 'unique:bookings,place_id'],
        ]);

        if ($validator->fails() || !$request->ajax())
            return response()->json($validator->errors(), 400);

        $place = Place::find($id);

        return view('booking.getBooking')->with('place', $place);
    }

    public function postBooking($id, Request $request)
    {
        $validator = Validator::make(array_merge(['id' => $id], $request->all()), [
            'id' => ['required', 'exists:places,id', 'unique:bookings,place_id'],
            'user_info' => ['required', 'string', 'max:255']
        ]);

        if ($validator->fails())
            return response()->json($validator->errors(), 400);

        $booking = new Booking();
        $booking->user_info = $request->input('user_info');
        $place = Place::find($id);
        $place->booking()->save($booking);

        Booking::bookingNotify($place->id, Place::REDIS_STATUS_BUSY);

        return response()->json( ['status' => 'success'] );
    }
}
