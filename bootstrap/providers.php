<?php

use App\Providers\AppServiceProvider;
use Illuminate\View\ViewServiceProvider;

return [
    AppServiceProvider::class,
    ViewServiceProvider::class,
    Laravel\Socialite\SocialiteServiceProvider::class,
];
