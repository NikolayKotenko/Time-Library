<?php

namespace App\Http\Controllers;

use App\Models\TimeLibrary;
use App\Models\TrackingProgressTag;
use Faker\Generator;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TimeLibraryController extends Controller
{
    public function index()
    {
//        return response(TimeLibrary::all()->jsonSerialize(), Response::HTTP_OK);
        /* Тестирование свящи между таблицами */
//        $data_tm = DB::table('time_libraries')->lists('id');

//        $a = new $data_tm;
//        $a->getTableColumns();
//        $resp= [];
//        while($row = mysqli_fetch_array($data_tm)) {
//            $resp[$row['Field']] = '';
//        }
//        return $data_tm;
//        return $tags = TrackingProgressTag::find(1);
    }
    public function show($id)
    {
//        return response(TimeLibrary::all()->jsonSerialize(), Response::HTTP_OK);
        /* Тестирование свящи между таблицами */
//        return $tags = TrackingProgressTag::find(1);

        return response(TimeLibrary::GetDataForTag($id));
    }

    public function store(Request $request)
    {
        /* Добавление новой записи в основную таблицу */
        $timeLibrary = TimeLibrary::create($request->all());

        /* Добавляение записи ослеживания времени по тэгам, записывается через основную таблицу */
        $timeLibrary->TrackingProgressTag()->create($request->only([
            'minutes',
            'hours',
            'number_of_seasons',
            'series',
            'number_of_pages',
            'percent',
            'total_time_audio_books',
        ]));

        return response($timeLibrary->jsonSerialize(), Response::HTTP_CREATED);
//        return response($row3->id);
    }

    public function update(Request $request, $id)
    {
        $timeLibrary = TimeLibrary::findOrFail($id);
        $timeLibrary->fill($request->all());

        /* Добавляение записи ослеживания времени по тэгам, записывается через основную таблицу */
        $timeLibrary->TrackingProgressTag->fill($request->only([
            'minutes',
            'hours',
            'number_of_seasons',
            'series',
            'number_of_pages',
            'percent',
            'total_time_audio_books',
        ]));
        /* Сохраняем данные в 2 таблицах (связанная тоже сохраняется) */
        $timeLibrary->push();

        return response($timeLibrary->jsonSerialize(), Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $timeLibrary = TimeLibrary::findOrFail($id);
        $timeLibrary->TrackingProgressTag()->delete();
        $timeLibrary->delete();

        return response($id, Response::HTTP_OK);
    }

    public function getColumnForTag(){

        return 'hhhhh';
//        return response(TimeLibrary::where('tag_id', '5'));
    }
}
