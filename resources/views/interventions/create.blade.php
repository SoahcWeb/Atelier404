<x-app-layout title="Nouvelle Intervention">

    <h1 class="text-2xl font-bold text-indigo-700 mb-6">Nouvelle Intervention</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('interventions.store') }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-md rounded-lg p-6">
        @csrf

        <div class="mb-4">
            <label for="nom" class="block font-medium text-gray-700">Nom</label>
            <input type="text" name="nom" id="nom" value="{{ old('nom') }}" class="w-full border rounded px-3 py-2">
        </div>

        <div class="mb-4">
            <label for="email" class="block font-medium text-gray-700">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" class="w-full border rounded px-3 py-2">
        </div>

        <div class="mb-4">
            <label for="telephone" class="block font-medium text-gray-700">Téléphone</label>
            <input type="text" name="telephone" id="telephone" value="{{ old('telephone') }}" class="w-full border rounded px-3 py-2">
        </div>

        <div class="mb-4">
            <label for="address" class="block font-medium text-gray-700">Adresse (optionnelle)</label>
            <input type="text" name="address" id="address" value="{{ old('address') }}" class="w-full border rounded px-3 py-2">
        </div>

        <div class="mb-4">
            <label for="appareil" class="block font-medium text-gray-700">Type d'appareil</label>
            <input type="text" name="appareil" id="appareil" value="{{ old('appareil') }}" class="w-full border rounded px-3 py-2">
        </div>

        <div class="mb-4">
            <label for="description_probleme" class="block font-medium text-gray-700">Description du problème</label>
            <textarea name="description_probleme" id="description_probleme" rows="4" class="w-full border rounded px-3 py-2">{{ old('description_probleme') }}</textarea>
        </div>

        <div class="mb-4">
            <label for="images" class="block font-medium text-gray-700">Images (maximum 3)</label>
            <input type="file" name="images[]" id="images" multiple accept="image/*" class="w-full">
            <p class="text-gray-500 text-sm mt-1">Vous pouvez sélectionner jusqu'à 3 images (jpeg, png, jpg, gif, svg)</p>
        </div>

        <div>
            <button type="submit" class="bg-indigo-600 text-white px-5 py-2 rounded hover:bg-indigo-700 transition">
                Soumettre la demande
            </button>
        </div>
    </form>

</x-app-layout>
