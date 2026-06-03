@extends('layouts.app')

@section('title', 'Ajouter donnée')

@section('content')
<div class="card table-card">
    <div class="card-header bg-white fw-semibold">Nouvelle donnée</div>
    <div class="card-body">
        <form method="POST" action="{{ route('donnees.store') }}">
            @include('donnees._form')
        </form>
    </div>
</div>
@endsection
