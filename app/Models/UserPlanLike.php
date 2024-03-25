<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPlanLike extends Model
{
    protected $table= 'user_plans_likes';

    const PLAN_LIKE = 1;
    const PLAN_DISLIKE = 0;

    protected $guarded = '';

    public function plan()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
