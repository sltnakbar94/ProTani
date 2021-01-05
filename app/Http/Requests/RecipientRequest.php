<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class RecipientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nama' => 'required',
            'nik' => 'required|string|min:16|max:16|unique:recipients,nik'
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
            'nama' => 'Nama',
            'nik' => 'NIK',
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
            'nama.required' => 'Kolom :attribute wajib diisi',
            'nik.required' => 'Kolom :attribute wajib diisi',
            'nik.min' => 'Kolom :attribute wajib diisi minimal 16 karakter',
            'nik.max' => 'Kolom :attribute wajib diisi maksimal 16 karakter',
            'nik.unique' => 'Maaf :attribute anda sudah pernah terdaftar',
        ];
    }
}
