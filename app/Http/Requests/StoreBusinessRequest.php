<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBusinessRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama'          => ['required','string','max:255'],
            'jenis'         => ['required','in:Makanan dan Minuman,Pakaian dan Aksesoris,Jasa,Kerajinan Tangan,Elektronik,Kesehatan,Transportasi,Pendidikan,Teknologi'],
            'owner'         => ['required','string','max:255'],
            'input_url'     => ['nullable','url','max:2000'],
            'alamat'        => ['nullable','string','max:255'],
            'latitude'      => ['nullable','numeric','between:-90,90'],
            'longitude'     => ['nullable','numeric','between:-180,180'],
            'nomor_telepon' => ['required','string','max:15'],
            'email'         => ['required','email','max:255'],
            'nib'           => ['required','string','max:50'],
            'deskripsi'     => ['required','string'],
            'foto'          => ['nullable','file','image','mimes:jpeg,jpg,png,gif','max:2048'], // single file upload
            'status'        => ['nullable','integer','in:0,1'],
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'input_url' => $this->input('input_url') ? trim($this->input('input_url')) : null,
            'alamat'    => $this->input('alamat') ? trim($this->input('alamat')) : null,
        ]);
    }
}
