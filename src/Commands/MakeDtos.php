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

        if (!is_dir(App::basePath("app/DTOs"))) {
            mkdir(App::basePath("app/DTOs"), 0755, true);
        }


        $path = App::basePath("app/Dtos/{$name}Dto.php");


        if (file_exists($path)) {
            $this->error("El DTO {$name}Dto ya existe.");
            return;
        }
        $dtoPath = App::basePath("app/DTOs/{$name}DTO.php");

        $stub =  "<?php\n\nnamespace App\DTOs;\n\nclass {$name}DTO\n{\n    public function __construct(\$data)\n    {\n        foreach (\$data as \$key => \$value) {\n            \$this->{\$key} = \$value;\n        }\n    }\n}";
        $this->writeFile($dtoPath, $stub);

        $this->info("DTO {$name}Dto creado exitosamente en {$path}");
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