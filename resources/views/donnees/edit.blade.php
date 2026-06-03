@extends('layouts.app')

@section('title', 'Modifier donnée')

@section('content')
<div class="card table-card">
    <div class="card-header bg-white fw-semibold">Modifier {{ $donnee->titre }}</div>
    <div class="card-body">
        <form method="POST" action="{{ route('donnees.update', $donnee) }}">
            @include('donnees._form', ['donnee' => $donnee])
        </form>
    </div>
</div>
@endsection
