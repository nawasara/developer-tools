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

    /**
     * Aset web-tinker TIDAK dipasang dari sini.
     *
     * ⚠️ boot() dulu memanggil `Artisan::call('web-tinker:install')` pada
     * SETIAP permintaan. Perintah itu membungkus `vendor:publish`, yang
     * BERTANYA saat berkasnya sudah ada — dan di lingkungan tanpa terminal
     * pertanyaan itu menunggu jawaban yang tak pernah datang. Prosesnya
     * menggantung selamanya, tanpa galat.
     *
     * `--force` tidak menolong: signature `web-tinker:install` kosong, jadi
     * opsi itu justru ditolak. Yang menerima --force adalah vendor:publish,
     * dan ia tidak terjangkau dari sini.
     *
     * `catch (\Exception)` juga tidak menolong — menggantung bukan exception.
     *
     * Yang menyembunyikannya bertahun-tahun: di server yang asetnya sudah
     * terpasang, perintah ini selesai seketika. Kegagalannya hanya muncul di
     * mesin BARU, dan bentuknya bukan pesan galat melainkan container yang
     * tidak pernah sehat — nginx tak kunjung menyala karena entrypoint masih
     * menunggu `php artisan config:clear`, yang menunggu provider ini.
     *
     * Memasang aset adalah pekerjaan SEKALI saat penyiapan, bukan pekerjaan
     * runtime. Bila web-tinker dipakai, jalankan sendiri:
     *
     *     php artisan vendor:publish --tag=web-tinker-assets
     *
     * Terbukti 9 September 2026 saat memindahkan Nawasara ke LXC sendiri.
     */
}
