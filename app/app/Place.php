<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis as Redis;

class Place extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'places';

    const REDIS_STATUS_PROCESS = 'process';
    const REDIS_STATUS_UNPROCESS = 'unprocess';
    const REDIS_STATUS_BUSY = 'busy';

    public function booking()
    {
        return $this->hasOne('App\Booking');
    }

    /**
     * Method for check status of the place
     *
     * @return string
     */
    public function getRedisStatus()
    {
        $redis = Redis::connection();
        $keys = $redis->keys('*pid:'.$this->id);

        if (empty($keys))
            return Place::REDIS_STATUS_UNPROCESS;
        else
            return Place::REDIS_STATUS_PROCESS;
    }
}
