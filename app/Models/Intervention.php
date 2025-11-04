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
        'user_id',
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

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function technicien()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}


