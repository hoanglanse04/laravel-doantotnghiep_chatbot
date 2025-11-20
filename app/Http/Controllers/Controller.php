<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;

abstract class Controller
{
    //lấy danh sách file trong thư mục
    public function getFilesInFolder($folder)
    {
        $filenames = [];
        $path = base_path($folder);
        $files = File::allFiles($path);

        foreach ($files as $file) {
            $filename = explode('.', $file->getFilenameWithoutExtension());
            $filenames[] = $filename[0];
        }

        return $filenames;
    }
}
