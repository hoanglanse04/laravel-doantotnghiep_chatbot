<?php

namespace App\Http\Controllers;

use App\Enums\Common;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
    public function article(Request $request, string $slug)
    {
        $category = Category::with('parentRecursive')
            ->where('slug', $slug)
            ->where('status', Common::PUBLISHED->value)
            ->firstOrFail();

        $categories = Category::where('status', Common::PUBLISHED->value)
            ->whereNull('parent_id')
            ->orderBy('id', 'DESC')
            ->get();

        $categoryIds = $this->getAllChildCategoryIds($category);
        $data = Product::whereIn('category_id', $categoryIds)
            ->where('status', Common::PUBLISHED->value)
            ->latest()
            ->paginate(12);

        return view("categories.product", compact(
            "data",
            "category",
            "categories"
        ));
    }

    private function getAllChildCategoryIds(Category $category): array
    {
        $allIds = [$category->id];

        $childIds = Category::where('parent_id', $category->id)
            ->where('status', Common::PUBLISHED->value)
            ->pluck('id');

        foreach ($childIds as $childId) {
            $child = Category::find($childId);
            $allIds = array_merge($allIds, $this->getAllChildCategoryIds($child));
        }

        return $allIds;
    }
}
