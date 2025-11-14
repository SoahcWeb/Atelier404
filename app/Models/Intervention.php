<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\PrioriteEnum;
use App\Enums\StatutEnum;

class Intervention extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'technician_id',
        'description',
        'device_type',
        'priority',
        'status',
        'scheduled_at',
        'notes',
    ];

    protected $casts = [
        'priority' => PrioriteEnum::class,
        'status' => StatutEnum::class,
    ];

    // Relations existantes
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function technician()
    {
        return $this->belongsTo(User::class, 'technician_id');
    }

    // Nouvelle relation : une intervention a plusieurs images
    public function images()
    {
        return $this->hasMany(Image::class);
    }
}
