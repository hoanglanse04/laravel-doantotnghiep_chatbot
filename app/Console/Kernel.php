<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Đăng ký schedule tại đây nếu muốn tách riêng khỏi routes/console.php
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('sitemap:generate')->daily();
    }

    /**
     * Đăng ký các command Artisan
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        // hoặc thêm command route dạng file
        require base_path('routes/console.php');
    }
}
