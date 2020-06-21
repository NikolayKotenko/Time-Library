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
    public static function wtf()
    {
        return $tags = TimeLibrary::find(1);
    }
}
