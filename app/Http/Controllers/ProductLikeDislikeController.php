<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\UserPlanLike;
use Illuminate\Http\Request;

class ProductLikeDislikeController extends Controller
{

    public function product()
    {
        $data['products'] = Product::where('status', 1)->withCount('likes')->withCount('dislikes')->get();
      
        $data['plansLikes'] = UserPlanLike::where('user_id', auth()->id())->get();

        return inertia('Product/Index', ['data' => $data]);
    }

    public function planLikeUpdate(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'like_type' => 'required|in:0,1',
        ]);

        UserPlanLike::updateOrCreate(
            ['user_id' => auth()->id(), 'product_id' => $request->product_id],
            ['like' => $request->like_type == 1 ? 1 : 0],
        );

        return back()->with('success', 'Saved');
    }
   
}
