<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use App\Models\User;

class ExportController extends Controller
{
    public function exportCsv()
    {
        $filename = "users_export_" . date('Y-m-d_H-i-s') . ".csv";
        $users = User::all();

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $columns = ['ID', 'Nom', 'Email', 'Rôle'];

        $callback = function() use ($users, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($users as $user) {
                fputcsv($file, [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->role
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
