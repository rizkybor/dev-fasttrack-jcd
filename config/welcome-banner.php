<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Welcome Banner Toggle
    |--------------------------------------------------------------------------
    |
    | Set to false to turn off the full-screen welcome banner regardless of
    | the active period below.
    |
    */

    'enabled' => env('WELCOME_BANNER_ENABLED', false),

    /*
    |--------------------------------------------------------------------------
    | Active Period
    |--------------------------------------------------------------------------
    |
    | When enabled is true, the banner only shows while the current date is
    | within this range. Use "Y-m-d" format (e.g. "2026-07-01"). Leave a
    | value null/empty to leave that side of the range open-ended.
    |
    */

    'start_date' => env('WELCOME_BANNER_START_DATE'),

    'end_date' => env('WELCOME_BANNER_END_DATE'),

];
