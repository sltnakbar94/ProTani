<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Order;
class OrderRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        $this->merge([
            'kode_truk' => Order::withTrashed()->count() + 1,
        ]);
    }
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check() && backpack_user()->hasAnyRole(['operator', 'superadmin']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'kode_truk' => 'required|unique:orders,kode_truk',
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
            'kode_truk' => 'Data unik'
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
            'kode_truk.unique' => ':attribute telah terdaftar. Silahkan coba lagi'
        ];
    }
}
