<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrackingProgressTag extends Model
{
    protected $fillable = [
        'minutes',
        'hours',
        'number_of_seasons',
        'series',
        'number_of_pages',
        'percent',
        'total_time_audio_books',
    ];

    public function TetherTimeLibrary()
    {
        return $this->belongsTo('App\Models\TimeLibrary');
    }
}
