<x-app-layout title="Modifier Intervention">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <h1 class="text-2xl font-bold text-indigo-700 mb-6">Modifier l'Intervention</h1>

        <form action="{{ route('interventions.update', $intervention) }}" method="POST" class="space-y-4">
            @csrf
            @method('PATCH')

            <div>
                <label for="description" class="block font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" class="border p-2 w-full rounded" rows="4">{{ old('description', $intervention->description) }}</textarea>
            </div>

            <div>
                <label for="device_type" class="block font-medium text-gray-700">Type d'appareil</label>
                <input type="text" name="device_type" id="device_type" class="border p-2 w-full rounded" value="{{ old('device_type', $intervention->device_type) }}">
            </div>

            <div>
                <label for="status" class="block font-medium text-gray-700">Statut</label>
                <select name="status" id="status" class="border p-2 w-full rounded">
                    @foreach(\App\Enums\StatutEnum::cases() as $status)
                        <option value="{{ $status->value }}" {{ $intervention->status === $status->value ? 'selected' : '' }}>
                            {{ $status->value }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="priority" class="block font-medium text-gray-700">Priorité</label>
                <select name="priority" id="priority" class="border p-2 w-full rounded">
                    @foreach(\App\Enums\PrioriteEnum::cases() as $priority)
                        <option value="{{ $priority->value }}" {{ $intervention->priority === $priority->value ? 'selected' : '' }}>
                            {{ $priority->value }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mt-4">
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
