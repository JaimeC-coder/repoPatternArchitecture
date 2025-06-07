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
        $name = $this->argument('name'); // Ej: Admin/User

        $modelName = basename($name); // User
        $className = $modelName . 'Repository'; // UserRepository
        $namespacePath = str_replace('/', '\\', dirname($name));
        $namespace = $namespacePath === '.' ? 'App\Repositories' : 'App\Repositories\\' . $namespacePath;

        $repositoryPath = App::basePath("app/Repositories/{$name}Repository.php");

        // Crear BaseRepository si no existe
        $baseRepositoryPath = App::basePath("app/Repositories/BaseRepository.php");
        if (!file_exists($baseRepositoryPath)) {
            $baseStubPath = base_path('stubs/baseRepository.stub') ?: __DIR__ . '/../../stubs/baseRepository.stub';
            $baseStub = file_get_contents($baseStubPath);
            $this->writeFile($baseRepositoryPath, $baseStub);
            $this->info("BaseRepository creado correctamente.");
        }

        // Validar si ya existe el repositorio
        if (file_exists($repositoryPath)) {
            $this->error("El repositorio {$className} ya existe.");
            return;
        }

        // Cargar stub
        $stubPath = base_path('stubs/repository.stub') ?: __DIR__ . '/../../stubs/repository.stub';
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
        $filesystem->put($path, $content);
    }
}
