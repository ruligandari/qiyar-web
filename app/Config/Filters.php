<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\SecureHeaders;

class Filters extends BaseConfig
{
    /**
     * Configures aliases for Filter classes to
     * make reading things nicer and simpler.
     */
    public array $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'authFilter' => \App\Filters\UserFilter::class,
        'mobileFilter' => \App\Filters\MobileFilter::class,
        'roleFilter' => \App\Filters\RoleFilter::class,
        'advFilter' => \App\Filters\AdvFilter::class,
        'AdvertiserFilter' => \App\Filters\AdvertiserFilter::class,
        'BroadcastFilter' => \App\Filters\BroadcastFilter::class,
        'WarehouseKuninganFilter' => \App\Filters\WarehouseKuninganFilter::class,
        'WarehouseJakartaFilter' => \App\Filters\WarehouseJakartaFilter::class,
    ];

    /**
     * List of filter aliases that are always
     * applied before and after every request.
     */
    public array $globals = [
        'before' => [
            // 'honeypot',
            // 'csrf',
            // 'invalidchars',
            // 'authFilter' => ['except' => ['auth', 'auth/*']],
            // 'roleFilter' => ['except' => ['auth', 'auth/*']],
            // 'advFilter' => ['except' => ['auth', 'auth/*']],
        ],
        'after' => [
            'toolbar',
            // 'honeypot',
            // 'secureheaders',
            // 'AdvertiserFilter' => ['except' => ['advertiser', 'advertiser/*']],
            'BroadcastFilter' => ['except' => ['dashboard/lamaran', 'dashboard/advertiser/*', 'warehouse-kuningan/*', 'warehouse-jakarta/*']],
            'WarehouseKuninganFilter' => ['except' => ['dashboard/lamaran', 'dashboard/advertiser/*', 'warehouse-kuningan/*', 'warehouse-jakarta/*']],
        ],
    ];

    /**
     * List of filter aliases that works on a
     * particular HTTP method (GET, POST, etc.).
     *
     * Example:
     * 'post' => ['foo', 'bar']
     *
     * If you use this, you should disable auto-routing because auto-routing
     * permits any HTTP method to access a controller. Accessing the controller
     * with a method you don't expect could bypass the filter.
     */
    public array $methods = [];

    /**
     * List of filter aliases that should run on any
     * before or after URI patterns.
     *
     * Example:
     * 'isLoggedIn' => ['before' => ['account/*', 'profiles/*']]
     */
    public array $filters = [];
}
