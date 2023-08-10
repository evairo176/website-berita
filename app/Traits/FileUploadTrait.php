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

    public function deleteFile(string $path): void
    {
        // delete existing image if have
        if ($path && File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }

    public function duplicateAndRenameImage($sourceFilePath, $newFileName)
    {
        // Get the directory path from the source file path
        $directoryPath = pathinfo($sourceFilePath, PATHINFO_DIRNAME);

        // Create the destination path for the duplicated and renamed image
        $destinationFilePath = $directoryPath . '/' . $newFileName;

        // Check if the source image file exists
        if (File::exists($sourceFilePath)) {
            // Copy the image to the destination path with the new file name
            File::copy($sourceFilePath, $destinationFilePath);

            return $destinationFilePath; // Return the path to the duplicated and renamed image
        } else {
            return false; // Source image doesn't exist
        }
    }
}
