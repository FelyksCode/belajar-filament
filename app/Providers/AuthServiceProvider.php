<?php

namespace App\Providers;

use App\Models\User;
use App\Policies\UserPolicy;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        User::class => UserPolicy::class, // Register UserPolicy for the User model
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Gate::policy(User::class, UserPolicy::class);

        Auth::provider('plain-text', function ($app, array $config) {
            return new class implements UserProvider {
                public function retrieveById($identifier)
                {
                    return User::find($identifier);
                }

                public function retrieveByToken($identifier, $token)
                {
                    return null;
                }

                public function updateRememberToken(\Illuminate\Contracts\Auth\Authenticatable $user, $token)
                {
                    if ($user instanceof User) {
                        $user->setRememberToken($token);
                        $user->save();
                    }
                }

                public function retrieveByCredentials(array $credentials)
                {
                    return User::where('email', $credentials['email'])->first();
                }

                public function validateCredentials(\Illuminate\Contracts\Auth\Authenticatable $user, array $credentials)
                {
                    return $user->password === $credentials['password']; // Plain text comparison
                }

                // overwrite rehashPasswordIfRequired method from UserProvider
                public function rehashPasswordIfRequired(\Illuminate\Contracts\Auth\Authenticatable $user, array $credentials, array $options = []): void
                {
                    // No need to rehash since we're using plain text passwords
                }
            };
        });
    }
}
