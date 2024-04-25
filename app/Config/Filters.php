<?php

namespace Config;

use App\Filters\MiFiltro;
use App\Filters\UserFilter;
use CodeIgniter\Filters\CSRF;
use App\Filters\DashboardFilter;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\SecureHeaders;

class Filters extends BaseConfig
{
    /**
     * Configures aliases for Filter classes to
     * make reading things nicer and simpler.
     *
     * @var array<string, class-string|list<class-string>> [filter_name => classname]
     *                                                     or [filter_name => [classname1, classname2, ...]]
     */
    public array $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'mifiltro' => MiFiltro::class,
        'dashboardFilter' => DashboardFilter::class,
        'userFilter' => UserFilter::class,
    ];

    /**
     * List of filter aliases that are always
     * applied before and after every request.
     *
     * @var array<string, array<string, array<string, string>>>|array<string, list<string>>
     */
    public array $globals = [
        'before' => [
            // 'mifiltro',
            // 'honeypot',
            // 'csrf',
            // 'invalidchars',
        ],
        'after' => [
            
            'toolbar',
            // hace referencia al icono de codeigniter que vemos en el vertice inferior derecho del navegador. 
            // esta utilidad, con el click, nos da informacion sobre nuestro sistema
            // si comentamos esta linea, el toolbar desaparece
            // con ctrl + u en el navegador podemos chequear que este icono es generado con bloque javascript en el <head>, y que si comentamos esta linea, dicho codigo y el icono desaparecen

            // 'honeypot',
            // 'secureheaders',
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
    public array $filters = [
        "dashboardFilter" => [
            "before" => [
                "dashboard",
                "dashboard/*",
            ]
        ],
        "userFilter" => [
            "before" => [
                "login",
                "register",
            ]
        ]
        // "mifiltro" => [
        //     "before" => [
        //         // "dashboard/pelicula",
        //         "dashboard/pelicula/*",
        //     ]
        // ]
    ];
}
