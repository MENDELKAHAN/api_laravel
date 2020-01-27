<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class StorePermission extends FormRequest
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
       isset($this->Permission->id) ? $permissionID = $this-> permission -> id : $permissionID = "";


        return [
           'name' => [
                'required',
                Rule::unique('permissions')->ignore($permissionID),
            ],
            'slug' => 'required|string',
        ];
    }
}
