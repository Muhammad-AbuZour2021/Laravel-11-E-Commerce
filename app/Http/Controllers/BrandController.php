<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {


        return view('admin.brands-add');
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

        $brand = new Brand();
        $brand->name = $request->name;
        $brand->slug = Str::slug($request->name);

        if ($image = $request->file('image')) {

            $destinationPath = 'uploads/brands/';
            $brandImage = date('ymdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $brandImage);
            $brand->image = $brandImage;
        }
        $brand->save();

        return redirect()->route('admin.brands')->with('status', 'brand has been added succesfully!');
    }

    // public function GenerateBrandThumbailsImage($image, $imageName)
    // {
    //     $destinationPath = public_path('uploads/brands');
    //     $img = Image::read($image->path());
    //     $img->cover(124, 124, "top");
    //     $img->resize(124, 124,function ($constraint) {
    //         $constraint->aspectRatio();
    //     })->save($destinationPath .'/'. $imageName);
    // }
    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        $brands = Brand::orderBy('id', 'DESC')->paginate(10);
        return view('admin.brands', compact('brands'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $brand = Brand::find($id);
        return view('admin.brands-edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'mimes:png,jpg,jpeg,gif,svg|max:2048'
        ]);

        $brand = Brand::find($request->id);

        $brand->name = $request->name;
        $brand->slug = Str::slug($request->name);
        if ($request->hasFile('image')) {
            if (File::exists(public_path('uploade/brands' . '/' . $brand->image))) {
                File::delete(public_path('uploade/brands' . '/' . $brand->image));
            }

            if ($image = $request->file('image')) {
                $destinationPath = 'uploads/brands/';
                $brandImage = date('ymdHis') . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $brandImage);
                $brand->image = $brandImage;
            }
        }

        $brand->save();


        return redirect()->route('admin.brands')->with('status', 'brand has been added succesfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {


        $id = $request->brands_id;
        $brand = Brand::findOrFail($id);
        if (File::exists(public_path('uploade/brands' . '/' . $brand->image))) {
            File::delete(public_path('uploade/brands' . '/' . $brand->image));
        }

        $brand->delete();
        return redirect()->route('admin.brands')->with('status', 'brand has been deleted succesfully!');
    }
}
