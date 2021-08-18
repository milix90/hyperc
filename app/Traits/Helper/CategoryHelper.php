<?php


namespace App\Traits\Helper;


use Illuminate\Support\Facades\Storage;

trait CategoryHelper
{
    protected function priorityChecker($request, $category)
    {
        if ($request['web_priority'] !== $category['web_priority']) {
            $this->model->query()->where(self::WEB_PRIORITY, $request['web_priority'])
                ->update(['web_priority' => $category['web_priority']]);
        }

        if ($request['app_priority'] !== $category['app_priority']) {
            $this->model->query()->where(self::APP_PRIORITY, $request['app_priority'])
                ->update(['app_priority' => $category['app_priority']]);
        }
    }

    protected function deleteCategoryBackgrounds($category)
    {
        //$category is searched Model object
        $file = preg_replace('/\D/', '', $category['ui']['background']['web']);
        $dir = 'public/uploads/' . $file;
        Storage::deleteDirectory($dir);
    }

    protected function uiBackgroundChecker($request, $category)
    {
        if ($request->hasFile('file')) {
            $this->deleteCategoryBackgrounds($category);
            $backgrounds = $this->imageUpload($request);
        } else {
            $backgrounds = $category['ui']['background'];
        }

        return $backgrounds;
    }

    protected function deleteSubCategories($category)
    {
        if ($category['parent'] === 0) {
            $subCategories = $this->model->query()->whereParent($category['id'])->get();

            foreach ($subCategories as $subCategory) {
                $this->deleteCategoryBackgrounds($subCategory);
                $subCategory->delete();
            }
        }
    }
}
