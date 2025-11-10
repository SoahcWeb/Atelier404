@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Nouvelle intervention</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('interventions.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label for="nom">Nom :</label>
        <input type="text" name="nom" required>

        <label for="email">Email :</label>
        <input type="email" name="email" required>

        <label for="telephone">Téléphone :</label>
        <input type="text" name="telephone" required>

        <label for="appareil">Appareil :</label>
        <input type="text" name="appareil" required>

        <label for="description_probleme">Description du problème :</label>
        <textarea name="description_probleme" required></textarea>

        <label for="images">Images (max 3) :</label>
        <input type="file" name="images[]" multiple accept="image/*">

        <button type="submit">Envoyer</button>
    </form>
</div>
@endsection
