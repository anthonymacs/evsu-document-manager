<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $query = AuditLog::latest();

        if ($request->filled('search')) {
            $query->where('description', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        if ($request->filled('subject_type')) {
            $query->where('subject_type', $request->subject_type);
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $logs = $query->paginate(15)->withQueryString();

        // Stats
        $totalActions  = AuditLog::count();
        $totalCreated  = AuditLog::where('action', 'created')->count();
        $totalUpdated  = AuditLog::where('action', 'updated')->count();
        $totalDeleted  = AuditLog::where('action', 'deleted')->count();

        return view('auditlogs.index', compact(
            'logs',
            'totalActions',
            'totalCreated',
            'totalUpdated',
            'totalDeleted'
        ));
    }
}