<?php

namespace App\Models\Users;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Entities\UserEntities;
use App\enums\RoleEnum;
use App\enums\StatusEnum;
use App\Models\Materials\Material;
use App\Models\Notifications\Notification;
use App\Models\Schedules\Schedule;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'email',
        'password',
        'status',
        'role',
    ];

    protected $casts = [
        'role' => RoleEnum::class,
        'status' => StatusEnum::class,
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', UserEntities::USER_ACTIVE);
    }

    public function detail(): HasOne
    {
        return $this->hasOne(UserDetail::class);
    }

    public function notification(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    public function materials(): BelongsToMany
    {
        return $this->belongsToMany(Material::class, 'user_material', 'user_id', 'material_id');
    }

    public function schedules(): BelongsToMany
    {
        return $this->belongsToMany(Schedule::class, 'user_schedule', 'user_id', 'schedule_id');
    }
}
