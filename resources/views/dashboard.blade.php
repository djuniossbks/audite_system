@extends('layouts.app')

@section('title', 'Tableau de bord')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card h-100" style="--accent: var(--as-blue);">
            <div class="card-body d-flex justify-content-between align-items-start">
                <div>
                    <div class="metric-label mb-2">Utilisateurs</div>
                    <div class="metric-value">{{ $stats['utilisateurs'] }}</div>
                    <div class="text-muted mt-2">{{ $stats['admins'] }} administrateur(s)</div>
                </div>
                <div class="stat-icon"><i class="bi bi-people-fill fs-4"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card h-100" style="--accent: var(--as-teal);">
            <div class="card-body d-flex justify-content-between align-items-start">
                <div>
                    <div class="metric-label mb-2">Données</div>
                    <div class="metric-value">{{ $stats['donnees'] }}</div>
                    <div class="text-muted mt-2">Objets enregistrés</div>
                </div>
                <div class="stat-icon"><i class="bi bi-database-fill-lock fs-4"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card h-100" style="--accent: var(--as-amber);">
            <div class="card-body d-flex justify-content-between align-items-start">
                <div>
                    <div class="metric-label mb-2">Actions audit</div>
                    <div class="metric-value">{{ $stats['audits'] }}</div>
                    <div class="text-muted mt-2">Événements tracés</div>
                </div>
                <div class="stat-icon"><i class="bi bi-activity fs-4"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card h-100" style="--accent: var(--as-rose);">
            <div class="card-body d-flex justify-content-between align-items-start">
                <div>
                    <div class="metric-label mb-2">Suppressions</div>
                    <div class="metric-value">{{ $stats['suppressions'] }}</div>
                    <div class="text-muted mt-2">{{ $stats['ajouts'] }} ajout(s)</div>
                </div>
                <div class="stat-icon"><i class="bi bi-exclamation-triangle-fill fs-4"></i></div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-xl-8">
        <div class="card enterprise-card h-100">
            <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                <div>
                    <div class="section-title">Volume d'activité</div>
                    <div class="text-muted small">Actions enregistrées sur les derniers jours</div>
                </div>
                <span class="badge rounded-pill text-bg-primary">Audit</span>
            </div>
            <div class="card-body px-4">
                <canvas id="auditTrendChart" height="120"></canvas>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card enterprise-card h-100">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <div class="section-title">Répartition des rôles</div>
                <div class="text-muted small">Profil des comptes actifs</div>
            </div>
            <div class="card-body">
                <canvas id="rolesChart" height="220"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mt-1">
    <div class="col-xl-4">
        <div class="card enterprise-card h-100">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <div class="section-title">Types d'actions</div>
                <div class="text-muted small">Structure du journal de sécurité</div>
            </div>
            <div class="card-body">
                <canvas id="actionsChart" height="240"></canvas>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card enterprise-card h-100">
            <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                <div>
                    <div class="section-title">Dernières données</div>
                    <div class="text-muted small">Enregistrements récents</div>
                </div>
                <a class="btn btn-sm btn-outline-primary" href="{{ route('donnees.index') }}">Voir</a>
            </div>
            <div class="list-group list-group-flush">
                @forelse($dernieresDonnees as $donnee)
                    <a class="list-group-item list-group-item-action px-4 py-3" href="{{ route('donnees.show', $donnee) }}">
                        <div class="d-flex justify-content-between gap-3">
                            <div class="fw-semibold text-truncate">{{ $donnee->titre }}</div>
                            <small class="text-muted">{{ $donnee->created_at?->format('d/m') }}</small>
                        </div>
                        <small class="text-muted">{{ $donnee->utilisateur->name }}</small>
                    </a>
                @empty
                    <div class="list-group-item px-4 py-4 text-muted">Aucune donnée.</div>
                @endforelse
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card enterprise-card h-100">
            <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                <div>
                    <div class="section-title">Activités récentes</div>
                    <div class="text-muted small">Derniers événements sensibles</div>
                </div>
                @if(auth()->user()->isAdmin())
                    <a class="btn btn-sm btn-outline-primary" href="{{ route('audit.index') }}">Audit</a>
                @endif
            </div>
            <div class="card-body pt-0">
                @forelse($dernieresActivites as $log)
                    <div class="d-flex gap-3 py-3 border-bottom">
                        <span class="timeline-dot"></span>
                        <div class="min-w-0">
                            <div class="fw-semibold">{{ $log->action }}</div>
                            <small class="text-muted">{{ optional($log->utilisateur)->name ?? 'Système' }} · {{ $log->date_action?->format('d/m/Y H:i') }}</small>
                        </div>
                    </div>
                @empty
                    <div class="text-muted py-4">Aucune activité.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.5.1/dist/chart.umd.min.js"></script>
<script>
const gridColor = '#e5e9f2';
const textColor = '#64748b';

new Chart(document.getElementById('auditTrendChart'), {
    type: 'line',
    data: {
        labels: @json($actionsParJour->keys()),
        datasets: [{
            label: 'Actions',
            data: @json($actionsParJour->values()),
            borderColor: '#2563eb',
            backgroundColor: 'rgba(37, 99, 235, .12)',
            fill: true,
            tension: .38,
            pointRadius: 4,
            pointBackgroundColor: '#ffffff',
            pointBorderWidth: 2
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            x: { grid: { display: false }, ticks: { color: textColor } },
            y: { beginAtZero: true, grid: { color: gridColor }, ticks: { color: textColor, precision: 0 } }
        }
    }
});

new Chart(document.getElementById('rolesChart'), {
    type: 'doughnut',
    data: {
        labels: @json($roles->keys()),
        datasets: [{
            data: @json($roles->values()),
            backgroundColor: ['#2563eb', '#0f766e', '#d97706'],
            borderWidth: 0
        }]
    },
    options: {
        cutout: '68%',
        plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, boxWidth: 8 } } }
    }
});

new Chart(document.getElementById('actionsChart'), {
    type: 'bar',
    data: {
        labels: @json(array_keys($actionsParType)),
        datasets: [{
            label: 'Actions',
            data: @json(array_values($actionsParType)),
            backgroundColor: ['#0f766e', '#2563eb', '#e11d48', '#d97706', '#475569'],
            borderRadius: 8
        }]
    },
    options: {
        indexAxis: 'y',
        plugins: { legend: { display: false } },
        scales: {
            x: { beginAtZero: true, grid: { color: gridColor }, ticks: { precision: 0, color: textColor } },
            y: { grid: { display: false }, ticks: { color: textColor } }
        }
    }
});
</script>
@endpush
