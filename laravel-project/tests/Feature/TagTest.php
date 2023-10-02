<?php

namespace Tests\Feature;

use App\Models\Tag;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class TagTest extends TestCase
{
    public function testReturnsTagsList(): void
    {
        $tags = Tag::factory()->count(5)->create();
        $response = $this->getJson('/listTags');

        $response->assertJson(
            fn (AssertableJson $json) => $json->has(
                'data',
                fn (AssertableJson $data) => $data->each(
                    fn (AssertableJson $item) => $item->whereAllType([
                        'id' => 'integer',
                        'name' => 'string',
                    ])
                )
            )
        );
    }
}
