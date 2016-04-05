<?php

namespace App\Services;

use Aws\Sdk;

class Aws
{
    public static function createAwsClient()
    {
        $sdk = new Sdk([
            'credentials' => array(
                'key' => config('aws.key'),
                'secret' => config('aws.secret'),
            ),
            'region' => config('aws.region'),
            'version' => 'latest',
            'DynamoDb' => [
                'region' => config('aws.region')
            ],
        ]);
        return $sdk;
    }

    public static function createDynamodb()
    {
        return self::createAwsClient()->createDynamoDb();
    }

}