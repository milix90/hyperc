<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CreateRequest;
use App\Http\Requests\Category\UpdateRequest;
use App\Repositories\CategoryRepository;

class CategoryController extends Controller
{


    protected $category;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->category = $categoryRepository;
    }

    public function index()
    {
        $results = $this->category->all();

        return view('category.index', compact('results'));
    }

    public function create()
    {
        list($type, $title, $parents) = $this->category->createView();

        return view('category.action')->with([
            'type' => $type,
            'title' => $title,
            'parents' => $parents
        ]);
    }

    public function store(CreateRequest $request)
    {
        $this->category->create($request);

        return redirect(route('admin.category.index'));
    }

    public function edit($id)
    {
        list($type, $title, $category, $parents, $priorities) = $this->category->editView($id);

        return view('category.action')->with([
            'type' => $type,
            'title' => $title,
            'parents' => $parents,
            'category' => $category,
            'priorities' => $priorities
        ]);
    }

    public function update($id, UpdateRequest $request)
    {
        $this->category->update($id, $request);

        return redirect(route('admin.category.index'));
    }

    public function destroy($id)
    {
        $this->category->delete($id);

        return back();
    }
}
