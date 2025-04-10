<?php

namespace Repopattern\Arch\Commands;

use Illuminate\Console\Command;

class MakeArchitecture extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:architecture {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Genera todos los archivos de arquitectura del patron repositorio con algunos cambios ';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $name = $this->argument('name');

        $this->call('make:repository', ['name' => $name]);
        $this->call('make:service', ['name' => $name]);
        $this->call('make:dto', ['name' => $name]);
        $this->call('make:controller', ['name' => $name.'Controller', '--resource' => true , '--model' => $name ]);
        $this->call('make:request', ['name' => $name .'Request']);
        $this->call('make:resource', ['name' => $name .'Resource']);
       $this->info('Se han creado todos los archivos de arquitectura del patron repositorio con algunos cambios');


    }
}