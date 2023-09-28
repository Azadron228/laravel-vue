<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class PostTest extends TestCase
{
    use WithFaker;

    public function testListArticles(): void
    {
        $response = $this->get('/posts');
        $response->assertStatus(200);

        // dd($response);
        $response->assertJson(
            fn (AssertableJson $json) => $json->has('links')
                ->has('meta')
                ->has('data')->whereAllType([
                    'data.1.slug' => 'string',
                    'data.1.title' => 'string',
                    'data.1.description' => 'string',
                    'data.1.body' => 'string',
                    'data.1.tags' => 'array',
                    'data.1.author.username' => 'string',
                    'data.1.author.bio' => 'string',
                    'data.1.author.email' => 'string',
                    'data.1.author.avatar' => 'string',
                ])
        );
    }


    public function testCreateArticle(): void
    {
        /** @var User $author */
        $author = User::factory()->create();

        $title = 'Originall title';
        $description = $this->faker->paragraph();
        $body = $this->faker->text();
        $tags = ['one', 'two', 'three', 'four', 'five'];

        $response = $this->actingAs($author)
            ->postJson('/posts', [
                'post' => [
                    'title' => $title,
                    'description' => $description,
                    'body' => $body,
                    'tags' => $tags,
                ],
            ]);
        // dd($response);
        $response->assertCreated()
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('post', fn (AssertableJson $item) =>
                    $item->whereAll([
                            'title' => $title,
                            'description' => $description,
                            'body' => $body,
                            'favorited' => false,
                            'favoritesCount' => 0,
                        ])
                        ->whereAllType([
                            'createdAt' => 'string',
                            'updatedAt' => 'string',
                            'tags' => 'array',
                        ])
                        ->has('author', fn (AssertableJson $subItem) =>
                            $subItem->whereAll([
                                'username' => $author->username,
                                'bio' => $author->bio,
                                'image' => $author->image,
                                'following' => false,
                            ])
                        )
                )
            );
    }
}
