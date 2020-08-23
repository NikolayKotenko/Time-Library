<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TimeLibrary extends Model
{
    protected $fillable = [
        'name', 'description', 'tag_id',
    ];
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
    public static function GetDataForTag($id){
        /* Получаем имя тэга чтобы вы зависимости от имени  дергать только нужные столбцы из базы ч*/
        $db_name_tag = DB::table('tags')->where('id', $id)->get('name');

        $name_tag = '';
        foreach ($db_name_tag as $tag){
            $name_tag = $tag->name;
        }

        /* Выборка из стандартных колонок для всех тэгов */
        $time_libraries = DB::table('time_libraries')->where('tag_id', $id)
            ->join('tracking_progress_tags', 'tracking_progress_tags.time_library_id', '=', 'time_libraries.id')
            ->select('time_libraries.*');

        /* Добавляем нужные колонки в зависимости от типа тэга */
        if ($name_tag === 'films' || $name_tag === 'podcasts' || $name_tag === 'video-self-dev'){
            $time_libraries->addSelect('tracking_progress_tags.minutes', 'tracking_progress_tags.hours');
        }
        else if ($name_tag === 'audio-books'){
            $time_libraries->addSelect('tracking_progress_tags.percent', 'tracking_progress_tags.total_time_audio_books');
        }
        else if ($name_tag === 'books'){
            $time_libraries->addSelect('tracking_progress_tags.percent', 'tracking_progress_tags.number_of_pages');
        }
        else if ($name_tag === 'serials' || $name_tag === 'anime'){
            $time_libraries->addSelect('tracking_progress_tags.number_of_seasons', 'tracking_progress_tags.series', 'tracking_progress_tags.minutes');
        }

            return $time_libraries->get();
    }
}
