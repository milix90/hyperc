<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Category\CategoriesResource;
use App\Http\Resources\Category\CategoryDetailsResource;
use App\Models\Category;

class CategoryController extends Controller
{
    const APP_PRIORITY = 'app_priority';
    protected $model;

    public function __construct(Category $category)
    {
        $this->model = $category;
    }

    public function getParents()
    {
        $categories = $this->model->query()->parents()
            ->orderBy(self::APP_PRIORITY)->get();

        return response(CategoriesResource::collection($categories), 200);
    }

    public function getParentDetails($slug)
    {
        $category = $this->model->query()->parents()
            ->where('slug', $slug)->children()->first();

        return response(new CategoryDetailsResource($category), 200);
    }
}
