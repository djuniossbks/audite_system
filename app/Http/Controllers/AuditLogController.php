<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\View\View;

class AuditLogController extends Controller
{
    public function index(): View
    {
        $auditLogs = AuditLog::with('utilisateur')
            ->latest('date_action')
            ->paginate(15);

        return view('audit.index', compact('auditLogs'));
    }
}
