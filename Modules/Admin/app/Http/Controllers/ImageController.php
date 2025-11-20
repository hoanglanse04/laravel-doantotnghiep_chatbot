<?php

namespace Modules\Admin\Http\Controllers;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Treconyl\ImagesUpload\ImageUpload;

class ImageController extends Controller
{
    public function process(Request $request)
    {
        $folder = $request->folder;
        $input = $request->input;

        try {
            // Lấy cấu hình thumbnails từ config
            $thumbnails = config("image-upload.thumbnails-{$folder}", []);

            // Xử lý tải lên ảnh
            $file = ImageUpload::file($request, $input, config('image-upload.resize.quantity', 100), true, false)
                ->folder($folder, true, 'public')
                ->allowedMimetypes(config('image-upload.allowed_mimetypes'))
                ->convert('webp')
                ->thumbnails($thumbnails)
                ->store();

            return $file;
        } catch (Throwable $exception) {
            return response()->json(['success' => false, 'message' => $exception->getMessage()], 500);
        }
    }

    public function load(Request $request)
    {
        $default = 'assets/admin/img/image_placeholder.jpg';
        $file = $request->file;

        if (is_null($file)) {
            return $default;
        }

        // Loại bỏ phần `/storage/` khỏi đường dẫn
        $storagePath = str_replace('/storage/', '', $file);

        if (Storage::disk('public')->exists($storagePath)) {
            return Storage::url($storagePath);
        }

        return $default;
    }
}
