<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BackupDatabase extends Command
{
    protected $signature   = 'db:backup {--force : Force backup regardless of time window or existing backups}';
    protected $description = 'Backup the SQLite database, keeping only the last 7 copies';

    public function handle(): int
    {
        if (! $this->option('force') && ! $this->isWithinBackupWindow()) {
            $this->info('Outside backup window. Skipping.');
            return 0;
        }

        if (! $this->sourceExists()) {
            $this->error('Database file not found: ' . $this->source());
            return 1;
        }

        $this->ensureBackupDirExists();

        if (! $this->option('force') && $this->alreadyBackedUpThisHour()) {
            $this->info('Backup already exists for this hour. Skipping.');
            return 0;
        }

        $this->deleteTodaysBackups();
        $this->createBackup();
        $this->pruneOldBackups();

        $this->info('Backup complete.');

        return 0;
    }

    private function source(): string
    {
        return config('database.connections.sqlite.database');
    }

    private function backupDir(): string
    {
        return dirname($this->source()) . DIRECTORY_SEPARATOR . 'backups';
    }

    private function isWithinBackupWindow(): bool
    {
        $hour = now()->hour;
        return $hour >= 6 && $hour < 12;
    }

    private function sourceExists(): bool
    {
        return file_exists($this->source());
    }

    private function ensureBackupDirExists(): void
    {
        if (! is_dir($this->backupDir())) {
            mkdir($this->backupDir(), 0755, true);
        }
    }

    private function alreadyBackedUpThisHour(): bool
    {
        $hourPrefix = 'backup_' . now()->format('Y_m_d_H');

        return collect(glob($this->backupDir() . '/backup_*.sqlite'))
            ->filter(fn($p) => str_starts_with(basename($p), $hourPrefix))
            ->isNotEmpty();
    }

    private function deleteTodaysBackups(): void
    {
        $todayPrefix = 'backup_' . now()->format('Y_m_d_');

        collect(glob($this->backupDir() . '/backup_*.sqlite'))
            ->filter(fn($p) => str_starts_with(basename($p), $todayPrefix))
            ->each(function ($path) {
                unlink($path);
                $this->info('Deleted duplicate: ' . basename($path));
            });
    }

    private function createBackup(): void
    {
        $dest = $this->backupDir() . '/backup_' . now()->format('Y_m_d_His') . '.sqlite';
        copy($this->source(), $dest);
        $this->info('Backup created: ' . basename($dest));
    }

    private function pruneOldBackups(): void
    {
        $all = collect(glob($this->backupDir() . '/backup_*.sqlite'))
            ->sort()
            ->values();

        if ($all->count() <= 7) {
            return;
        }

        $all->slice(0, $all->count() - 7)
            ->each(function ($path) {
                unlink($path);
                $this->info('Pruned old backup: ' . basename($path));
            });
    }
}