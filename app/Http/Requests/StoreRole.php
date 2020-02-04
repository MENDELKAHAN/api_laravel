<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class StoreRole extends FormRequest
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
       // isset($this->Role->id) ? $roleID = $this-> role -> id : $roleID = "";


        return [
           // 'name' => [
           //      'required',
           //      Rule::unique('role')->ignore($roleID),
           //  ],
            'name' => 'required|string',
            'slug' => 'required|string',
        ];
    }
}