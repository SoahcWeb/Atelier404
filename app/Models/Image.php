<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    // Champs assignables
    protected $fillable = [
        'intervention_id',
        'path',
        'thumbnail_path',
    ];

    /**
     * Relation : une image appartient à une intervention
     */
    public function intervention()
    {
        return $this->belongsTo(Intervention::class);
    }
}
