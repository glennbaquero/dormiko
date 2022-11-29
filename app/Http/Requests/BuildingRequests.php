<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BuildingRequests extends FormRequest
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
            'name' => 'required',
            'floor' => 'required|numeric',
            'location' => 'required',
            'waze_link' => 'required',
            // 'google_map_link' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'banner_image' => 'min:6'
        ];
    }

    public function messages()
    {
        return [
            'banner_image.min' => 'The banner should have maximum of 6 images',
        ];
    }
}
