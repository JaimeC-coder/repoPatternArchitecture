<?php

namespace Repopattern\Arch\Commands;

use Illuminate\Console\Command;

class OptimizeApp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:optimize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Limpia y optimiza la caché de la aplicación';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->call('cache:clear');
        $this->call('config:clear');
        $this->call('clear-compiled');
        $this->call('optimize');

        $this->info('La aplicación ha sido optimizada exitosamente.');
    }
}