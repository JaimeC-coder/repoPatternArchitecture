<?php

namespace Repopattern\Arch\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;


class MakeService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Genera un servicio para la entidad especificada';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');

        $path = App::basePath("app/Services/{$name}Service.php");

        if (file_exists($path)) {
            $this->error("El servicio {$name}Service ya existe.");
            return;
        }

        $servicePath = App::basePath("app/Services/{$name}Service.php");

        $stub = "<?php\n\nnamespace App\Services;\n\nuse App\Repositories\\{$name}Repository;\nuse App\DTOs\\{$name}DTO;\n\nclass {$name}Service\n{\n    protected \${$name}Repository;\n\n    public function __construct({$name}Repository \${$name}Repository)\n    {\n        \$this->{$name}Repository = \${$name}Repository;\n    }\n\n    public function create({$name}DTO \$dto)\n    {\n        return \$this->{$name}Repository->create((array) \$dto);\n    }\n}";

        $this->writeFile($servicePath, $stub);

        $this->info("Servicio '{$name}' generado correctamente.");
    }
    private function writeFile($path, $content)
    {
        $filesystem = new \Illuminate\Filesystem\Filesystem();
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