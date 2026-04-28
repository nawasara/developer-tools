# Nawasara Developer Tools

Developer utilities for Nawasara Laravel projects. Ships a floating Livewire panel that exposes common Artisan commands and an embedded Tinker REPL.

## Features

- **Floating launcher** — small button in the corner of every page; opens a panel with the actions below
- **One-click Artisan commands** — clear cache, clear route, clear view, clear config, optimize, run migrate / migrate:fresh / db:seed
- **Refresh warning** — actions that bust caches surface a non-blocking hint to refresh the page so the new state takes effect
- **Web Tinker** — embedded in-browser Tinker REPL via `spatie/laravel-web-tinker` for quick model inspection without leaving the browser
- **Dev-only by convention** — the launcher Livewire component should be rendered only when `app()->environment('local')` (or behind a permission of your choice)

## Installation

```bash
composer require nawasara/developer-tools --dev
```

Auto-discovered. To render the launcher, add the Livewire component to your application layout:

```blade
@if (app()->environment('local'))
    <livewire:nawasara-developer-tools.components.developer-tools />
@endif
```

## Customization

Publish the views to override styling or layout:

```bash
php artisan vendor:publish --provider="Nawasara\DeveloperTools\DeveloperToolsServiceProvider"
```

## Author

**Pringgo J. Saputro** &lt;odyinggo@gmail.com&gt;

## License

MIT
