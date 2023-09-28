<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class PostTest extends TestCase
{
    use WithFaker;

    private Post $post;

    public function testListPost(): void
    {
        $response = $this->get('/posts');
        $response->assertStatus(200);

        // $response->assertJson(
        //     fn (AssertableJson $json) => $json->has('links')
        //         ->has('meta')
        //         ->has('data')->whereAllType([
        //             'data.1.slug' => 'string',
        //             'data.1.title' => 'string',
        //             'data.1.description' => 'string',
        //             'data.1.body' => 'string',
        //             'data.1.tags' => 'array',
        //             'data.1.author.username' => 'string',
        //             'data.1.author.bio' => 'string',
        //             'data.1.author.email' => 'string',
        //             'data.1.author.avatar' => 'string',
        //         ])
        // );
        //
        // $response->assertJson(
        //     fn (AssertableJson $json) =>
        //         $json->has(
        //             'data',
        //             fn (AssertableJson $item) =>
        //             $item->whereAllType([
        //                     'title' => 'string',
        //                     'description' => 'string',
        //                     'body' => 'string',
        //                     'favorited' => 'string',
        //                     'favoritesCount' => 'string',
        //                     'createdAt' => 'string',
        //                     'updatedAt' => 'string',
        //                     'tags' => 'array',
        //                 ])
        //                 ->has(
        //                     'author',
        //                     fn (AssertableJson $subItem) =>
        //                     $subItem->whereAll([
        //                         'username' => $author->username,
        //                         'bio' => $author->bio,
        //                         'image' => $author->image,
        //                         'following' => false,
        //                     ])
        //                 )
        //         )
        // );





        $response->assertJson(
            fn (AssertableJson $json)=>$json->has('meta')->has('links')->has('data',
        fn (AssertableJson $data) =>
        $data->each(
            fn (AssertableJson $item) =>
            $item->whereAllType([
                'title' => 'string',
                'description' => 'string',
                'body' => 'string',
                'tags' => 'array',
            ])->has(
                'author',
                fn (AssertableJson $subItem) =>
                $subItem->whereAllType([
                    'id'=>'integer',
                    'email'=>'string',
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
        /** @var User $author */
        $author = User::factory()->create();

        $title = 'is test title';
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

        $response->assertCreated()
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->has(
                    'post',
                    fn (AssertableJson $item) =>
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
                        ->has(
                            'author',
                            fn (AssertableJson $subItem) =>
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


    protected function setUp(): void
    {
        parent::setUp();

        /** @var Post $post*/
        $post = Post::factory()->create();
        $this->post = $post;
    }

    public function testUpdatePost(): void
    {
        $author = $this->post->author;

        $this->assertNotEquals($title = 'Updated title', $this->post->title);
        $this->assertNotEquals($fakeSlug = 'overwrite-slug', $this->post->slug);
        $this->assertNotEquals($description = 'New description.', $this->post->description);
        $this->assertNotEquals($body = 'Updated post body.', $this->post->body);

        // update by one to check required_without_all rule
        $this->actingAs($author)
            ->putJson("/post/{$this->post->slug}", ['post' => ['description' => $description]])
            ->assertOk();
        $this->actingAs($author)
            ->putJson("/post/{$this->post->slug}", ['post' => ['body' => $body]]);
        $response = $this->actingAs($author)
            ->putJson("/post/{$this->post->slug}", [
                'post' => [
                    'title' => $title,
                    'slug' => $fakeSlug, // must be overwritten with title slug
                ],
            ]);

        $response->assertOk()
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->has(
                    'post',
                    fn (AssertableJson $item) =>
                    $item->whereType('updatedAt', 'string')
                        ->whereAll([
                            'slug' => 'updated-title',
                            'title' => $title,
                            'description' => $description,
                            'body' => $body,
                            'tagList' => [],
                            'createdAt' => $this->post->created_at?->toISOString(),
                            'favorited' => false,
                            'favoritesCount' => 0,
                        ])
                        ->has(
                            'author',
                            fn (AssertableJson $subItem) =>
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

    public function testUpdateForeignPost(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->putJson("/post/{$this->post->slug}", [
                'post' => [
                    'body' => $this->faker->text(),
                ],
            ]);

        $response->assertForbidden();
    }
}
