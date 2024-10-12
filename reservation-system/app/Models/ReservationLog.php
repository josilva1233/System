<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;  

class ReservationLog extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'reservation_logs';
}