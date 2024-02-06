<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GroupMigrate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:group-migrate';

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
        $this->call('migrate');
        $this->call('migrate', ['--path' => '/database/migrations/config']);
        $this->call('migrate', ['--path' => '/database/migrations/default']);
        $this->call('migrate', ['--path' => '/database/migrations/payment']);

        $this->call('migrate', ['--path' => '/database/migrations/class']);
        $this->call('migrate', ['--path' => '/database/migrations/category']);

        $this->call('migrate', ['--path' => '/database/migrations/links']);
    }
}
