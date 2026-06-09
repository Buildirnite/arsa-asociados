<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone', 'area', 'message', 'scheduled_at', 'status'];

    protected $casts = [
        'scheduled_at' => 'datetime',
    ];

    /** Citas que ocupan un horario (todo lo que no esté cancelado). */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', '!=', 'cancelada');
    }

    public function isCancelled(): bool
    {
        return $this->status === 'cancelada';
    }

    public function isConfirmed(): bool
    {
        return $this->status === 'confirmada';
    }
}
