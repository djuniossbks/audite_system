@csrf
@isset($donnee)
    @method('PUT')
@endisset

<div class="mb-3">
    <label class="form-label" for="titre">Titre</label>
    <input class="form-control @error('titre') is-invalid @enderror" id="titre" name="titre" value="{{ old('titre', $donnee->titre ?? '') }}" required>
    @error('titre')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="mb-3">
    <label class="form-label" for="description">Description</label>
    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="6" required>{{ old('description', $donnee->description ?? '') }}</textarea>
    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="d-flex gap-2">
    <button class="btn btn-success"><i class="bi bi-check2-circle me-1"></i>Enregistrer</button>
    <a class="btn btn-outline-secondary" href="{{ route('donnees.index') }}">Annuler</a>
</div>
