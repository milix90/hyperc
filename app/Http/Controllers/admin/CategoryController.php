<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\File\ImageUpload;
use App\Http\Requests\Category\CreateRequest;
use App\Http\Requests\Category\UpdateRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    use ImageUpload;

    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {
        $categories = Category::query()
            ->where('parent', 0)
            ->with(['children' => function ($q) {
                return $q->orderBy('web_priority', 'asc')->get();
            }])
            ->orderBy('web_priority', 'asc')->get();

        $results = [
            'links' => [
                //array key is equal route name
                'admin.category.create' => 'Create new',
            ],
            'categories' => $categories,
        ];

        return view('category.index', compact('results'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Category $cat
     * @return void
     */
    public function create(Category $cat)
    {
        $type = 'create';
        $title = 'Create new Category';
        $parents = $cat->query()->parents()->get(['id', 'name']);

        return view('category.action')->with([
            'type' => $type,
            'title' => $title,
            'parents' => $parents
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateRequest $request
     * @return void
     */
    public function store(CreateRequest $request)
    {
        $background = $this->imageUpload($request);
        $wp = Category::query()->max('web_priority');
        $ap = Category::query()->max('app_priority');

        $name = strtolower($request['name']);

        Category::query()->create([
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

        return redirect(route('admin.category.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @param Category $cat
     * @return void
     */
    public function edit($id, Category $cat)
    {
        $type = 'update';
        $title = 'Update Category';
        $category = $cat->query()->find($id);
        $parents = $cat->query()->parents()
            ->where('id', '<>', $category['parent'])
            ->get(['id', 'name']);
        $priorities = $cat->query()
            ->where('parent', $category['parent'])
            ->where('id', '<>', $category['id'])->get();

        return view('category.action')->with([
            'type' => $type,
            'title' => $title,
            'parents' => $parents,
            'category' => $category,
            'priorities' => $priorities
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @param UpdateRequest $request
     * @param Category $cat
     * @return void
     */
    public function update($id, UpdateRequest $request, Category $cat)
    {
        $name = strtolower($request['name']);
        $category = $cat->query()->find($id);
        $background = $request->hasFile('file')
            ? $this->imageUpload($request)
            : $category['ui']['background'];
        //switch priorities to update
        if ($request['web_priority'] !== $category['web_priority']) {
            $cat->query()->where('web_priority', $request['web_priority'])
                ->update(['web_priority' => $category['web_priority']]);
        }

        if ($request['app_priority'] !== $category['app_priority']) {
            $cat->query()->where('app_priority', $request['app_priority'])
                ->update(['app_priority' => $category['app_priority']]);
        }
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

        return redirect(route('admin.category.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return void
     */
    public function destroy($id)
    {
        $category = Category::query()->find($id);
        $file = preg_replace('/\D/', '', $category['ui']['background']);
        $dir = 'public/uploads/' . $file;

        Storage::deleteDirectory($dir);
        $category->delete();

        return back();
    }
}
