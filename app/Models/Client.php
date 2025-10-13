<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    // Champs pouvant être remplis en masse
    protected $fillable = [
        'nom',
        'email',
        'telephone',
        'adresse'
    ];

    /**
     * Un client peut avoir plusieurs interventions
     */
    public function interventions()
    {
        return $this->hasMany(Intervention::class);
    }
}

