<?php

namespace App\Models\Sales;

use App\Models\Classes\GroupClass;
use App\Models\Classes\PrivateClass;
use App\Models\Materials\Material;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SalesDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'sales_id',
        'user_id',
        'material_id',
        'private_classes_id',
        'group_classes_id',
        'sub_total',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'sub_total' => 'integer',
        'sales_id' => 'string',
        'user_id' => 'integer',
        'material_id' => 'integer',
        'private_classes_id' => 'integer',
        'group_classes_id' => 'integer',
    ];


    public function sales(): BelongsTo
    {
        return $this->belongsTo(Sales::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }

    public function privateClasses(): BelongsTo
    {
        return $this->belongsTo(PrivateClass::class, 'private_classes_id');
    }

    public function groupClasses(): BelongsTo
    {
        return $this->belongsTo(GroupClass::class);
    }
}