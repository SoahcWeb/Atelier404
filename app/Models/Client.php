<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    // Champs pouvant être remplis en masse
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address'
    ];

    /**
     * Un client peut avoir plusieurs interventions
     */
    public function interventions()
    {
        return $this->hasMany(Intervention::class);
    }
    public function activeInterventions()
    {
        return $this->hasMany(Intervention::class)->where('status', '!=', 'completed');
    }

}
