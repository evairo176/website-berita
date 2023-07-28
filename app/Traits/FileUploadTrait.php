<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

trait FileUploadTrait
{
    public function handleFileUpload(Request $request, string $fieldname, ?string $oldPath = null, string $dir = 'uploads'): ?String
    {

        // check if has file
        if (!$request->hasFile($fieldname)) {
            return null;
        }

        // delete existing image if have
        if ($oldPath && File::exists(public_path($oldPath))) {
            File::delete(public_path($oldPath));
        }



        $file = $request->file($fieldname);
        $extension = $file->getClientOriginalExtension();
        $updatedFileName = time() . "-" . Str::random(30) . "." . $extension;

        $file->move(public_path($dir), $updatedFileName);

        $filePath = $dir . '/' . $updatedFileName; // uploads/filename.jpg //

        return $filePath;
    }
}
