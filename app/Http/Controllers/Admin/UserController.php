<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class UserController extends Controller
{
    /**
     * Afficher tous les utilisateurs ou filtrer par rôle.
     */
    public function index(Request $request)
    {
        $selectedRole = $request->query('role'); // récupère le rôle choisi depuis le filtre

        if ($selectedRole) {
            // Filtrer par rôle si sélectionné
            $roleRecord = Role::where('name', $selectedRole)->first();

            if (!$roleRecord) {
                abort(404, "Rôle introuvable : $selectedRole");
            }

            $users = User::where('role_id', $roleRecord->id)->get();
        } else {
            // Sinon, tous les utilisateurs
            $users = User::with('role')->get();
        }

        return view('admin.users.index', compact('users', 'selectedRole'));
    }

    /**
     * Mettre à jour le rôle d’un utilisateur.
     */
    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:admin,technician,client',
        ]);

        $newRole = Role::where('name', $request->role)->first();

        if (!$newRole) {
            return redirect()->back()->with('error', 'Rôle invalide.');
        }

        $user->role_id = $newRole->id;
        $user->save();

        return redirect()->back()->with('success', 'Rôle mis à jour avec succès.');
    }
}
