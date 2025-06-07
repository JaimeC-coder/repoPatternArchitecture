<?php

namespace Repopattern\Arch\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\App;
class MakeDtos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:dto {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Genera un DTO para la entidad especificada';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');

        $className = basename($name);
        $namespacePath = str_replace('/', '\\', dirname($name)); // prueba
        $namespace = $namespacePath === '.' ? 'App\DTOs' : 'App\DTOs\\' . $namespacePath;

        $dtoPath = App::basePath("app/DTOs/{$name}.php");

        if (file_exists($dtoPath)) {
            $this->error("El DTO {$className} ya existe.");
            return;
        }

        $stubPath = __DIR__ . '/../../stubs/dto.stub';

        if (!file_exists($stubPath)) {
            $this->error("No se encontró el stub.");
            return;
        }

        $stub = file_get_contents($stubPath);

        // Reemplazar variables
        $stub = str_replace(
            ['{{ namespace }}', '{{ class }}'],
            [$namespace, $className],
            $stub
        );

        $this->writeFile($dtoPath, $stub);

        $this->info("DTO {$className} creado exitosamente en {$dtoPath}");
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
}