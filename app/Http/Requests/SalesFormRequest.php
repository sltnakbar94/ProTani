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
            'phone_number' => 'digits:14',
            'id_number' => 'required',
            'id_address' => 'required',
            'rt' => 'required',
            'rw' => 'required',
            'villages' => 'required',
            'districts' => 'required',
            'regencies' => 'required',
            'provinces' => 'required',
            'id_pict' => 'required',
            'site_address' => 'required',
            'pool_qty' => 'required',
            'site_pict1' => 'required',
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
