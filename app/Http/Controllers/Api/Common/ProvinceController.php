<?php

namespace App\Http\Controllers\Api\Common;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Province;
use App\Models\Regency;
use App\Http\Resources\Api\V1\Common\ProvinceResource;
use App\Http\Resources\Api\V1\Common\RegencyResource;

class ProvinceController extends Controller
{
    public function index(Request $request)
    {
        $search_term = $request->input('q');
        $page = $request->input('page');

        $results = Province::active()->where('name', 'LIKE', '%'.$search_term.'%')->paginate(10);

        return $results;
    }

    public function show($id)
    {
        return Province::find($id);
    }

    /**
     * API
     */
    public function getIndex()
    {
        // return all province
        return ProvinceResource::collection(Province::where('active', 1)->get());
    }

    public function getShow($id)
    {
        // return province
        return new ProvinceResource(Province::find($id));
    }

    public function getRegencies($id)
    {
        return RegencyResource::collection(Regency::whereProvinceId($id)->get());
    }
}
