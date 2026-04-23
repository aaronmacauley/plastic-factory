<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

// 🔥 ini kurang
use Illuminate\Filesystem\Filesystem;

// 🔥 ini juga kurang

class MakeService extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'make:service {name}';

    /**
     * The console command description.
     */
    protected $description = 'Create a new service class';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');

        $className = Str::studly($name);
        $fileName = $className . '.php';

        $path = app_path("Services/{$fileName}");

        $filesystem = new Filesystem();

        if ($filesystem->exists($path)) {
            $this->error('Service already exists!');
            return;
        }

        // Ensure directory exists
        if (!$filesystem->isDirectory(app_path('Services'))) {
            $filesystem->makeDirectory(app_path('Services'), 0755, true);
        }

        $stub = $this->getStub($className);

        $filesystem->put($path, $stub);

        $this->info("Service created successfully: {$className}");
    }

    protected function getStub($className)
    {
        return <<<PHP
<?php

namespace App\Services;

class {$className}
{
    public function getAll()
    {
        //
    }

    public function findById(\$id)
    {
        //
    }

    public function store(array \$data)
    {
        //
    }

    public function update(\$id, array \$data)
    {
        //
    }

    public function delete(\$id)
    {
        //
    }
}
PHP;
    }

}
