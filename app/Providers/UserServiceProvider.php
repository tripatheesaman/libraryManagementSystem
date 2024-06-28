<?php
namespace App\Providers;

use App\Contracts\UserAuthInterface;
use App\Contracts\UserInterface;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\UserAuthController;
use App\Services\AdminAuthService;
use App\Services\UserAuthService;
use App\Services\UserDatabase;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->when(UserAuthService::class)->needs(UserInterface::class)->give(UserService::class);
        $this->app->when(UserService::class)->needs(UserInterface::class)->give(UserDatabase::class);
        $this->app->when(AdminAuthService::class)->needs(UserInterface::class)->give(UserDatabase::class);
        $this->app->when(UserAuthController::class)->needs(UserAuthInterface::class)->give(UserAuthService::class);
        $this->app->when(AdminAuthController::class)->needs(UserAuthInterface::class)->give(AdminAuthService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
