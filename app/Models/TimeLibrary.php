<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeLibrary extends Model
{
//    protected $fillable = ['name'];
//    protected $guarded = [];

    public function tags()
    {
        return $this->hasOne('App\Models\Tag');
    }
    public function TrackingProgressTag()
    {
        return $this->hasOne('App\Models\TrackingProgressTag');
    }
}
