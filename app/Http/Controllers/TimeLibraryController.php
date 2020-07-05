<?php

namespace App\Http\Controllers;

use App\Models\TimeLibrary;
use App\Models\TrackingProgressTag;
use Faker\Generator;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TimeLibraryController extends Controller
{
    public function index()
    {
//        return response(TimeLibrary::all()->jsonSerialize(), Response::HTTP_OK);
        /* Тестирование свящи между таблицами */
        return $tags = TrackingProgressTag::find(1);
    }

    public function store(Request $request)
    {
        /* Добавление новой записи в основную таблицу */
        $timeLibrary = new TimeLibrary();
        $timeLibrary->name = $request->name;
        $timeLibrary->description = $request->desc;
        $timeLibrary->tag = $request->tag;
        $timeLibrary->save();

        /* Добавляение записи ослеживания времени по тэгам, записывается через основную таблицу */
        $trackingProgressTag = new TrackingProgressTag();
        $trackingProgressTag->minutes = $request->minutes;
        $trackingProgressTag->hours = $request->hours;
        $trackingProgressTag->number_of_seasons = $request->number_of_seasons;
        $trackingProgressTag->series = $request->series;
        $trackingProgressTag->number_of_pages = $request->number_of_pages;
        $trackingProgressTag->percent = $request->percent;
        $trackingProgressTag->total_time_audio_books = $request->total_time_audio_books;
        $timeLibrary->TrackingProgressTag()->save($trackingProgressTag);

        return response($timeLibrary->jsonSerialize(), Response::HTTP_CREATED);
//        return response($row3->id);
    }

    public function update(Request $request, $id)
    {
        $row = TimeLibrary::findOrFail($id);
        $row->name = $request->name;
        $row->description = $request->description;
        $row->tag = $request->tag;
        $row->save();

        return response(null, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        TimeLibrary::destroy($id);

        return response(null, Response::HTTP_OK);
    }
}
