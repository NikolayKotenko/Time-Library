<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\ThingsShapeALifestyle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ThingsShapeALifestyleController extends Controller
{
    public function index()
    {
        return ThingsShapeALifestyle::all();
    }

    public function show($id)
    {
        return ThingsShapeALifestyle::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $company = ThingsShapeALifestyle::findOrFail($id);
        $company->update($request->all());

        return $company;
    }

    public function store(Request $request)
    {
        $company = ThingsShapeALifestyle::create($request->all());
        return $company;
    }

    public function destroy($id)
    {
        $company = ThingsShapeALifestyle::findOrFail($id);
        $company->delete();
        return '';
    }
}
