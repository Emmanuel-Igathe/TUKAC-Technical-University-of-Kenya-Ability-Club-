<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';

    protected $fillable = [
        'title',
        'description',
        'date',
        'time',
        'location',
        'capacity',
        'created_by',
    ];

    protected $casts = [
        'date' => 'date',
        'time' => 'datetime',
        'capacity' => 'integer',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function registrations()
    {
        return $this->hasMany(EventRegistration::class);
    }

    public function attendees()
    {
        return $this->belongsToMany(User::class, 'event_registrations', 'event_id', 'user_id');
    }

    public function isAttendee($userId)
    {
        return $this->attendees()->where('user_id', $userId)->exists();
    }

    public function registrationCount()
    {
        return $this->registrations()->count();
    }

    public function scopeUpcoming($query)
    {
        return $query->where('date', '>=', now()->toDateString())->orderBy('date', 'asc');
    }

    public function scopePast($query)
    {
        return $query->where('date', '<', now()->toDateString())->orderBy('date', 'desc');
    }
}
