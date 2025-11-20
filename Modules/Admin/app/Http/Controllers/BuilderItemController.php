<?php

namespace Modules\Admin\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Treconyl\ImagesUpload\ImageUpload;

use Modules\Admin\Models\Menu;
use Modules\Admin\Models\MenuItem;

use Modules\Admin\Http\Requests\BuilderItem\StoreBuilderItemRequest;
use Modules\Admin\Http\Requests\BuilderItem\BuilderItemCustomFieldRequest;

class BuilderItemController extends \App\Http\Controllers\Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $rows = Menu::with('items.children')->paginate(12);

        return view('admin::builder.index', compact(
            'rows'
        ));
    }

    public function show($id): View
    {
        $menu = Menu::findOrFail($id);
        $menuItems = MenuItem::where('parent_id', 0)->where('menu_id', $id)->orderBy('order')->get();

        return view('admin::builder.show', compact(
            'menu',
            'menuItems'
        ));
    }

    public function edit($id): View
    {
        $menu = MenuItem::findOrFail($id);

        $menuItems = $this->menuItems($menu->menu_id);

        return view('admin::builder-item.create-edit', compact(
            'menu',
            'menuItems'
        ));
    }

    public function create(Request $request): View
    {
        $menuItems = $this->menuItems($request->menu_id);

        return view('admin::builder-item.create-edit', compact(
            'menuItems'
        ));
    }

    public function store(StoreBuilderItemRequest $request): RedirectResponse
    {
        try {
            $image = null;
            if ($request->file('image')) {
                $image = ImageUpload::file($request, 'image', config('image-upload.resize.quantity', 100), true, false)
                    ->folder('builder', true, 'public')
                    ->allowedMimetypes(config('image-upload.allowed_mimetypes'))
                    ->convert('webp')
                    ->thumbnails([
                        'lg' => [
                            'resize' => [
                                'width' => 1000,
                                'height' => null,
                                'upsize' => true
                            ]
                        ],
                        'md' => [
                            'resize' => [
                                'width' => 450,
                                'height' => null
                            ]
                        ]
                    ])
                    ->store();
            }

            MenuItem::create([
                'menu_id' => $request->menu_id,
                'name' => $request->name,
                'url' => $request->url,
                'parent_id' => $request->parent_id ?? 0,
                'target' => $request->target ?? '_self',
                'status' => $request->status ?? 'published',
                'image' => $image,
                'icon' => $request->icon,
                'order' => MenuItem::where('menu_id', $request->menu_id)->max('order') + 1,
            ]);

            return redirect()->route('admin.builder.show', $request->menu_id)->with('success', 'Thêm mục menu thành công!');

        } catch (Exception $exception) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi thêm mục menu: ' . $exception->getMessage());
        }
    }

    public function update(Request $request, MenuItem $builder_item): RedirectResponse
    {
        try {
            $image = $builder_item->image;

            if ($request->file('image')) {
                $image = ImageUpload::file($request, 'image', config('image-upload.resize.quantity', 100), true, false)
                    ->folder('builder', true, 'public')
                    ->allowedMimetypes(config('image-upload.allowed_mimetypes'))
                    ->convert('webp')
                    ->thumbnails([
                        'lg' => [
                            'resize' => [
                                'width' => 1000,
                                'height' => null,
                                'upsize' => true
                            ]
                        ],
                        'md' => [
                            'resize' => [
                                'width' => 450,
                                'height' => null
                            ]
                        ]
                    ])
                    ->store();
            }

            $builder_item->update([
                'name' => $request->name,
                'url' => $request->url,
                'parent_id' => $request->parent_id ?? 0,
                'target' => $request->target ?? '_self',
                'status' => $request->status ?? 'published',
                'image' => $image,
                'icon' => $request->icon,
                // 'order' => MenuItem::where('menu_id', $request->menu_id)->max('order') + 1,
                'custom_fields' => $request->input('custom_fields', [])
            ]);

            return redirect()->route('admin.builder.show', ['builder' => $builder_item->menu_id])->with('success', 'Thêm mục menu thành công!');

        } catch (Exception $exception) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi thêm mục menu: ' . $exception->getMessage());
        }
    }

    public function destroy(MenuItem $builder_item): RedirectResponse
    {
        $builder_item->delete();

        return redirect()->back()->with('success', 'Xoá thành công');
    }

    private function menuItems($builder_id): array
    {
        $items = MenuItem::where('menu_id', $builder_id)
            ->orderBy('order')
            ->get();

        return $this->buildMenuOptions($items);
    }

    private function buildMenuOptions($items, $parentId = 0, $prefix = ''): array
    {
        $options = [];

        foreach ($items->where('parent_id', $parentId) as $item) {
            $options[$item->id] = $prefix . $item->name;
            $options += $this->buildMenuOptions($items, $item->id, $prefix . '-- ');
        }

        return $options;
    }

    public function createCustome(BuilderItemCustomFieldRequest $request): RedirectResponse
    {
        try {
            $item = MenuItem::findOrFail($request->menu_item_id);

            $fields = $item->custom_fields ?? [];

            $fields[] = [
                'label' => $request->name,
                'type' => $request->type,
                'value' => null
            ];

            $item->update([
                'custom_fields' => $fields
            ]);

            return redirect()->back()->with('success', 'Đã thêm trường tuỳ chỉnh mới!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Lỗi khi thêm trường: ' . $e->getMessage());
        }
    }

    public function destroyCustome(Request $request, MenuItem $menu_builder_item): RedirectResponse
    {
        $request->validate([
            'index' => 'required|integer|min:0',
        ]);

        try {
            $fields = $menu_builder_item->custom_fields ?? [];

            // Loại bỏ phần tử theo index
            unset($fields[$request->index]);

            // Re-index lại mảng (optional)
            $fields = array_values($fields);

            $menu_builder_item->update([
                'custom_fields' => $fields
            ]);

            return redirect()->back()->with('success', 'Đã xoá trường tuỳ chỉnh!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Lỗi khi xoá trường tuỳ chỉnh: ' . $e->getMessage());
        }
    }

}
