<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StoreImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function saveImage(Request $request)
    {
        $imageData = $request->input('image');

        // Decode base64 image
        $imageParts = explode(";base64,", $imageData);
        $imageTypeAux = explode("image/", $imageParts[0]);
        $imageType = $imageTypeAux[1];
        $imageBase64 = base64_decode($imageParts[1]);

        // Define a unique file name
        $fileName = 'AMFiber-' . time() . '.' . $imageType;

        // Save the file in the public directory (adjust path if needed)
        $filePath = 'downloads/' . $fileName;
        Storage::disk('public')->put($filePath, $imageBase64);

        // Generate a public URL for the file
        $fileUrl = Storage::disk('public')->url($filePath);

        // Return the download link (you can also redirect or trigger download)
        return response()->json(['downloadUrl' => $fileUrl, 'fileName' => $fileName]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
