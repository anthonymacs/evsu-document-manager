<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BackupController extends Controller
{
    private function backupDir(): string
    {
        $source = config('database.connections.sqlite.database');
        return dirname($source) . DIRECTORY_SEPARATOR . 'backups';
    }

    // List all available backups
    public function index()
    {
        $backupDir = $this->backupDir();

        $backups = collect(glob("{$backupDir}/nativephp_*.sqlite"))
            ->sort()
            ->reverse()
            ->map(fn($path) => [
                'filename' => basename($path),
                'path'     => $path,
                'size'     => round(filesize($path) / 1024, 2) . ' KB',
                'date'     => date('M d, Y h:i A', filemtime($path)),
            ])
            ->values();

        return view('backup.index', compact('backups'));
    }

    // Manual backup trigger
    public function store()
    {
        $source    = config('database.connections.sqlite.database');
        $backupDir = $this->backupDir();
        $timestamp = now()->format('Y_m_d_His');
        $dest      = "{$backupDir}/nativephp_{$timestamp}.sqlite";

        if (! is_dir($backupDir)) {
            mkdir($backupDir, 0755, true);
        }

        if (! file_exists($source)) {
            return back()->with('error', 'Database file not found: ' . $source);
        }

        $copied = copy($source, $dest);

        if (! $copied) {
            return back()->with('error', 'Failed to create backup. Check folder permissions.');
        }

        return back()->with('success', 'Backup created: ' . basename($dest));
    }

    // Restore a selected backup
    public function restore(Request $request)
    {
        $request->validate([
            'filename' => ['required', 'string'],
        ]);

        $source    = config('database.connections.sqlite.database');
        $backupDir = $this->backupDir();
        $file      = "{$backupDir}/{$request->filename}";

        if (! file_exists($file)) {
            return back()->with('error', 'Backup file not found: ' . $request->filename);
        }

        // Fully release the SQLite connection before overwriting
        DB::purge('sqlite');
        DB::disconnect('sqlite');

        $copied = copy($file, $source);

        if (! $copied) {
            return back()->with('error', 'Restore failed. Check file permissions on: ' . $source);
        }

        // Force fresh connection to the restored DB
        DB::reconnect('sqlite');

        return redirect()->route('login')
            ->with('success', 'Database restored successfully from: ' . $request->filename);
    }
}