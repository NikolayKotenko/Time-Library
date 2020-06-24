<?php

namespace App\Http\Controllers;

use App\Models\TimeLibrary;
use Faker\Generator;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TimeLibraryController extends Controller
{
    public function index()
    {
        return response(TimeLibrary::all()->jsonSerialize(), Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        /* Закончил на добавлении новой записи в основную таблицу */
        $row = new TimeLibrary();
        $row->name = $request->input('name');
        $row->description = $request->input('desc');
        $row->tag = $request->input('tag');
        $row->save();

        return response($row->jsonSerialize(), Response::HTTP_CREATED);
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
