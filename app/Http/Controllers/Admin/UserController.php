<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Afficher la liste des utilisateurs.
     * Si un rôle est fourni, filtrer par rôle (client ou technician).
     */
    public function indexByRole($role = null)
    {
        if ($role) {
            $users = User::where('role', $role)->get();
        } else {
            $users = User::all();
        }

        return view('admin.users.index', compact('users', 'role'));
    }

    /**
     * Mettre à jour le rôle d’un utilisateur.
     */
    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:client,technician',
        ]);

        $user->role = $request->role;
        $user->save();

        return redirect()->back()->with('success', 'Rôle mis à jour avec succès.');
    }
}
