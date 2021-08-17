<?php


namespace App\Traits\File;


use Carbon\Carbon;
use Illuminate\Support\Str;

trait ImageUpload
{
    public function imageUpload($request)
    {
        if ($request->hasFile('file')) {
            $name = Str::slug($request['name']) . '.' . $request->file->getClientOriginalExtension();
            $path = "uploads/" . Carbon::now()->timestamp . "/";

            $request->file('file')->storeAs($path, $name, 'public');
        }

        $imageUploadPath = 'storage/' . $path . $name;

        return $imageUploadPath;
    }
}
