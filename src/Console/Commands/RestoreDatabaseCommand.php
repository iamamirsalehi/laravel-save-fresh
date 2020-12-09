<?php
namespace Iamamirsalehi\LaravelSaveFresh\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Console\Migrations\FreshCommand;
use Illuminate\Support\Facades\Artisan;

class RestoreDatabaseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:restore';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'backup your database';

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

    }

}
