<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\JobVacancy; // Pastikan untuk mengimpor model JobVacancy
use Illuminate\Support\Carbon; // Impor Carbon
use Illuminate\Support\Facades\Log; // Impor Log untuk debugging

class UpdateVacancyStatusCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vacancies:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks for expired job vacancies and updates their status to "closed"';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Ambil tanggal hari ini
        $today = Carbon::now()->toDateString();

        // Cari lowongan yang masih 'active' tapi tanggal 'end_date'-nya sudah lewat
        $expiredVacancies = JobVacancy::where('status', 'active')
                                      ->where('end_date', '<', $today)
                                      ->get();

        if ($expiredVacancies->count() > 0) {
            // Update status lowongan yang ditemukan menjadi 'closed'
            $updatedCount = JobVacancy::whereIn('id', $expiredVacancies->pluck('id'))
                                       ->update(['status' => 'closed']);

            $this->info("Successfully updated {$updatedCount} expired job vacancies to 'closed'.");
            Log::info("Scheduler: Successfully updated {$updatedCount} expired job vacancies to 'closed'.");
        } else {
            $this->info('No expired job vacancies to update.');
            Log::info('Scheduler: No expired job vacancies to update.');
        }

        return 0;
    }
}