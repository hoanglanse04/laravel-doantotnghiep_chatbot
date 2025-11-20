<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Treconyl\ImagesUpload\ImageUpload;

use Modules\Admin\Models\Setting;
use Modules\Admin\Models\SettingField;

class SettingsController extends \App\Http\Controllers\Controller
{
    /**
     * Hiển thị danh sách cài đặt theo nhóm (tabs).
     */
    public function index()
    {
        $settings = Setting::with(['fields', 'children.fields'])->whereNull('parent_id')->orderBy('order')->get();
        return view('admin::setting.index', compact('settings'));
    }

    /**
     * Cập nhật cài đặt.
     */
    public function update(Request $request, $id)
    {
        $data = $request->except('_token', '_method');

        foreach ($data as $slug => $value) {
            $field = SettingField::where('slug', $slug)->first();
            if ($field) {
                // Nếu là checkbox, lưu dưới dạng JSON
                if ($field->type === 'checkbox') {
                    $value = is_array($value) ? json_encode($value) : json_encode([]);
                }

                // Nếu là file ảnh
                if ($field->type === 'image' && $request->hasFile($slug)) {
                    try {
                        $file = ImageUpload::file($request, $slug, 100, true, false)
                            ->folder('settings', true, 'public')
                            ->allowedMimetypes(['jpeg', 'jpg', 'png', 'gif', 'webp'])
                            ->convert('webp')
                            ->store();
                        if ($file) {
                            $value = $file;
                        }
                    } catch (\Exception $e) {
                        return redirect()->route('admin.setting.index')->with('error', 'Tải ảnh thất bại: ' . $e->getMessage());
                    }
                }

                $field->update(['value' => $value]);
            }
        }

        return redirect()->route('admin.setting.index')->with('success', 'Cập nhật cài đặt thành công.');
    }

    public function updateOrder(Request $request)
    {
        $groups = $request->input('groups', []);

        foreach ($groups as $group) {
            Setting::where('id', $group['id'])->update(['order' => $group['order']]);
        }

        return response()->json(['success' => true]);
    }

    public function updateFieldOrder(Request $request)
    {
        $fields = $request->input('fields', []);

        foreach ($fields as $field) {
            SettingField::where('id', $field['id'])->update([
                'order' => $field['order'],
                'group_id' => $field['group_id']
            ]);
        }

        return response()->json(['success' => true]);
    }
}
