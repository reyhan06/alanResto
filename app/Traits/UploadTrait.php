<?php

namespace App\Traits;

use Str;
use Storage;
use Illuminate\Http\UploadedFile;

trait UploadTrait
{
    public function upload(UploadedFile $uploaded_file, $dir, $current_file = null)
    {
        if ($current_file) Storage::disk('public')->delete($current_file);

        $name = Str::random(16);
        $file_name = $name.'.'.$uploaded_file->getClientOriginalExtension();
        $file = Storage::disk('public')->putFileAs($dir, $uploaded_file, $file_name);

        return $file;
    }
}
