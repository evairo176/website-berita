<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class adminAdsUpdateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "home_top_bar_ads" => ['nullable', 'image', 'max:3000'],
            "home_middle_ads" => ['nullable', 'image', 'max:3000'],
            "news_page_ads" => ['nullable', 'image', 'max:3000'],
            "view_page_ads" => ['nullable', 'image', 'max:3000'],
            "sidebar_ads" => ['nullable', 'image', 'max:3000'],
        ];
    }
}
