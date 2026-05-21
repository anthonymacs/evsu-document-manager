<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BackupController extends Controller
{
    // List all available backups
    public function index()
    {
        $source    = config('database.connections.sqlite.database');
        $backupDir = dirname($source) . DIRECTORY_SEPARATOR . 'backups';

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

    // Restore a selected backup
    public function restore(Request $request)
    {
        $request->validate([
            'filename' => ['required', 'string'],
        ]);

        $source    = config('database.connections.sqlite.database');
        $backupDir = dirname($source) . DIRECTORY_SEPARATOR . 'backups';
        $file      = "{$backupDir}/{$request->filename}";

        if (! file_exists($file)) {
            return back()->with('error', 'Backup file not found.');
        }

        // Disconnect DB before overwriting
        DB::disconnect();

        copy($file, $source);

        return redirect()->route('login')
            ->with('success', 'Database restored successfully from: ' . $request->filename);
    }
}