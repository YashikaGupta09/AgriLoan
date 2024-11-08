<?php

return [

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'], // Or specify methods like ['GET', 'POST', 'PUT']

    'allowed_origins' => ['*'], // Or specify origins like ['http://127.0.0.1:8000', 'http://localhost:3000']

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'], // Or specify necessary headers like ['Content-Type', 'Authorization']

    'exposed_headers' => [], // Add custom headers if necessary

    'max_age' => 0,

    'supports_credentials' => true, // Set true if cookies/sessions are involved

];
