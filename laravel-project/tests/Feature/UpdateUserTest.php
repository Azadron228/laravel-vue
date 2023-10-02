<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Testing\Fluent\AssertableJson;
use Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile as FileUploadedFile;
use Tests\TestCase;

class UpdateUserTest extends TestCase
{
    // use RefreshDatabase;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var User $user */
        $user = User::factory()->create();
        $this->user = $user;
    }

    public function testUpdateUser(): void
    {
        // Storage::fake('avatars');

        // $avatar = UploadedFile::fake()->image('avatar.jpg');

        $username = 'new.username';
        $email = 'newEmail@example.com';
        $bio = 'New bio information.';
        // $this->assertNotEquals($avatar = 'https://example.com/avatar.png', $this->user->avatar);

        // update by one to check required_without_all rule
        $this->actingAs($this->user)
            ->putJson('/api/user', ['user' => ['username' => $username]])
            ->assertOk();
        $this->actingAs($this->user)
            ->putJson('/api/user', ['user' => ['email' => $email]])
            ->assertOk();
        $response = $this->actingAs($this->user)
            ->putJson('/api/user', ['user' => ['bio' => $bio]]);
        // $this->actingAs($this->user)
            // ->post('/api/user', ['user' => ['avatar' => $avatar]]);
        // $response = $this->actingAs($this->user)->post('/api/user', ['user'=>'_method: PUT']);
        // $response = $this->json('PUT', '/api/user', [$avatar]);
        // Storage::disk('avatars')->assertExists($avatar->hashName());

        // $response->dump();

        $response->assertOk()
            ->assertJson(
                fn (AssertableJson $json) => $json->has(
                    'user',
                    fn (AssertableJson $item) => $item
                        ->whereAll([
                            'username' => $username,
                            'email' => $email,
                            'bio' => $bio,
                        ])->etc()
                )
            );
    }


    public function testUpdateUserAvatar(): void
    {
        Storage::fake('avatars');

        $avatar = UploadedFile::fake()->image('avatar.jpg');
        // $this->assertNotEquals($avatar = 'https://example.com/avatar.png', $this->user->avatar);

        $response = $this->actingAs($this->user)
            ->post('/api/user', ['avatar' => $avatar]);
        // $response = $this->actingAs($this->user)->post('/api/user', ['user'=>'_method: PUT']);
        // $response = $this->json('PUT', '/api/user', [$avatar]);
        // Storage::disk('avatars')->assertExists($avatar->hashName());
        // $response = $this->post('/avatar', [
        //     'avatar' => $avatar,
        // ]);

        $response->dump();
        // $path = 'avatars' . $avatar->hashName();
// Storage::disk('avatars')->assertExists($path);

        Storage::disk('avatars')->assertExists($avatar->hashName());
    }
 }
