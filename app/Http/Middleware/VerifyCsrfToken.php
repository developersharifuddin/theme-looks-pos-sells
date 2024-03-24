<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Indicates whether the XSRF-TOKEN cookie should be set on the response.
     *
     * @var bool
     */
    protected $addHttpCookie = true;

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        // Exclude the following routes from CSRF verification
        'api/*',

        // Add more routes if needed, but leave 'api/*' intact to exclude all API routes

        // Protect the 'admin-profile' route from being excluded
        'admin-profile',
    ];
}
