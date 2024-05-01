<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPoint extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $fillable = [
        'points',
        'user_id',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($user) {
            UserPoint::created([
                'user_id' => $user->id,
                "points" => 100
            ]);
        });
    }
}
