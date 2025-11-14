<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    // Autoriser le mass assignment sur le champ 'name'
    protected $fillable = [
        'name',
    ];

    public const CLIENT = 'client';
    public const ADMIN = 'admin';
    public const TECHNICIAN = 'technician';

    public static function roles(): array
    {
        return [
            self::ADMIN,
            self::TECHNICIAN,
            self::CLIENT,
        ];
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
