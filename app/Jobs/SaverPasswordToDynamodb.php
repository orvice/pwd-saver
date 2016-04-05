<?php

namespace App\Jobs;

use App\Services\Storage;
use Aws\DynamoDb\Exception\DynamoDbException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SaverPasswordToDynamodb extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $email, $password;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $client = new Storage();
        try {
            $client->store($this->email, $this->password);
        } catch (DynamoDbException $e) {
            echo $e->getMessage();
        }
    }
}
