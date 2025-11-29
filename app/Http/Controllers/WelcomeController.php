<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use App\Enums\Common;

use App\Models\Post;
use App\Models\Product;

class WelcomeController extends Controller
{
    public function index(Request $request)
    {
        $products = Cache::remember('welcome_1', Carbon::now()->addDays(10), function () {
            return Product::where('status', Common::PUBLISHED->value)
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();
        });

        $posts = Cache::remember('welcome_2', Carbon::now()->addDays(10), function () {
            return Post::where('status', Common::PUBLISHED->value)
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();
        });

        return view("welcome", compact(
            'products',
            'posts',
        ));
    }
}
