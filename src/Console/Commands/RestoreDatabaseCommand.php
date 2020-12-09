<?php
namespace Iamamirsalehi\LaravelSaveFresh\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Console\Migrations\FreshCommand;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Exception\ProcessFailedException;

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
    protected $description = 'restore your database';

    protected $zipper;
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
        $this->upZipSqlBackupZipFile();
    }

    public function upZipSqlBackupZipFile()
    {

        $zipFile = new \PhpZip\ZipFile();
        try{

            $zipFile
                ->openFile($this->getBackupFilePath()) // open archive from file
                ->extractTo($this->getStoreSqlFilePath()); // extract files to the specified directory

            $this->restore($this->getSqlFile());
        }
        catch(\PhpZip\Exception\ZipException $e){
            throw new \Exception($e->getMessage());
        }
        finally{
            $zipFile->close();
        }
    }

    public function restore($backupSqlFilePath)
    {
        $database = [
            'user'    => '-u ' . env('DB_USERNAME'),
            'pass'    => '-p ' . env('DB_PASSWORD'),
            'db_name' =>  env('DB_DATABASE'),
            'sqlFile' =>  $backupSqlFilePath
        ];

        $process = \Symfony\Component\Process\Process::fromShellCommandline("mysql {$database['user']} {$database['pass']} {$database['db_name']} < {$database['sqlFile']}");
        $process->run();
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
    }


    public function getSqlFile()
    {
        return realpath($this->getStoreSqlFilePath() . '\\db-dumps\\mysql-' . env('DB_DATABASE') . '.sql');
    }

    public function getBackupFilePath()
    {
        return realpath(storage_path( 'app\\' . array_reverse(Storage::files('Laravel'))[0]));
    }

    public function getStoreSqlFilePath()
    {
        if(!is_dir(storage_path('app/sql-tmp')))
            mkdir(storage_path('app/sql-tmp'), 0755);

        return realpath(storage_path('app/sql-tmp'));
    }
}
