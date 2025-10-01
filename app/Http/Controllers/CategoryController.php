<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Services\CategoryService;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $categories = Category::paginate(10);
        return view('admin.categoryList', compact('categories'));
    }

    public function create()
    {
        return view('admin.addCategory');
    }

    public function store(StoreCategoryRequest $request)
    {
        $this->categoryService->createCategory($request->validated());

        return redirect()->route('admin.categories.index')
                         ->with('success', 'Category added successfully!');
    }

    public function edit(Category $category)
    {
        return view('admin.editCategory', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $this->categoryService->updateCategory($category, $request->validated());

        return redirect()->route('admin.categories.index')
                         ->with('success', 'Category updated successfully!');
    }

    public function destroy(Category $category)
    {
        $this->categoryService->deleteCategory($category);

        return redirect()->route('admin.categories.index')
                         ->with('success', 'Category and its products deleted successfully!');
    }
}
