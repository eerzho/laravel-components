<?php

namespace Eerzho\LaravelComponents\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use Symfony\Component\Finder\SplFileInfo;

class PublishStubCommand extends Command
{
    use ConfirmableTrait;

    protected $signature = 'eerzho:publish {--force : Overwrite any existing files}';

    protected $description = 'Publish all opinionated stubs that are available for customization';

    /**
     * @return int|void
     */
    public function handle()
    {
        if (!$this->confirmToProceed()) {
            return 1;
        }
        
        if (!is_dir($stubsPath = $this->laravel->basePath('stubs'))) {
            (new Filesystem())->makeDirectory($stubsPath);
        }
        
        collect(File::files(__DIR__ . '/stubs'))->each(function (SplFileInfo $file) use ($stubsPath) {
            $sourcePath = $file->getPathname();

            $targetPath = $stubsPath . "/{$file->getFilename()}";
            
            if (!file_exists($targetPath) || $this->option('force')) {
                file_put_contents($targetPath, file_get_contents($sourcePath));
            }
        });

        $this->info('All done!');
    }
}
