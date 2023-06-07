<?php

namespace App\Console\Commands;

use App\Models\Banner;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class ClearCacheCommand extends Command
{
    protected $signature = 'cache:clear';

    protected $description = 'Clear the application cache';

    public function handle()
    {
        Cache::flush();
        $this->info('Application cache cleared.');
    }
}
