<?php

namespace App\Http\Requests;

use App\Models\Post;
use Arr;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
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
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $input = $this->input();
        $title = Arr::get($input, 'post.title');
        // dd($input);

        if (is_string($title)) {
            Arr::set($input, 'post.slug', Str::slug($title));
        } else {
            Arr::forget($input, 'post.slug');
        }

        $this->merge($input);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $post = Post::whereSlug($this->route('slug'))
            ->first();

        $unique = Rule::unique('posts', 'slug');
        if ($post !== null) {
            $unique->ignoreModel($post);
        }

        return [
            'title' => ['string', 'max:255'],
            'slug' => ['string', 'max:255', $unique],
            'description' => ['string', 'max:510'],
            'body' => ['string'],
            'tags' => 'sometimes|array',
            'tagList.*' => 'required|string|max:255',
        ];
        //
        // dd($this->input());
        // return [
        //     'title' => 'required|string|max:255',
        //     'body' => 'required|string',
        //     'description' => 'required|string',
        //     'thumbnail' => 'sometimes|image|mimes:jpeg,jpg,gif,png|max:20480',
        //     'tags' => 'sometimes|array',
        //     'tagList.*' => 'required|string|max:255',
        // ];
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
