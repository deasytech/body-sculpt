<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Deploy Token
    |--------------------------------------------------------------------------
    |
    | A shared secret required to trigger the deploy helper routes in
    | routes/deploy.php (storage:link, optimize:clear, migrate) from a
    | browser on hosts without shell/SSH access. Generate one with:
    |
    |   php -r "echo bin2hex(random_bytes(32));"
    |
    | and set it as DEPLOY_TOKEN in .env. Leaving it blank disables the
    | routes entirely.
    |
    */

    'token' => env('DEPLOY_TOKEN'),

];
