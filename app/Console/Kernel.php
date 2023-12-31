<?php

namespace App\Console;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            $orders = Order::query()->where('status', Order::STATUS_WAIT)
                ->where('created_at', '<', Carbon::now()->subMinutes(15))
                ->get();
            $orders?->each(function ($order) {
                $order->update(['status' => Order::STATUS_CACHE]);
            });
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
