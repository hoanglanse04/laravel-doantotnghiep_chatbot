<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

use Modules\Admin\Models\Menu;
use Modules\Admin\Models\MenuItem;

use Modules\Admin\Http\Requests\Builder\StoreBuilderRequest;
use Modules\Admin\Http\Requests\Builder\UpdateBuilderRequest;

class BuilderController extends \App\Http\Controllers\Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rows = Menu::with('items.children')->orderBy('id', 'DESC')->paginate(12);

        return view('admin::builder.index', compact(
            'rows'
        ));
    }

    public function show($id): View
    {
        $menu = Menu::findOrFail($id);
        $menuItems = MenuItem::where('parent_id', 0)
            ->where('menu_id', $id)
            ->orderBy('order')
            ->get();

        return view('admin::builder.show', compact(
            'menu',
            'menuItems'
        ));
    }

    public function create(): View
    {
        return view('admin::builder.create-edit');
    }

    public function store(StoreBuilderRequest $request)
    {
        Menu::create([
            'name' => $request->name,
            'slug' => $request->slug ?? Str::random(12),
            'description' => $request->description,
        ]);

        return redirect()->route('admin.builder.index')->with('success', 'Thêm builder thành công!');
    }

    public function update(UpdateBuilderRequest $request, Menu $menu)
    {
        $menu->update([
            'name' => $request->name,
            'slug' => $request->slug ?? $menu->slug,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.builder.index')->with('success', 'Cập nhật builder thành công!');
    }

    public function updateOrder(Request $request): JsonResponse
    {
        $this->updateMenuOrder($request->input('order'));

        return response()->json(['success' => true]);
    }

    private function updateMenuOrder($items, $parentId = 0): void
    {
        foreach ($items as $index => $item) {
            $menuItem = MenuItem::find($item['id']);

            // Xóa cache sau khi cập nhật thứ tự menu
            Cache::forget("builder-items-{$menuItem->menu_id}");

            if ($menuItem) {
                $menuItem->update([
                    'order' => $index + 1,
                    'parent_id' => $parentId
                ]);

                if (isset($item['children']) && is_array($item['children'])) {
                    $this->updateMenuOrder($item['children'], $menuItem->id);
                }
            }
        }
    }
}
