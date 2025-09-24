# Nawasara Developer Tools

Developer Tools package for Nawasara Laravel projects. Provides a floating Livewire-powered developer tools panel for common artisan commands.

## Installation

1. Install via composer:

```bash
composer require nawasara/developer-tools
```

2. Add the service provider if not auto-discovered:

```php
// config/app.php
'providers' => [
    // ...
    Nawasara\DeveloperTools\DeveloperToolsServiceProvider::class,
],
```

3. Add the Livewire component to your layout:

```blade
<livewire:nawasara-developer-tools.components.developer-tools />
```

## Features

-   Run common artisan commands from the UI
-   See command output and errors
-   Floating button and popup panel
-   Page refresh warning for cache/route/view/config clear

## Customization

You can publish the views for customization:

```bash
php artisan vendor:publish --provider="Nawasara\DeveloperTools\DeveloperToolsServiceProvider"
```

## License

MIT
