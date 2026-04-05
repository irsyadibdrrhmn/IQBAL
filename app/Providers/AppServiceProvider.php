<?php

namespace App\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Handle public/storage symlink gracefully
        $this->handleStorageSymlink();
    }

    /**
     * Handle the creation of public/storage symlink gracefully.
     * This prevents crashes on Railway deployment when the symlink already exists.
     */
    private function handleStorageSymlink(): void
    {
        $link = public_path('storage');
        $target = storage_path('app/public');

        // If link already exists, skip
        if (is_link($link)) {
            return;
        }

        // If directory exists but is not a symlink, remove it
        if (is_dir($link) && !is_link($link)) {
            try {
                File::deleteDirectory($link);
            } catch (\Exception $e) {
                // Silently ignore errors during cleanup
                return;
            }
        }

        // Create the symlink
        try {
            if (!is_link($link) && !is_dir($link)) {
                symlink($target, $link);
            }
        } catch (\Exception $e) {
            // Silently ignore if symlink creation fails
            // This is common in deployment environments
        }
    }
}
