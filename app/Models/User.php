<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model
{
    public static function booted()
    {
        static::creating(function (User $user) {
            if ($user->isClean('created_at')) {
                $user->created_at = Carbon::now()->addDay(1);
            }
        });
    }

    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
    ];

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}
