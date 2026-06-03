@extends('layouts.app')

@section('title', 'Modifier utilisateur')

@section('content')
<div class="card table-card">
    <div class="card-header bg-white fw-semibold">Modifier {{ $utilisateur->name }}</div>
    <div class="card-body">
        <form method="POST" action="{{ route('utilisateurs.update', $utilisateur) }}">
            @include('utilisateurs._form', ['utilisateur' => $utilisateur])
        </form>
    </div>
</div>
@endsection
