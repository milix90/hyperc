<?php


namespace App\Traits\File;


use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

trait ImageUpload
{
    public function imageUpload($request)
    {
        if ($request->hasFile('file')) {
            $name = '_' . Str::slug($request['name']) . '.' . $request->file->getClientOriginalExtension();
            $path = 'public/uploads/' . Carbon::now()->timestamp . '/';
            //$file = $request->file('file')->storeAs($path, $name, 'public');

            if (!Storage::exists($path))
                Storage::makeDirectory($path);
        }

        $imageUploadPath = [];

        try {
            $types = ['500' => 'web', '150' => 'app'];

            foreach ($types as $width => $type) {
                //resize image for web and app
                $image = Image::make($request->file('file'));
                $image->resize($width, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $image->save(storage_path('app/' . $path) . $type . $name);
                //convert image URI to access from public from storage shared link
                $imageUploadPath[$type] = str_replace('public', 'storage', $path) . $type . $name;
            }
        } catch (\Exception $e) {
            return $e;
        }

        return $imageUploadPath;
    }
}
