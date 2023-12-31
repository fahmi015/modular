<?php

namespace Modular\Modular\Console;

use Symfony\Component\Process\Process;

trait BackendPackages
{
    /**
     * Install the Composer dependencies.
     *
     * @return void
     */
    protected function setupBackendPackages()
    {
        $this->components->info('Publishing vendor files...');
        $this->publishVendorFiles();
    }

    protected function publishVendorFiles()
    {
        (new Process([$this->phpBinary(), 'artisan', 'vendor:publish', '--provider=Spatie\Permission\PermissionServiceProvider'], base_path()))
            ->setTimeout(null)
            ->run(function ($type, $output) {
                $this->output->write($output);
            });

        (new Process([$this->phpBinary(), 'artisan', 'config:clear'], base_path()))
            ->setTimeout(null)
            ->run(function ($type, $output) {
                $this->output->write($output);
            });

        (new Process([$this->phpBinary(), 'artisan', 'vendor:publish', '--provider=Spatie\Activitylog\ActivitylogServiceProvider', '--tag=activitylog-migrations'], base_path()))
            ->setTimeout(null)
            ->run(function ($type, $output) {
                $this->output->write($output);
            });

        (new Process([$this->phpBinary(), 'artisan', 'vendor:publish', '--provider=Spatie\Activitylog\ActivitylogServiceProvider', '--tag=activitylog-config'], base_path()))
            ->setTimeout(null)
            ->run(function ($type, $output) {
                $this->output->write($output);
            });
    }
}
