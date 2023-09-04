<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Rules\Password;

class RegisterUser extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // if($this->isMember == 1){
        // }else{
        //     return Auth::check() && $this->user()->hasRole('Administrator');
        // }
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $valid = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', new Password]
        ];

        if($this->isMember == 1){
            $valid['jenis_kelamin'] = 'required';
            $valid['alamat'] = 'required';
            $valid['no_telp'] = 'required';
        }

        return $valid;
    }
}
