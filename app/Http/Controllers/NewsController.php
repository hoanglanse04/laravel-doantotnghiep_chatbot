<?php

namespace App\Http\Controllers;

use App\Enums\Common;
use Illuminate\Http\Request;

use App\Models\Post;

class NewsController extends Controller
{
    public function article(Request $request, $slug)
    {
        $article = Post::where("slug", $slug)->firstOrFail();
        return view("article.post", compact(
            "article"
        ));
    }

    public function category(Request $request)
    {
        $data = Post::where("status", Common::PUBLISHED->value)
                    ->orderBy('id', 'DESC')
                    ->paginate(9);

        return view("categories.post", compact(
            "data"
        ));
    }
}
