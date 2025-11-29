<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Page;

class PageController extends Controller
{
    public function article(Request $request, $slug)
    {
        $article = Page::where("slug", $slug)->firstOrFail();

        if ($article->template) {
            return view('article.templates.pages.' . $article->template, compact(
                'article'
            ));
        }

        return view("article.page", compact(
            "article"
        ));
    }
}
