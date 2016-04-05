<?php

namespace App\Services;

class Aws
{
    public static function createAwsClient()
    {
        $sdk = new Sdk([
            'credentials' => array(
                'key' => Config::get('aws_access_key_id'),
                'secret' => Config::get('aws_secret_access_key'),
            ),
            'region' => Config::get('aws_region'),
            'version' => 'latest',
            'DynamoDb' => [
                'region' => Config::get('aws_region')
            ],
            'Ses' => [
                'region' => Config::get('aws_ses_region')
            ],
        ]);
        return $sdk;
    }

    public static function createDynamodb()
    {
        return self::createAwsClient()->createDynamoDb();
    }

}