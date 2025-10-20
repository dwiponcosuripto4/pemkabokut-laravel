<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::created(function ($business) {
            \App\Models\LogAktivitas::create([
                'model' => 'Business',
                'title' => $business->nama,
                'user_id' => auth()->id(),
                'type' => 'Create',
                'datetime' => now(),
            ]);
        });
        static::updated(function ($business) {
            \App\Models\LogAktivitas::create([
                'model' => 'Business',
                'title' => $business->nama,
                'user_id' => auth()->id(),
                'type' => 'Update',
                'datetime' => now(),
            ]);
        });
        static::deleted(function ($business) {
            \App\Models\LogAktivitas::create([
                'model' => 'Business',
                'title' => $business->nama,
                'user_id' => auth()->id(),
                'type' => 'Delete',
                'datetime' => now(),
            ]);
        });
    }

    protected $fillable = [
        'nama',
        'jenis',
        'owner',
        'input_url',
        'alamat',
        'latitude',
        'longitude',
        'nomor_telepon',
        'email',
        'nib',
        'deskripsi',
        'foto',
        'status',
        'user_id'
    ];

    protected $casts = [
        'status' => 'integer',
        'latitude' => 'float',
        'longitude' => 'float'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
