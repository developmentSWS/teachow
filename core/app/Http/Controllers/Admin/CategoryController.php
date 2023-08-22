<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $pageTitle = "Manage Category";
        $emptyMessage = 'No category created yet';
        $categories = Category::latest()->paginate(getPaginate());
        return view('admin.category.index', compact('pageTitle', 'emptyMessage', 'categories'));
    }

    protected function validation($request, $id = 0)
    {
        $request->validate(
            [
                'name' => 'required|string|max:40|unique:categories,name,' . $id,
                'icon' => 'required',
            ]
        );
    }

    public function store(Request $request)
    {
        $this->validation($request);
        $category = new Category();
        $category->name = $request->name;
        $category->icon = $request->icon;
        $category->save();
        $notify[] = ['success', 'Category added successfully'];
        return back()->withNotify($notify);
    }
    public function update(Request $request, $id)
    {
        $this->validation($request, $id);
        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->icon = $request->icon;
        $category->status = $request->status ? 1 : 0;
        $category->save();
        $notify[] = ['success', 'Category updated successfully '];
        return redirect()->back()->withNotify($notify);
    }
}
