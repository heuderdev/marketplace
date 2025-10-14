<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static find($productId)
 */
class Product extends Model
{
    use HasFactory;
    protected  $guarded = ['id'];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'product_user', 'product_id', 'user_id')
            ->withPivot('liberado_em');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'product_id', 'id');
    }

}
