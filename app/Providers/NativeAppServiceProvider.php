<?php

namespace App\Providers;

use Native\Desktop\Facades\Window;
use Native\Desktop\Contracts\ProvidesPhpIni;
use Illuminate\Support\Facades\Artisan;

class NativeAppServiceProvider implements ProvidesPhpIni
{
    public function boot(): void
    {

        $this->backupDatabase();

        Window::open()
            ->title('LogTrack - Faculty Document Manager')
            ->width(1280)
            ->height(720)
            ->maximized()
            ->showDevTools(false)
            ->hideMenu();
    }

    public function phpIni(): array
    {
        return [];
    }

    private function backupDatabase(): void
    {
        $hour = now()->hour;

        if ($hour >= 6 && $hour < 12) {
            Artisan::call('db:backup');
        }
    }
}
