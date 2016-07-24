<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis as Redis;

class Booking extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bookings';
    
    /**
     * Method for publish booking status of the place
     *
     * @param mixed $placeId
     * @param string $status
     *
     */
    public static function bookingNotify($placeId, $status = 'process')
    {
        $redis = Redis::connection();
        $data = ['placeId' => $placeId, 'status' => $status];

        $redis->publish('message', json_encode($data));
    }

}
