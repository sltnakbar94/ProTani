<?php

namespace App\Http\Controllers\Api\Common;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Village;
use App\Http\Resources\Api\V1\Common\VillageResource;

class VillageController extends Controller
{
    public function index(Request $request)
    {
        if($request->filled('public_path')) {
            return $this->fromPublicPath();
        }

        $form = collect($request->input('form'))->pluck('value', 'name');

        $search_term = $request->input('q');
        $page = $request->input('page');

        $district = $form->filter(function($value, $key){
            return $key === 'districts';
        });

        $selected_district = $district->first();

        if ($search_term)
        {
            $results = Village::where('district_id', $selected_district)->where('name', 'LIKE', '%'.$search_term.'%')->paginate(10);
        } else {
            $results = Village::where('district_id', $selected_district)->paginate(10);
        }

        return $results;
    }

    public function fromPublicPath()
    {
        return Village::where('district_id', request('district_id'))->get();
    }

    public function show($id)
    {
        return Village::find($id);
    }
}
