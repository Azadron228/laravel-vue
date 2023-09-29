<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Str;
use Tests\TestCase;

class PostTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    private Post $post;

    public function testListPost(): void
    {
        $response = $this->get('/posts');
        $response->assertStatus(200);
        $response->assertJson(
            fn (AssertableJson $json) => $json->has('meta')->has('links')->has(
                'data',
                fn (AssertableJson $data) => $data->each(
                    fn (AssertableJson $item) => $item->whereAllType([
                        'title' => 'string',
                        'description' => 'string',
                        'body' => 'string',
                        'tags' => 'array',
                    ])->has(
                        'author',
                        fn (AssertableJson $subItem) => $subItem->whereAllType([
                            'id' => 'integer',
                            'email' => 'string',
                            'created_at' => 'string',
                            'updated_at' => 'string',
                            'username' => 'string',
                            'bio' => 'string',
                            'avatar' => 'string',
                            // 'following' => 'boolean',
                        ])
                    )->etc()
                )->etc()
            )
        );
    }

    public function testCreatePost(): void
    {
        $user = User::factory()->create();

        $title = 'This is test title';
        $description = $this->faker->paragraph();
        $body = $this->faker->text();
        $tags = ['one', 'two', 'three', 'four', 'five'];

        $response = $this->actingAs($user)
            ->postJson('/posts', [
                'post' => [
                    'title' => $title,
                    'description' => $description,
                    'body' => $body,
                    'tags' => $tags,
                ],
            ]);

        $response->assertCreated()
            ->assertJson(
                fn (AssertableJson $json) => $json->has(
                    'post',
                    fn (AssertableJson $item) => $item->whereAll([
                        'title' => $title,
                        'description' => $description,
                        'body' => $body,
                    ])
                        ->whereAllType([
                            'tags' => 'array',
                        ])
                        ->has(
                            'author',
                            fn (AssertableJson $subItem) => $subItem->whereAll([
                                'username' => $user->username,
                                'bio' => $user->bio,
                            ])->whereAllType([
                                'id' => 'integer',
                                'email' => 'string',
                                'created_at' => 'string',
                                'updated_at' => 'string',
                                'avatar' => 'string',
                            ])
                        )->etc()
                )->etc()
            );
    }

    protected function setUp(): void
    {
        parent::setUp();
        $post = Post::factory()->create();
        $this->post = $post;
    }

    public function testUpdatePost(): void
    {
         $anpost = Post::factory()->create();
        $user= $this->post->author;
        dd($anpost);

        $this->assertNotEquals($title = 'Updated title', $this->post->title);
        $this->assertNotEquals($description = 'New description.', $this->post->description);
        $this->assertNotEquals($body = 'Updated post body.', $this->post->body);

        $response = $this->actingAs($user)
            ->putJson("/posts/{$this->post->slug}", [
                'post' => [
                    'title' => $title,
                    'description' => $description,
                    'body' => $body,
                ],
            ]);


                $response->dumpHeaders();

        $response->dumpSession();

        $response->dump();

        $response->assertOk()
            ->assertJson(
                fn (AssertableJson $json) => $json->has(
                    'post',
                    fn (AssertableJson $item) => $item->whereType('updatedAt', 'string')
                        ->whereAll([
                            'slug' => Str::slug($title), 'title' => $title,
                            'description' => $description,
                            'body' => $body,
                            'tagList' => [],
                            'createdAt' => $this->post->created_at?->toISOString(),
                            'favorited' => false,
                            'favoritesCount' => 0,
                        ])
                        ->has(
                            'author',
                            fn (AssertableJson $subItem) => $subItem->whereAll([
                                'username' => $author->username,
                                'bio' => $author->bio,
                                'image' => $author->image,
                                'following' => false,
                            ])
                        )
                )
            );
    }

    public function testUpdateForeignPost(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->putJson("/post/{$this->post->slug}", [
                'post' => [
                    'body' => $this->faker->text(),
                ],
            ]);
        // dd($this->post->slug);
        $response->assertForbidden();

    }
}
