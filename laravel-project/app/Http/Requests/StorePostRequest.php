<?php

namespace App\Http\Requests;

use Arr;
use Illuminate\Foundation\Http\FormRequest;
use Str;

class StorePostRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'description' => 'required|string',
            'thumbnail' => 'sometimes|image|mimes:jpeg,jpg,gif,png|max:20480',
            'tags' => 'sometimes|array',
            'tagList.*' => 'required|string|max:255',
        ];
    }

    // protected function prepareForValidation()
    // {
    //     $title = $this->input('title');
    //     // Add debugging code to check if $title is set correctly
    //     // dd($title);
    //     $this->merge([
    //         'slug' => Str::slug($title),
    //     ]);
    //     // $this->merge([
    //     //     'slug' => Str::slug($this->input('title')),
    //     // ]);
    // }

    /**
     * @return array<mixed>
     */
    public function validationData()
    {
        return Arr::wrap($this->input('post'));
    }
}
