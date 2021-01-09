<?php

namespace App\Http\Controllers\Api\Common;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Regency;
use App\Models\District;
use App\Http\Resources\Api\V1\Common\RegencyResource;
use App\Http\Resources\Api\V1\Common\DistrictResource;

class RegencyController extends Controller
{
    public function index(Request $request)
    {
        $form = collect($request->input('form'))->pluck('value', 'name');

        $search_term = $request->input('q');
        $page = $request->input('page');
        $province = $form->filter(function($value, $key){
            return $key === 'provinces';
        });

        $selected_province = $province->first();
        if ($search_term)
        {
            $results = Regency::where('province_id', $selected_province)->where('name', 'LIKE', '%'.$search_term.'%')->paginate(10);
        } else {
            $results = Regency::where('province_id', $selected_province)->paginate(10);
        }

        // $results = Regency::whereIn('id', [3271, 3275, 3671, 3674, 3276])->paginate(10);

        return $results;
    }

    public function show($id)
    {
        return Regency::find($id);
    }

    /**
     * API
     */

    public function getIndex()
    {
        // return all regency
        return RegencyResource::collection(Regency::all());
    }

    public function getShow($id)
    {
        // return regency
        return new RegencyResource(Regency::find($id));
    }

    public function getDistricts($id)
    {
        // return all districts with regency_id above
        return DistrictResource::collection(District::whereRegencyId($id)->get());
    }
}
