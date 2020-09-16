<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            //\App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            'throttle:60,1',
            'bindings',
        ],

        'CheckSubscriptionAndSetupStatus' => [
            \App\Http\Middleware\IsPageAccessible::class,
        ]
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'Authenticate' => \App\Http\Middleware\AuthMiddleware::class,
        'subscription' => \App\Http\Middleware\SubscriptionMiddleware::class,
        'CorpFINSub' => \App\Http\Middleware\CorpFINMiddleware::class,
        'CorpHRMSub' => \App\Http\Middleware\CorpHRMMiddleware::class,
        'CorpPAYSub' => \App\Http\Middleware\CorpPAYMiddleware::class,
        'CorpEMTSub' => \App\Http\Middleware\CorpEMTMiddleware::class,
        'CorpHRMAccessRoles' => \App\Http\Middleware\CorpHRMAccessRoles::class,
        'CorpHRMSettings' => \App\Http\Middleware\CorpHRMSettings::class,
        'LogUserAction' => \App\Http\Middleware\LogUserAction::class,
        'ClientAuthMiddleware' => \App\Http\Middleware\ClientAuthMiddleware::class,
        
    ];
}
