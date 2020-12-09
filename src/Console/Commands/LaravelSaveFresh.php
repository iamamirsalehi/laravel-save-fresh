<?php

namespace Iamamirsalehi\LaravelSaveFresh\Console\Commands;


use Illuminate\Console\Command;
use Illuminate\Database\Console\Migrations\FreshCommand;
use Illuminate\Support\Facades\Artisan;

class LaravelSaveFresh extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:save-fresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Save your data after fresh migrations';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        Artisan::call('backup:run --only-db');
        Artisan::call('migrate:fresh');

    }

}
