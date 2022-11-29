<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoomRequests extends FormRequest
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
            'unit_name' => 'required',
            'room_type' => 'required',
            'beds' => 'required|numeric',
            'status' => 'required',
            'prefer_tenant_gender' => 'required',
            'price_range_from' => 'required|numeric',
        ];
    }
}
