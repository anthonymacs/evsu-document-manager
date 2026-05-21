<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BackupDatabase extends Command
{
    protected $signature   = 'db:backup';
    protected $description = 'Backup the SQLite database, keeping only the last 7 copies';

    public function handle()
    {
        $source    = config('database.connections.sqlite.database');
        $backupDir = storage_path('backups');
        $timestamp = now()->format('Y_m_d_His');
        $dest      = "{$backupDir}/nativephp_{$timestamp}.sqlite";

        
        if (! is_dir($backupDir)) {
            mkdir($backupDir, 0755, true);
        }

       
        if (! file_exists($source)) {
            $this->error("Database file not found: {$source}");
            return 1;
        }

        // Copy the SQLite file
        copy($source, $dest);
        $this->info("Backup created: {$dest}");

        // Keep only the last 7 backups — delete the rest
        $allBackups = collect(glob("{$backupDir}/nativephp_*.sqlite"))
            ->sort()
            ->values();

        if ($allBackups->count() > 7) {
            $toDelete = $allBackups->slice(0, $allBackups->count() - 7);

            foreach ($toDelete as $old) {
                unlink($old);
                $this->info("Deleted old backup: {$old}");
            }
        }

        $this->info("Backup complete. Total backups kept: " . min($allBackups->count(), 7));

        return 0;
    }
}