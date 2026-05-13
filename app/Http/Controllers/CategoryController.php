<?php

namespace App\Http\Controllers;

use App\Models\category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categorys-add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',

            'image' => 'mimes:png,jpg,jpeg,gif,svg|max:2048'
        ]);
        $category = new category();
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        if ($image = $request->file('image')) {

            $destinationPath = 'uploads/categorys/';
            $categoryImage = date('ymdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $categoryImage);
            $category->image = $categoryImage;
        }
        $category->save();

        return redirect()->route('admin.categorys')->with('status', 'category has been added succesfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(category $category)
    {
        $categorys = category::orderBy('id', 'DESC')->paginate(10);
        return view('admin.categorys', compact('categorys'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(category $category,$id)
    {
        $categorys = category::find($id);
        return view('admin.categorys-edit', compact('categorys'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, category $category)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'mimes:png,jpg,jpeg,gif,svg|max:2048'
        ]);

        $category = category::find($request->id);

        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        if ($request->hasFile('image')) {
            if (File::exists(public_path('uploade/categorys' . '/' . $category->image))) {
                File::delete(public_path('uploade/categorys' . '/' . $category->image));
            }

            if ($image = $request->file('image')) {
                $destinationPath = 'uploads/categorys/';
                $categoryImage = date('ymdHis') . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $categoryImage);
                $category->image = $categoryImage;
            }
        }

        $category->save();


        return redirect()->route('admin.categorys')->with('status', 'category has been added succesfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(category $category,Request $request)
    {

        $id = $request->categorys_id;
        $category = category::findOrFail($id);
        if (File::exists(public_path('uploade/categorys' . '/' . $category->image))) {
            File::delete(public_path('uploade/categorys' . '/' . $category->image));
        }

        $category->delete();
        return redirect()->route('admin.categorys')->with('status', 'category has been deleted succesfully!');
    }

}
