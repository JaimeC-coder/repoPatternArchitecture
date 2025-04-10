<?php
namespace Repopattern\Arch;

use Illuminate\Support\ServiceProvider;

class TestServiceProvider extends ServiceProvider
{
 

    public function boot()
    {
        // Aquí registras los comandos
        if ($this->app->runningInConsole()) {
            $this->commands([
                Commands\MakeService::class,
                Commands\MakeRepository::class,
                Commands\MakeArchitecture::class,
                Commands\OptimizeApp::class,
                Commands\MakeDtos::class,
                // agrega más comandos si tienes
            ]);
        }
    }
}