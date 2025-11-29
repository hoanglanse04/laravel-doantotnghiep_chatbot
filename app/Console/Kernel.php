<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Khai báo các Artisan Commands ở đây
     */
    protected $commands = [
        \App\Console\Commands\EmbedFaqProducts::class,
    ];

    /**
     * Đăng ký schedule
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('sitemap:generate')->daily();
    }

    /**
     * Load commands từ thư mục và từ routes/console.php
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
