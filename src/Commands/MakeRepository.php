<?php

namespace Repopattern\Arch\Commands;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;

class MakeRepository extends Command
{
    protected $signature = 'make:repository {name}';
    protected $description = 'Genera un repositorio basado en un modelo';

    public function handle()
    {
        $name = $this->argument('name');

        // Crear el repositorio base si no existe
        $baseRepositoryPath = App::basePath("Repositories/BaseRepository.php");
        if (!file_exists($baseRepositoryPath)) {
            $baseRepositoryStub = "<?php\n\nnamespace App\Repositories;\n\nuse Illuminate\Database\Eloquent\Model;\n\nclass BaseRepository\n{\n    protected \$model;\n\n    public function __construct(Model \$model)\n    {\n        \$this->model = \$model;\n    }\n\n    public function create(array \$data)\n    {\n        return \$this->model->create(\$data);\n    }\n\n    public function all()\n    {\n        return \$this->model->all();\n    }\n\n    public function find(\$id)\n    {\n        return \$this->model->find(\$id);\n    }\n\n    public function update(\$id, array \$data)\n    {\n        \$record = \$this->model->find(\$id);\n        if (\$record) {\n            \$record->update(\$data);\n            return \$record;\n        }\n        return null;\n    }\n\n    public function delete(\$id)\n    {\n        \$record = \$this->model->find(\$id);\n        if (\$record) {\n            \$record->delete();\n            return true;\n        }\n        return false;\n    }\n}";
            $this->writeFile($baseRepositoryPath, $baseRepositoryStub);
            $this->info("BaseRepository creado correctamente.");
        }

        // Crear el repositorio específico
        $repositoryPath = App::basePath("Repositories/{$name}Repository.php");
        if (file_exists($repositoryPath)) {
            $this->error("El repositorio {$name}Repository ya existe.");
            return;
        }

        $repositoryStub = "<?php\n\nnamespace App\Repositories;\n\nuse App\Models\\{$name};\n\nclass {$name}Repository extends BaseRepository\n{\n    public function __construct()\n    {\n        parent::__construct(new {$name}());\n    }\n}";
        
        $this->writeFile($repositoryPath, $repositoryStub);

        $this->info("Repositorio '{$name}Repository' creado correctamente.");
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
