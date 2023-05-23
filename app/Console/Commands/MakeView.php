<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeView extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:view {view}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $argument  = $this->argument('view');

        $path = $this->getFullPath($argument);

        $this->checkFolder($path);

        if(File::exists($path)){
            $this->error( "File '$path' already exists");
            return;
        }
        File::put($path , $path);
        $this->info("File '$path' created successfully");
    }

    public function getFullPath($argument)
    {
        $view = \str_replace('.','/',$argument) .  '.blade.php';
        $path = "resources/views/{$view}";
        return $path;
    }

    public function checkFolder($path)
    {
        $file = dirname($path);
        if(!\file_exists($file)){
            mkdir($file, 0777, true);
        }
    }
}
