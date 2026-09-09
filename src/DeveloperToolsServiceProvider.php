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

    /**
     * Memasang aset web-tinker — HANYA di lingkungan pengembangan, dan hanya
     * lewat perintah artisan, tidak pernah saat boot.
     *
     * ⚠️ Sebelumnya `Artisan::call('web-tinker:install')` dipanggil langsung
     * dari boot(). Perintah itu MEMINTA KONFIRMASI bila berkasnya sudah ada,
     * dan di lingkungan tanpa terminal ia menunggu jawaban yang tidak pernah
     * datang — proses menggantung selamanya, tanpa galat.
     *
     * Yang menyembunyikannya: di server yang berkasnya sudah terpasang,
     * perintahnya selesai seketika. Kegagalannya baru muncul di mesin BARU,
     * dan bentuknya bukan pesan galat melainkan container yang tidak pernah
     * sehat — nginx tidak pernah menyala karena entrypoint masih menunggu
     * `php artisan config:clear` yang tak kunjung selesai.
     *
     * `catch (\Exception)` juga tidak menolong: menggantung bukan exception.
     *
     * Terbukti 9 September 2026 saat memindahkan Nawasara ke LXC baru.
     */
    protected function installWebTinker()
    {
        // Produksi tidak pernah membutuhkan pemasangan aset saat runtime.
        if ($this->app->environment('production')) {
            return;
        }

        // Tetap tidak dijalankan saat melayani permintaan web; hanya berguna
        // di konsol, dan di sanalah tempatnya bila memang diperlukan.
        if (! $this->app->runningInConsole()) {
            return;
        }

        if (! class_exists('Spatie\WebTinker\WebTinkerServiceProvider')) {
            return;
        }

        // Sudah terpasang → tidak ada yang perlu dikerjakan. Pemeriksaan ini
        // yang menggantikan konfirmasi interaktif tadi.
        if (file_exists(public_path('vendor/web-tinker'))) {
            return;
        }

        try {
            \Artisan::call('web-tinker:install', ['--force' => true]);
        } catch (\Throwable $e) {
            // Dibiarkan diam: ini alat bantu pengembangan, dan kegagalannya
            // tidak boleh menghalangi aplikasi menyala.
        }
    }
}
