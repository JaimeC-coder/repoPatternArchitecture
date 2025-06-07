<?php

namespace Repopattern\Arch\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\App;

class MakeService extends Command
{
    protected $signature = 'make:service {name}';
    protected $description = 'Genera un servicio para la entidad especificada';

    public function handle()
    {
        $name = $this->argument('name');

        $modelName = basename($name);               // Ej: User
        $className = $modelName . 'Service';        // Ej: UserService
        $varName = lcfirst($modelName) . 'Repository';

        $namespacePath = str_replace('/', '\\', dirname($name));
        $namespace = $namespacePath === '.' ? 'App\Services' : 'App\Services\\' . $namespacePath;

        $dtoNamespace = $namespacePath === '.' ? 'App\DTOs' : 'App\DTOs\\' . $namespacePath;
        $repoNamespace = $namespacePath === '.' ? 'App\Repositories' : 'App\Repositories\\' . $namespacePath;

        $servicePath = App::basePath("app/Services/{$name}Service.php");

        if (file_exists($servicePath)) {
            $this->error("El servicio {$className} ya existe.");
            return;
        }

        $stubPath = App::basePath('stubs/service.stub');
        if (!file_exists($stubPath)) {
            $stubPath = __DIR__ . '/../../stubs/service.stub';
        }

        if (!file_exists($stubPath)) {
            $this->error("No se encontró el stub del servicio.");
            return;
        }

        $stub = file_get_contents($stubPath);

        $stub = str_replace(
            ['{{ namespace }}', '{{ class }}', '{{ model }}', '{{ var }}', '{{ repoNamespace }}', '{{ dtoNamespace }}'],
            [$namespace, $className, $modelName, $varName, $repoNamespace, $dtoNamespace],
            $stub
        );

        $this->writeFile($servicePath, $stub);
        $this->info("Servicio '{$className}' generado correctamente en {$servicePath}");
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
