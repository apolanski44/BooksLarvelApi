<?php

use Laravel\Sanctum\Sanctum;

return [

    /*
    |--------------------------------------------------------------------------
    | Stateful Domains
    |--------------------------------------------------------------------------
    |
    | Usunięcie stateful domains, aby Sanctum działał tylko w trybie Bearer Token.
    |
    */

    'stateful' => [], 

    /*
    |--------------------------------------------------------------------------
    | Sanctum Guards
    |--------------------------------------------------------------------------
    |
    | Ten parametr definiuje, które guardy Laravel będzie sprawdzał, zanim użyje tokena.
    |
    */

    'guard' => ['web'],

    /*
    |--------------------------------------------------------------------------
    | Expiration Minutes
    |--------------------------------------------------------------------------
    |
    | Kontroluje, po ilu minutach token wygaśnie. Jeśli null – token nie wygasa.
    |
    */

    'expiration' => null,

    /*
    |--------------------------------------------------------------------------
    | Token Prefix
    |--------------------------------------------------------------------------
    |
    | Prefiks tokena dla bezpieczeństwa (np. wykrywanie w repozytoriach kodu).
    |
    */

    'token_prefix' => env('SANCTUM_TOKEN_PREFIX', ''),

    /*
    |--------------------------------------------------------------------------
    | Sanctum Middleware
    |--------------------------------------------------------------------------
    |
    | WYŁĄCZYLIŚMY `validate_csrf_token`, aby Laravel nie wymagał CSRF.
    |
    */

    'middleware' => [
        'authenticate_session' => Laravel\Sanctum\Http\Middleware\AuthenticateSession::class,
        'encrypt_cookies' => Illuminate\Cookie\Middleware\EncryptCookies::class,
        // 'validate_csrf_token' => Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class, // USUNIĘTO!
    ],

];
