<?php

namespace Tests\Feature;

use App\Models\User;
use Auth;
use Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use WithFaker;

    public function testRegisterUser(): void
    {
        $username = $this->faker->userName();
        $email = $this->faker->safeEmail();

        $response = $this->postJson('/api/register', [
            'user' => [
                'username' => $username,
                'email' => $email,
                'password' => $this->faker->password(8),
            ],
        ]);

        $response->assertCreated()
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->has(
                    'user',
                    fn (AssertableJson $item) =>
                    $item->whereAll([
                            'username' => $username,
                            'email' => $email,
                            'bio' => null,
                        ])->etc()
                )
            );

        $user = User::where('email', $email)->first();
        $this->assertAuthenticatedAs($user);
    }
    /**
     * @return void
     */
    public function userCanLoginWithCredentials(): void
    {
        $password = $this->faker->password(8);
        /** @var User $user */
        $user = User::factory()
            ->state(['password' => Hash::make($password)])
            ->create();

        $response = $this->postJson('/api/login', [
            'user' => [
                'email' => $user->email,
                'password' => $password,
            ],
        ]);

        $response->assertOk()
            ->assertJson(
                fn (AssertableJson $json) => $json->has(
                    'user',
                    fn (AssertableJson $item) => $item->whereType('token', 'string')
                        ->whereAll([
                            'username' => $user->username,
                            'email' => $user->email,
                            'bio' => $user->bio,
                            'avatar' => $user->image,
                        ])
                )
            );
        $this->assertAuthenticatedAs($user);
    }

    public function testLoginUserFail(): void
    {
        $password = 'knownPassword';
        /** @var User $user */
        $user = User::factory()
            ->state(['password' => Hash::make($password)])
            ->create();

        $response = $this->postJson('/api/login', [
            'user' => [
                'email' => $user->email,
                'password' => 'differentPassword',
            ],
        ]);

        $response->assertUnprocessable()
            ->assertInvalid('user');
    }


    public function testLogOutUser(): void
    {
        $password = $this->faker->password(8);
        /** @var User $user */
        $user = User::factory()
            ->state(['password' => Hash::make($password)])
            ->create();

        $response = $this->postJson('/api/login', [
            'user' => [
                'email' => $user->email,
                'password' => $password,
            ],
        ]);
        Auth::login($user);
        $response = $this->post('/logout');

        $this->assertGuest();
    }
}
