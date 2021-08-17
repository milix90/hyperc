<?php


namespace App\Repositories;


use App\Models\Category;
use App\Repositories\Interfaces\CrudInterface;
use App\Traits\File\ImageUpload;
use App\Traits\Helper\CategoryHelper;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryRepository implements CrudInterface
{
    use ImageUpload, CategoryHelper;

    protected $model;

    const SORT = 'asc';
    const WEB_PRIORITY = 'web_priority';
    const APP_PRIORITY = 'app_priority';

    public function __construct(Category $category)
    {
        $this->model = $category;
    }

    public function all()
    {
        /*get all categories containing sub categories(children)
          and sort them by priority
          admin panel sort is according to web priority*/
        $categories = $this->model->query()
            ->where('parent', 0)
            ->with(['children' => function ($q) {
                return $q->orderBy(self::WEB_PRIORITY, self::SORT)->get();
            }])
            ->orderBy(self::WEB_PRIORITY, self::SORT)->get();

        $results = [
            'links' => [
                //array key is equal route name
                'admin.category.create' => 'Create new',
            ],
            'categories' => $categories,
        ];

        return $results;
    }

    public function create($request)
    {
        try {
            //upload background image for UI
            $background = $this->imageUpload($request);
            //get max value of priorities(here is the latest one) to create new unique priority
            $wp = $this->model->query()->max(self::WEB_PRIORITY);
            $ap = $this->model->query()->max(self::APP_PRIORITY);
            //convert alphabets
            $name = strtolower($request['name']);
            //create new category
            $this->model->query()->create([
                'latitude' => $request['location'],
                'name' => $name,
                'slug' => Str::slug($name),
                'product' => $request['product'],
                'web_priority' => $wp + 1,
                'app_priority' => $ap + 1,
                'parent' => $request['parent'],
                'ui' => [
                    'icon' => $request['icon'],
                    'color' => $request['color'],
                    'background' => $background
                ],
            ]);
        } catch (\Exception $e) {
            return $e;
        }

        return true;
    }

    public function find($id, array $columns = ['*'], array $relations = [])
    {
        return $this->model->query()->where('id', $id)->select($columns)->with($relations)->get();
    }

    public function update($id, $request)
    {
        try {
            //convert alphabets
            $name = strtolower($request['name']);
            //find category
            $category = $this->model->query()->find($id);
            //check for UI background
            $background = $this->uiBackgroundChecker($request, $category);
            //switch priorities to update
            $this->priorityChecker($request, $category);
            //update category
            $category->update([
                'name' => $name,
                'slug' => Str::slug($name),
                'product' => $request['product'],
                'web_priority' => $request['web_priority'],
                'app_priority' => $request['app_priority'],
                'parent' => $request['parent'],
                'ui' => [
                    'icon' => $request['icon'],
                    'color' => $request['color'],
                    'background' => $background
                ],
            ]);
        } catch (\Exception $e) {
            return $e;
        }

        return true;
    }

    public function delete($id)
    {
        $category = $this->model->query()->find($id);
        $file = preg_replace('/\D/', '', $category['ui']['background']);
        $dir = 'public/uploads/' . $file;

        Storage::deleteDirectory($dir);
        $category->delete();
    }

    public function createView()
    {
        $type = 'create';
        $title = 'Create new Category';
        $parents = $this->model->query()->parents()->get(['id', 'name']);

        return [$type, $title, $parents];
    }

    public function editView($id)
    {
        $type = 'update';
        $title = 'Update Category';

        $category = $this->model->query()->find($id);

        $parents = $this->model->query()->parents()
            ->where('id', '<>', $category['parent'])
            ->get(['id', 'name']);

        $priorities = $this->model->query()
            ->where('parent', $category['parent'])
            ->where('id', '<>', $category['id'])->get();

        return [$type, $title, $category, $parents, $priorities];
    }
}
