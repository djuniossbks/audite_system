@csrf
@isset($utilisateur)
    @method('PUT')
@endisset

<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label" for="name">Nom</label>
        <input class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $utilisateur->name ?? '') }}" required>
        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label" for="email">Email</label>
        <input class="form-control @error('email') is-invalid @enderror" id="email" type="email" name="email" value="{{ old('email', $utilisateur->email ?? '') }}" required>
        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label" for="password">Mot de passe</label>
        <input class="form-control @error('password') is-invalid @enderror" id="password" type="password" name="password" @empty($utilisateur) required @endempty>
        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label" for="password_confirmation">Confirmation</label>
        <input class="form-control" id="password_confirmation" type="password" name="password_confirmation" @empty($utilisateur) required @endempty>
    </div>
    <div class="col-md-6">
        <label class="form-label" for="role">Rôle</label>
        <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
            @foreach(['admin' => 'Admin', 'utilisateur' => 'Utilisateur'] as $value => $label)
                <option value="{{ $value }}" @selected(old('role', $utilisateur->role ?? 'utilisateur') === $value)>{{ $label }}</option>
            @endforeach
        </select>
        @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>

<div class="d-flex gap-2 mt-4">
    <button class="btn btn-success"><i class="bi bi-check2-circle me-1"></i>Enregistrer</button>
    <a class="btn btn-outline-secondary" href="{{ route('utilisateurs.index') }}">Annuler</a>
</div>
