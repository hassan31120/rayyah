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
        Banner::create([
            'banner' => '123'
        ]);
        $this->info('Application cache cleared.');
    }
}
