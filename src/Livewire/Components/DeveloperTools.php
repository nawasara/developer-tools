<?php

namespace Nawasara\DeveloperTools\Livewire\Components;

use Livewire\Component;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Output\BufferedOutput;

class DeveloperTools extends Component
{
    public $isOpen = false;
    public $output = '';
    public $commandRunning = false;
    public $currentCommand = '';
    public $needsRefresh = false;

    public function toggleTools()
    {
        $this->isOpen = !$this->isOpen;
        if (!$this->isOpen) {
            $this->resetOutput();
        }
    }

    public function runCommand($command)
    {
        $this->commandRunning = true;
        $this->currentCommand = $command;
        $this->output = "Running: {$command}\n\n";

        try {
            $output = new BufferedOutput();
            Artisan::call($command, [], $output);
            $this->output .= $output->fetch();
            $this->output .= "\n\nCommand executed successfully!";
            if (in_array($command, ['optimize', 'route:clear', 'cache:clear', 'view:clear', 'config:clear'])) {
                $this->needsRefresh = true;
                $this->output .= "\n\n⚠️ Page refresh required!";
            }
        } catch (\Exception $e) {
            $this->output .= "\n\nError: " . $e->getMessage();
        }

        $this->commandRunning = false;
    }

    public function runMigrateFresh()
    {
        $this->runCommand('migrate:fresh');
    }

    public function runMigrateFreshSeed()
    {
        $this->runCommand('migrate:fresh --seed');
    }

    public function runDbSeed()
    {
        $this->runCommand('db:seed');
    }

    public function runVendorPublish()
    {
        $this->runCommand('vendor:publish --all');
    }

    public function runClearCache()
    {
        $this->runCommand('cache:clear');
    }

    public function runRouteClear()
    {
        $this->runCommand('route:clear');
    }

    public function runOptimize()
    {
        $this->runCommand('optimize');
    }

    public function runStorageLink()
    {
        $this->runCommand('storage:link');
    }

    public function refreshPage()
    {
        return redirect()->to(url()->current());
    }

    public function resetOutput()
    {
        $this->output = '';
        $this->currentCommand = '';
        $this->needsRefresh = false;
    }
    
    public function render()
    {
        return view('nawasara-developer-tools::livewire.components.developer-tools');
    }
}
