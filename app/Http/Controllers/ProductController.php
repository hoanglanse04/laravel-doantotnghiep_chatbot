<?php

namespace App\Http\Controllers;

use App\Enums\Common;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{
    public function article(Request $request, $slug)
    {
        $article = Product::where("slug", $slug)->firstOrFail();

        $related = Product::where("status", Common::PUBLISHED->value)
            ->where("id", "!=", $article->id)
            ->when($article->category_id, function ($query) use ($article) {
                $query->where("category_id", $article->category_id);
            })
            ->latest()
            ->limit(6)
            ->get();

        return view("article.product", compact(
            "article",
            "related"
        ));
    }

    public function category(Request $request)
    {
        $categories = Category::where('status', Common::PUBLISHED->value)
            ->whereNull('parent_id')
            ->orderBy('id', 'DESC')
            ->get();

        $data = Product::where("status", Common::PUBLISHED->value)
            ->orderBy('id', 'DESC')
            ->paginate(12);

        return view("categories.product", compact(
            "categories",
            "data"
        ));
    }
}
