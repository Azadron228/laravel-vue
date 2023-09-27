<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition()
    {
        $title = $this->faker->sentence;
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'body' => $this->faker->paragraph(4, true),
            'description' => $this->faker->paragraph(1, true),
            'user_id' => User::factory(),
        ];
    }
}

