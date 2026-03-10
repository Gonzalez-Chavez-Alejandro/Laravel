<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // <--- AGREGA ESTA LÍNEA

class AppServiceProvider extends ServiceProvider
{
    public function register(): void { /* ... */ }

    public function boot(): void
    {
        // Fuerza a que todos los assets (Tailwind) usen HTTPS en Render
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}
