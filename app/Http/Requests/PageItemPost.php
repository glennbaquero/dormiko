<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use App\PageItem;

class PageItemPost extends FormRequest
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
        $id = $this->route('id');

        return [
            'page_id' => 'required|exists:pages,id',
            'slug' => 'required|unique:pages,slug,' . $id,
            'type' => 'required|' . Rule::in(array_column(PageItem::getTypes(), 'value')),
            'content' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'page_id.required' => 'Please select a page',
            'page_id.exists' => 'Page not found',
        ];
    }
}
