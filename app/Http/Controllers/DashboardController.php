<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Donnee;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $stats = [
            'utilisateurs' => User::count(),
            'donnees' => Donnee::count(),
            'audits' => AuditLog::count(),
            'admins' => User::where('role', 'admin')->count(),
            'ajouts' => AuditLog::where('action', 'like', 'Ajout%')->count(),
            'suppressions' => AuditLog::where('action', 'like', 'Suppression%')->count(),
        ];

        $dernieresActivites = AuditLog::with('utilisateur')
            ->latest('date_action')
            ->limit(8)
            ->get();

        $actionsParJour = AuditLog::query()
            ->selectRaw('DATE(date_action) as jour, COUNT(*) as total')
            ->groupBy('jour')
            ->orderBy('jour')
            ->limit(7)
            ->pluck('total', 'jour');

        $roles = User::query()
            ->select('role', DB::raw('COUNT(*) as total'))
            ->groupBy('role')
            ->pluck('total', 'role');

        $actionsParType = [
            'Ajouts' => AuditLog::where('action', 'like', 'Ajout%')->count(),
            'Modifications' => AuditLog::where('action', 'like', 'Modification%')->count(),
            'Suppressions' => AuditLog::where('action', 'like', 'Suppression%')->count(),
            'Consultations' => AuditLog::where('action', 'like', 'Consultation%')->count(),
            'Sessions' => AuditLog::where(function ($query): void {
                $query->where('action', 'like', "%connecté%")
                    ->orWhere('action', 'like', "%déconnecté%");
            })->count(),
        ];

        $dernieresDonnees = Donnee::with('utilisateur')
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'stats',
            'dernieresActivites',
            'actionsParJour',
            'roles',
            'actionsParType',
            'dernieresDonnees'
        ));
    }
}
