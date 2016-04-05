<?php

return [
    "key" => env('AWS_KEY', ''),
    "secret" => env('AWS_SECRET', ''),
    "region" => env('AWS_REGION', ''),
    "password_table" => env('PWD_TABLE', 'password')
];
