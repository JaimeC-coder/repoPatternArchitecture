<?php

namespace Repopattern\Arch\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\App;

class MakeRepository extends Command
{
    protected $signature = 'make:repository {name}';
    protected $description = 'Genera un repositorio basado en un modelo';

    public function handle()
    {
        $name = $this->argument('name');

        $modelName = basename($name);                  
        $className = $modelName . 'Repository';        
        $namespacePath = str_replace('/', '\\', dirname($name));
        $namespace = $namespacePath === '.' ? 'App\Repositories' : 'App\Repositories\\' . $namespacePath;

        $repositoryPath = App::basePath("app/Repositories/{$name}Repository.php");
        $baseRepositoryPath = App::basePath("app/Repositories/BaseRepository.php");

        // 1. Generar BaseRepository si no existe
        if (!file_exists($baseRepositoryPath)) {
            $baseStubPath = $this->resolveStubPath('baseRepository.stub');

            if (!file_exists($baseStubPath)) {
                $this->error("No se encontró el stub 'baseRepository.stub'.");
                return;
            }

            $baseStub = file_get_contents($baseStubPath);
            $this->writeFile($baseRepositoryPath, $baseStub);
            $this->info("BaseRepository creado correctamente.");
        }

        // 2. Validar si ya existe el repositorio
        if (file_exists($repositoryPath)) {
            $this->error("El repositorio {$className} ya existe.");
            return;
        }

        // 3. Cargar stub del repositorio
        $stubPath = $this->resolveStubPath('repository.stub');

        if (!file_exists($stubPath)) {
            $this->error("No se encontró el stub del repositorio.");
            return;
        }

        $stub = file_get_contents($stubPath);
        $stub = str_replace(
            ['{{ namespace }}', '{{ class }}', '{{ model }}'],
            [$namespace, $className, $modelName],
            $stub
        );

        $this->writeFile($repositoryPath, $stub);
        $this->info("Repositorio '{$className}' creado correctamente en {$repositoryPath}");
    }

    private function writeFile($path, $content)
    {
        $filesystem = new Filesystem();

        if (!$filesystem->exists(dirname($path))) {
            $filesystem->makeDirectory(dirname($path), 0755, true);
        }

        if (!$filesystem->exists($path)) {
            $filesystem->put($path, $content);
        } else {
            $this->warn("El archivo ya existe: {$path}");
        }
    }

    private function resolveStubPath(string $stubName): string
    {
        $primaryPath = App::basePath("stubs/{$stubName}");
        $fallbackPath = __DIR__ . "/../../stubs/{$stubName}";

        return file_exists($primaryPath) ? $primaryPath : $fallbackPath;
    }
}
