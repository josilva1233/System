<?php

namespace App\Models;

//use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Database\Eloquent\Model;

class MongoTask extends Model
{
    protected $connection = 'mongodb';
    protected $fillable = ['title', 'description'];
}
