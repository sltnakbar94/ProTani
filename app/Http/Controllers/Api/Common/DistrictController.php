<?php

namespace App\Http\Controllers\Api\Common;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\District;
use App\Http\Resources\Api\V1\Common\DistrictResource;

class DistrictController extends Controller
{
    public function index(Request $request)
    {
        if($request->filled('public_path')) {
            return $this->fromPublicPath();
        }

        $form = collect($request->input('form'))->pluck('value', 'name');

        $search_term = $request->input('q');
        $page = $request->input('page');

        $regency = $form->filter(function($value, $key){
            return $key === 'regency_id';
        });

        $selected_regency = $regency->first();

        if ($search_term)
        {
            $results = District::where('regency_id', $selected_regency)->where('name', 'LIKE', '%'.$search_term.'%')->paginate(10);
        } else {
            $results = District::where('regency_id', $selected_regency)->paginate(10);
        }

        return $results;
    }

    public function show($id)
    {
        return District::find($id);
    }

    public function fromPublicPath()
    {
        return District::where('regency_id', request('regency_id'))->get();
    }

    /**
     * API
     */
    public function getShow($id)
    {
        // return district id
        return new DistrictResource(District::find($id));
    }
}
