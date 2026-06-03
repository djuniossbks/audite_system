@extends('layouts.app')

@section('title', 'Ajouter utilisateur')

@section('content')
<div class="card table-card">
    <div class="card-header bg-white fw-semibold">Nouvel utilisateur</div>
    <div class="card-body">
        <form method="POST" action="{{ route('utilisateurs.store') }}">
            @include('utilisateurs._form')
        </form>
    </div>
</div>
@endsection
