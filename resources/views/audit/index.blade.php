@extends('layouts.app')

@section('title', 'Audit')

@section('content')
<div class="card table-card">
    <div class="card-header bg-white fw-semibold">Journal des actions</div>
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>ID</th><th>Utilisateur</th><th>Action</th><th>Table</th><th>Élément</th><th>IP</th><th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($auditLogs as $log)
                    <tr>
                        <td>{{ $log->id }}</td>
                        <td>{{ optional($log->utilisateur)->name ?? 'Système' }}</td>
                        <td>{{ $log->action }}</td>
                        <td>{{ $log->table_modifiee }}</td>
                        <td>{{ $log->element_id }}</td>
                        <td>{{ $log->adresse_ip }}</td>
                        <td>{{ $log->date_action?->format('d/m/Y H:i:s') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">Aucune action enregistrée.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-white">{{ $auditLogs->links() }}</div>
</div>
@endsection
