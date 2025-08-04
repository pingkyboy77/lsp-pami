<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class UploadController extends Controller
{
    public function uploadImage(Request $request)
    {
        try {
            // Validasi file
            $request->validate([
                'file' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // Max 2MB
            ]);

            if ($request->hasFile('file')) {
                $file = $request->file('file');

                // Generate nama file yang unik
                $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();

                // Simpan file ke storage/app/public/uploads
                $path = $file->storeAs('uploads', $fileName, 'public');

                // Return URL lengkap untuk TinyMCE
                $url = asset('storage/' . $path);

                return response()->json([
                    'location' => $url,
                    'success' => true,
                ]);
            }

            return response()->json(
                [
                    'error' => 'No file uploaded.',
                    'success' => false,
                ],
                400,
            );
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(
                [
                    'error' => 'Invalid file: ' . implode(', ', $e->validator->errors()->all()),
                    'success' => false,
                ],
                422,
            );
        } catch (\Exception $e) {
            // Log error untuk debugging
            \Log::error('Image upload error: ' . $e->getMessage());

            return response()->json(
                [
                    'error' => 'Upload failed: ' . $e->getMessage(),
                    'success' => false,
                ],
                500,
            );
        }
    }
}
