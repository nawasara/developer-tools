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
    }

    public function register()
    {
        //
    }
}
