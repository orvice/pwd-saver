<?php

namespace App\Console\Commands;

use App\Jobs\SaverPasswordToDynamodb;
use ErrorException;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;

class SaverPassword extends Command
{
    use DispatchesJobs;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'saver {path}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process password from path';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $path = $this->argument('path');
        $this->info("input path: $path");
        $files = scandir($path);
        foreach ($files as $fileName) {
            if (strlen($fileName) < 3) {
                $this->info("file name too short ,skip");
                continue;
            }
            $this->info("process file: $fileName");
            $file = $path . $fileName;
            $this->handleFile($file);
        }
    }

    public function handleFile($file)
    {
        try {
            $handle = fopen($file, "r");
        } catch (ErrorException $e) {
            $this->error("open file failed $file");
            return false;
        }
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                // process the line read.
                $this->info("process $line");
                $ary = explode('----', $line);
                if (count($ary) != 2) {
                    $this->error("data wrong,skip");
                    continue;
                }
                $email = $ary[0];
                $password = $ary[1];
                $this->dispatch(new SaverPasswordToDynamodb($email, $password));
            }
            fclose($handle);
        } else {
            // error opening the file.
            $this->error("open file failed $file");
        }
    }
}
