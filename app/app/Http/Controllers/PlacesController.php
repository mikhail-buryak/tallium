<?php

namespace App\Http\Controllers;

use App\Place;
use Yajra\Datatables\Facades\Datatables;

class PlacesController extends Controller
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

    public function getUnBookingPlaces()
    {
        $places = Place::leftJoin('sections', 'places.section_id', '=', 'sections.id')
            ->leftJoin('bookings', 'places.id', '=', 'bookings.place_id')
            ->select(['places.id', 'places.row', 'places.price', 'places.place', 'sections.title', 'bookings.id as booking_id']);

        return Datatables::of($places)
            ->editColumn('id', '{{$id}}')
            ->editColumn('section', '{{ str_limit($title, 60) }}')
            ->editColumn('row', '{{ $row }}')
            ->editColumn('place', '{{ $place }}')
            ->editColumn('price', '{{ $price }} BC')
            ->addColumn('action', function ($places) {

                if($places->booking_id)
                    $button = '<button type="button" class="btn btn-xs btn-danger">Busy</button>';
                else {
                    $redisStatus = $places->getRedisStatus();
                    if($redisStatus == Place::REDIS_STATUS_PROCESS)
                        $button = '<button type="button" data-id="'.$places->id.'" data-action="/booking/'.$places->id.'" class="btn btn-xs btn-warning btn-modal">Process</button>';
                    else
                        $button = '<button type="button" data-id="'.$places->id.'" data-action="/booking/'.$places->id.'" class="btn btn-xs btn-primary btn-modal">Booking</button>';
                }
                
                return $button;
            })
            ->make(true);
    }

    public function getPlaces()
    {
        return view('booking.index');
    }
}
