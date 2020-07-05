<?php

namespace App\Http\Controllers;

use App\Models\TrackingProgressTag;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TrackingProgressTagController extends Controller
{
    public function index()
    {
        //
    }
    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        /* Закончил на добавлении новой записи в основную таблицу */
        $row = new TrackingProgressTag();
        $row->minutes = $request->input('minutes');
        $row->hours = $request->input('hours');
        $row->number_of_seasons = $request->input('number_of_seasons');
        $row->series = $request->input('series');
        $row->number_of_pages = $request->input('number_of_pages');
        $row->percent = $request->input('percent');
        $row->total_time_audio_books = $request->input('total_time_audio_books');
        $row->save();

        return response($row->jsonSerialize(), Response::HTTP_CREATED);
    }
    public function show(TrackingProgressTag $trackingProgressTag)
    {
        //
    }
    public function edit(TrackingProgressTag $trackingProgressTag)
    {
        //
    }
    public function update(Request $request, TrackingProgressTag $trackingProgressTag)
    {
        //
    }
    public function destroy(TrackingProgressTag $trackingProgressTag)
    {
        //
    }
}
