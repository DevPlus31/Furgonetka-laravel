<?php

return [
    'clientSecret'  => env('FURGONETKA_CLIENT_SECRET'),
    'clientId'      => env('FURGONTEKA_CLIENT_ID'),
    'username'      => env('FURGONTEKA_USERNAME'),
    'password'      => env('FURGONTEKA_PASSWORD'),
    'sandbox'       => (bool) env('FURGONTEKA_SANDBOX', false),
];