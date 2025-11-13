<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    // Champs pouvant être remplis en masse
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'adresse'
    ];

    /**
     * Un client peut avoir plusieurs interventions
     */
    public function interventions()
    {
        return $this->hasMany(Intervention::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

