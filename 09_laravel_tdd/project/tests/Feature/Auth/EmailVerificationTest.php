<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

/**
 * Needed only for tests.
 * Remove if the User class implements MustVerifyEmail interface.
 */
class EmailVerificationTest_UserThatImplementsVerifyEmail extends User implements MustVerifyEmail
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';
}

class EmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_email_verification_screen_can_be_rendered(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $response = $this->actingAs($user)->get('/verify-email');

        $response->assertStatus(200);
    }

    public function test_email_can_be_verified(): void
    {
        if (is_subclass_of(User::class, MustVerifyEmail::class)) {
            $user = User::factory()->create([
                'email_verified_at' => null,
            ]);
        }
        //else {
        //    $user = EmailVerificationTest_UserThatImplementsVerifyEmail::create([
        //        'username' => 'Name',
        //        'email' => 'name@example.com',
        //        'password' => bcrypt('secret'),
        //        'email_verified_at' => null,
        //    ]);
        //}

        Event::fake();

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email ?? '')]
        );

        $response = $this->actingAs($user)->get($verificationUrl);

        Event::assertDispatched(Verified::class);
        $user = $user->fresh();
        $this->assertNotNull($user);
        $this->assertTrue($user->hasVerifiedEmail());
        $response->assertRedirect(RouteServiceProvider::HOME.'?verified=1');
    }

    public function test_email_is_not_verified_with_invalid_hash(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1('wrong-email')]
        );

        $this->actingAs($user)->get($verificationUrl);

        $user = $user->fresh();
        $this->assertNotNull($user);
        $this->assertFalse($user->hasVerifiedEmail());
    }
}
