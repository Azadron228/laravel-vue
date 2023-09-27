<?php

namespace Tests\Feature;

use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class PostTest extends TestCase
{
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
}
