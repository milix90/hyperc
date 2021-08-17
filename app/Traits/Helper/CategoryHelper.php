<?php


namespace App\Traits\Helper;


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

    protected function uiBackgroundChecker($request, $category)
    {
        return $request->hasFile('file')
            ? $this->imageUpload($request)
            : $category['ui']['background'];
    }
}
