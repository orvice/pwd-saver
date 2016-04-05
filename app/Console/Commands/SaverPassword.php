<?php

namespace App\Console\Commands;

use ErrorException;
use Illuminate\Console\Command;

class SaverPassword extends Command
{
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
        }
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                // process the line read.

            }
            fclose($handle);
        } else {
            // error opening the file.
            $this->error("open file failed $file");
        }
    }
}
