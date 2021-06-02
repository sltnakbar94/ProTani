<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class SalesFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'farmer_name' => 'required',
            'id_number' => 'required|digits:16',
            'id_address' => 'required',
            'rt' => 'required',
            'rw' => 'required', 
            'phone_number' => 'required',
            'province_id' => 'required',
            'regency_id' => 'required' ,
            'district_id' => 'required' ,
            'village_id' => 'required',
            'site_address' => 'required' ,
            'rt_pool' => 'required',
            'rw_pool' => 'required' ,
            'pool_province_id' => 'required' ,
            'pool_regency_id' => 'required' ,
            'pool_district_id' => 'required' ,
            'pool_village_id' => 'required' ,
            'pokdakan_name' => 'required' ,
            'position_in_organization' => 'required' ,
            'lenght_effort' => 'required' , 
            'fish_type' => 'required' ,
            'pool_area' => 'required' ,
            'fish_mantaince_period' => 'required' ,
            'yields' => 'required' ,
            'fish_food_brand' => 'required' ,
            'fish_food_type' => 'required' ,
            'fish_food_retrieval_system' => 'required' ,
            'fish_food_price' => 'required' ,
            'fish_food_needs' => 'required' ,
            'food_fish_payment_method'  => 'required' ,
            'source_fund' => 'required' ,
            'fish_seed_source' => 'required' ,
            'harvest_cost' => 'required' 
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //
        ];
    }
}
