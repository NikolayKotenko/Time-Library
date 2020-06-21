<?php

namespace App\Http\Controllers;

use App\Models\Crud;
use App\Models\TimeLibrary;
use Faker\Generator;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class TimeLibraryController extends Controller
{
    public function index()
    {
        return response(TimeLibrary::all()->jsonSerialize(), Response::HTTP_OK);
    }

    public function create()
    {
        /* Закончил на добавлении новой записи в основную таблицу */
        $row = new TimeLibrary();
        $row->name = 'wtf';
        $row->description = 'desc';
        $row->tag = 'books';
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
