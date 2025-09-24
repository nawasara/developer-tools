<?php

namespace Nawasara\DeveloperTools;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class DeveloperToolsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'nawasara-developer-tools');
        if (class_exists(Livewire::class)) {
            Livewire::component('nawasara-developer-tools.components.developer-tools', \Nawasara\DeveloperTools\Livewire\Components\DeveloperTools::class);
        }
        $this->installWebTinker();
    }

    public function register()
    {
        //
    }

    protected function installWebTinker()
    {
        if (class_exists('Spatie\WebTinker\WebTinkerServiceProvider')) {
            try {
                \Artisan::call('web-tinker:install');
            } catch (\Exception $e) {
                // Ignore if already installed or error
            }
        }
    }
}
