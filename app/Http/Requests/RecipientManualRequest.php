<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class RecipientManualRequest extends FormRequest
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
        $rules = [
            'nama' => 'required',
            'nik' => 'required|string|min:16|max:16|unique:recipient_manuals,nik'
        ];

        if(request()->method('PUT')) {
            $rules['nik'] = 'required|string|min:16|max:16|unique:recipient_manuals,nik,'. request()->route('id');
        }

        return $rules;
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
            'alamat' => 'Alamat',
            'regency_id' => 'Kota',
            'district_id' => 'Kecamatan',
            'village_id' => 'Kelurahan',
            'rt' => 'RT',
            'rw' => 'RW',
            'kode_pos' => 'Kode pos',
            'lat' => 'Latitude',
            'lng' => 'Longitude',
            'foto' => 'Foto',
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
