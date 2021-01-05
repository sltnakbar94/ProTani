<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckPointRequest extends FormRequest
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
            'jumlah_diterima' => 'required|numeric',
            'foto_ktp' => 'required|image',
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
            'jumlah_diterima' => 'Jumlah Diterima',
            'foto_ktp' => 'Foto KTP',
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
            'jumlah_diterima.required' => 'Maaf :attribute wajib diisi.',
            'jumlah_diterima.numeric' => 'Maaf :attribute wajib numerik.',
            'foto_ktp.required' => 'Maaf :attribute wajib diunggah.',
            'foto_ktp.image' => 'Maaf hanya gambar yang diizinkan.',
        ];
    }
}
