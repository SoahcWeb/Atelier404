<x-app-layout title="Gestion des utilisateurs">

    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">
            Liste des {{ $role ? ucfirst($role) : 'utilisateurs' }}
        </h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-2 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif

        <table class="table-auto w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border px-4 py-2">ID</th>
                    <th class="border px-4 py-2">Nom</th>
                    <th class="border px-4 py-2">Email</th>
                    <th class="border px-4 py-2">Rôle</th>
                    <th class="border px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td class="border px-4 py-2">{{ $user->id }}</td>
                        <td class="border px-4 py-2">{{ $user->name }}</td>
                        <td class="border px-4 py-2">{{ $user->email }}</td>
                        <td class="border px-4 py-2 capitalize">{{ $user->role }}</td>
                        <td class="border px-4 py-2 flex gap-2">

                            <!-- Bouton Client -->
                            <form action="{{ route('admin.users.updateRole', $user) }}" method="POST">
                                @csrf
                                <input type="hidden" name="role" value="client">
                                <button type="submit" class="px-3 py-1 rounded {{ $user->role === 'client' ? 'bg-blue-500 text-white' : 'bg-gray-200' }}">
                                    Client
                                </button>
                            </form>

                            <!-- Bouton Technicien -->
                            <form action="{{ route('admin.users.updateRole', $user) }}" method="POST">
                                @csrf
                                <input type="hidden" name="role" value="technician">
                                <button type="submit" class="px-3 py-1 rounded {{ $user->role === 'technician' ? 'bg-green-500 text-white' : 'bg-gray-200' }}">
                                    Technicien
                                </button>
                            </form>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</x-app-layout>
