<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function likes()
    {
        return $this->hasMany(UserPlanLike::class, 'product_id')->where('like', 1);
    }

    public function dislikes()
    {
        return $this->hasMany(UserPlanLike::class, 'product_id')->where('like', 0);
    }

}
