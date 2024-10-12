<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = ['user_id', 'reservation_date', 'reservation_time', 'resource', 'is_confirmed'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
