<?php


namespace App\Services;


class Storage
{
    protected $client;
    protected $tableName = 'password';

    public function __construct()
    {
        $this->client = Aws::createDynamodb();
        $this->tableName = config('aws.password_table');
    }

    public function store($email,$password)
    {
        return $this->client->putItem(array(
            'TableName' => $this->tableName,
            'Item' => array(
                'email' => array('S' => $email),
                'password' => array('S' => $password),
            )
        ));
    }
}