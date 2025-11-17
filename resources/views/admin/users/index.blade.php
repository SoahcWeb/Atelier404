<x-app-layout title="Gestion des utilisateurs">

    {{-- Applique le background sur tout le body --}}
    <div class="min-h-screen" style="background-color: #f9eddd; color: #442b1f;">

        <div class="max-w-7xl mx-auto px-6 py-10">

            {{-- Titre --}}
            <h1 class="text-3xl font-bold mb-8" style="color: #442b1f;">
                Gestion des utilisateurs
            </h1>

            {{-- FILTRE DES ROLES --}}
            <form method="GET" action="{{ route('admin.users.index') }}" class="mb-6">
                <div class="flex items-center gap-4">

                    <label class="font-semibold">Filtrer par rôle :</label>

                    <select name="role" class="border rounded px-3 py-2">
                        <option value="">Tous</option>
                        <option value="admin" {{ $selectedRole === 'admin' ? 'selected' : '' }}>Admins</option>
                        <option value="technician" {{ $selectedRole === 'technician' ? 'selected' : '' }}>Techniciens</option>
                        <option value="client" {{ $selectedRole === 'client' ? 'selected' : '' }}>Clients</option>
                    </select>

                    <button type="submit" class="px-4 py-2 rounded hover:opacity-90"
                            style="background-color: #442b1f; color: #d0ba9b;">
                        Appliquer
                    </button>
                </div>
            </form>

            {{-- CARTE + TABLEAU --}}
            <div class="bg-white shadow-xl rounded-xl border border-gray-200 overflow-hidden">

                {{-- Ligne "Liste de tous les utilisateurs" --}}
                <div class="px-6 py-4 border-b bg-white flex justify-between items-center">
                    <div class="text-lg font-semibold" style="color: #442b1f;">
                        @if($selectedRole)
                            Liste des {{ ucfirst($selectedRole) }}s
                        @else
                            Liste de tous les utilisateurs
                        @endif
                    </div>

                    <a href="{{ route('admin.dashboard') }}"
                       class="px-4 py-2 rounded hover:opacity-90"
                       style="background-color: #442b1f; color: #d0ba9b;">
                        Retour Dashboard
                    </a>
                </div>

                {{-- Tableau --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-300 text-sm">

                        {{-- Header du tableau --}}
                        <thead class="bg-[#d0ba9b] text-[#442b1f] font-bold">
                            <tr>
                                <th class="px-6 py-3 text-left">ID</th>
                                <th class="px-6 py-3 text-left">Nom</th>
                                <th class="px-6 py-3 text-left">Email</th>
                                <th class="px-6 py-3 text-left">Rôle</th>
                                <th class="px-6 py-3 text-left">Créé le</th>
                                <th class="px-6 py-3 text-left">Actions</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200">
                            @forelse($users as $user)
                                @php
                                    $roleName = $user->role->name ?? 'inconnu';
                                    $roleColor = [
                                        'admin' => 'bg-red-600',
                                        'technician' => 'bg-green-700',
                                        'client' => 'bg-blue-700',
                                    ][$roleName] ?? 'bg-gray-500';
                                @endphp

                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-3">{{ $user->id }}</td>
                                    <td class="px-6 py-3 font-medium">{{ $user->name }}</td>
                                    <td class="px-6 py-3">{{ $user->email }}</td>

                                    <td class="px-6 py-3">
                                        <span class="px-3 py-1 rounded-full text-white text-xs {{ $roleColor }}">
                                            {{ ucfirst($roleName) }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-3">{{ $user->created_at->format('d/m/Y') }}</td>

                                    <td class="px-6 py-3">
                                        {{-- MODIFIER ROLE --}}
                                        <form action="{{ route('admin.users.updateRole', $user) }}" method="POST" class="flex items-center gap-2">
                                            @csrf
                                            @method('PUT')

                                            <select name="role" class="border px-2 py-1 rounded text-sm">
                                                <option value="client" {{ $roleName === 'client' ? 'selected' : '' }}>Client</option>
                                                <option value="technician" {{ $roleName === 'technician' ? 'selected' : '' }}>Technicien</option>
                                                <option value="admin" {{ $roleName === 'admin' ? 'selected' : '' }}>Admin</option>
                                            </select>

                                            <button type="submit" class="px-3 py-1 rounded text-sm hover:opacity-90"
                                                    style="background-color: #442b1f; color: #d0ba9b;">
                                                OK
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                        Aucun utilisateur trouvé.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

</x-app-layout>
