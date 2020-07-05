<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrackingProgressTag extends Model
{
    public function TetherTimeLibrary()
    {
        return $this->belongsTo('App\Models\TimeLibrary');
    }
}
