<?php

namespace App\Providers;

use Native\Desktop\Facades\Window;
use Native\Desktop\Contracts\ProvidesPhpIni;
use Illuminate\Support\Facades\Artisan;

class NativeAppServiceProvider implements ProvidesPhpIni
{
    public function boot(): void
    {
        Artisan::call('migrate', [
            '--force'    => true,
            '--database' => 'nativephp',
        ]);

        Window::open()
            ->title('Faculty Document Manager')
            ->width(1200)
            ->height(800)
            ->showDevTools(false);   // ← add this
    }

    public function phpIni(): array
    {
        return [];
    }
}
