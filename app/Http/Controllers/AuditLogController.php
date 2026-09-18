<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;

class AuditLogController extends Controller
{
    public function index()
    {
        abort_unless(auth()->user()->hasAnyRole(['Admin', 'Manager']), 403);
        $logs = ActivityLog::with('user')->latest()->paginate(30);
        return view('audit-logs.index', compact('logs'));
    }
}
