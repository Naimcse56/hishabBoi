<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

trait FileUploadTrait
{
    /**
     * Store a file in the specified folder.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $folder
     * @return string
     */
    public function uploadFile(UploadedFile $file, string $folder)
    {
        // Generate a unique file name
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

        // Store the file and return the file path
        $path = $file->storeAs($folder, $filename, 'public');

        return $path;
    }

    /**
     * Delete a file from storage.
     *
     * @param string $path
     * @return bool
     */
    public function deleteFile(string $path)
    {
        // Check if the file exists in the storage before attempting to delete
        if (Storage::disk('public')->exists($path)) {
            // Delete the file and return the result (true or false)
            return Storage::disk('public')->delete($path);
        }

        // Return false if the file doesn't exist
        return false;
    }

    // $file = $request->file('file');

    // // Specify the folder where you want to store the file
    // $folder = 'uploads'; // You can customize this folder dynamically if needed

    // // Use the trait method to upload the file
    // $uploadedFilePath = $this->uploadFile($file, $folder);

    // // Get the file path from the request
    // $filePath = $request->input('file_path');

    // // Use the trait method to delete the file
    // $deleted = $this->deleteFile($filePath);
}
