<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'appointment_code',
        'patient_id',
        'doctor_id',
        'appointment_date',
        'appointment_time',
        'booking_source',
        'status',
        'complaint',
    ];

    public function patient(): BelongsTo {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function doctor(): BelongsTo {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }
}
