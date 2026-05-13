<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\category;
use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
class ProductController extends Controller
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
        $categor = category::select('id', 'name')->orderBy('name')->get();
        $brands = Brand::select('id', 'name')->orderBy('name')->get();
        return view('admin.product-add', compact('categor', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. التحقق من البيانات (تأكد أن الأسماء تطابق الـ HTML)
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:products,slug',
            'short_description' => 'required',
            'description' => 'required',
            'regular_price' => 'required|numeric',
            'sale_price' => 'required|numeric',
            'SKU' => 'required',
            'stock_status' => 'required',
            'featured' => 'required',
            'quantity' => 'required|integer',
            'image' => 'required|mimes:png,jpg,jpeg|max:2048', // الصورة الأساسية
            'images' => 'nullable', // صور المعرض
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',


        ]);

        // 2. إنشاء كائن المنتج
        $product = new Product();
        $product->name = $request->name;
        $product->slug = $request->slug; // أو Str::slug($request->name)
        $product->short_description = $request->short_description;
        $product->description = $request->description;
        $product->regular_price = $request->regular_price;
        $product->sale_price = $request->sale_price;
        $product->SKU = $request->SKU;
        $product->stock_status = $request->stock_status;
        $product->featured = $request->featured;
        $product->quantity = $request->quantity;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;

        // 3. رفع الصورة الأساسية (image)
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $fileName = time() . '.' . $extension;
            $file->move(public_path('uploads/products/thumbnails'), $fileName);
            $product->image = $fileName; // تأكد أن اسم العمود في الداتابيز 'image'
        }

        // 4. رفع صور المعرض (images) - إذا كان لديك حقل لها في الداتابيز
        if ($request->hasFile('images')) {
            $galleryArr = [];
            foreach ($request->file('images') as $key => $file) {
                $extension = $file->getClientOriginalExtension();
                $gFileName = time() . '-' . $key . '.' . $extension;
                $file->move(public_path('uploads/products/gallery'), $gFileName);
                $galleryArr[] = $gFileName;
            }
            $product->images = implode(',', $galleryArr); // تخزينها كنص مفصول بفاصلة
        }

        // 5. الحفظ النهائي
        $product->save();

        return redirect()->route('admin.product')->with('status', 'Product added successfully!');
    }


    /**
     * Display the specified resource.
     */
    public function show(product $product)
    {
        $products = product::orderBy('created_at', 'DESC')->paginate(10);
        return view('admin.products', compact('products'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product = product::findOrFail($id);
        $categories = category::select('id', 'name')->orderBy('name')->get();
        $brands = Brand::select('id', 'name')->orderBy('name')->get();
        return view('admin.product-edit', compact('product', 'categories', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     */
   
public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required',
        'slug' => 'required|unique:products,slug,' . $id,
        'short_description' => 'required',
        'description' => 'required',
        'regular_price' => 'required|numeric',
        'sale_price' => 'required|numeric',
        'SKU' => 'required',
        'stock_status' => 'required',
        'featured' => 'required',
        'quantity' => 'required|integer',
        'image' => 'nullable|mimes:png,jpg,jpeg|max:2048',
        'images' => 'nullable',
        'category_id' => 'required|exists:categories,id',
        'brand_id' => 'required|exists:brands,id',
    ]);

    $product = Product::findOrFail($id);

    $product->name = $request->name;
    $product->slug = $request->slug;
    $product->short_description = $request->short_description;
    $product->description = $request->description;
    $product->regular_price = $request->regular_price;
    $product->sale_price = $request->sale_price;
    $product->SKU = $request->SKU;
    $product->stock_status = $request->stock_status;
    $product->featured = $request->featured;
    $product->quantity = $request->quantity;
    $product->category_id = $request->category_id;
    $product->brand_id = $request->brand_id;

    // ================= MAIN IMAGE =================
    if ($request->hasFile('image')) {

        if ($product->image && File::exists(public_path('uploads/products/thumbnails/' . $product->image))) {
            File::delete(public_path('uploads/products/thumbnails/' . $product->image));
        }

        $file = $request->file('image');
        $fileName = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/products/thumbnails'), $fileName);

        $product->image = $fileName;
    }

    // ================= GALLERY IMAGES =================
    if ($request->hasFile('images')) {

        // حذف الصور القديمة بشكل صحيح
        if ($product->images) {
            foreach (explode(',', $product->images) as $oldImage) {
                $oldImage = trim($oldImage);

                if ($oldImage && File::exists(public_path('uploads/products/gallery/' . $oldImage))) {
                    File::delete(public_path('uploads/products/gallery/' . $oldImage));
                }
            }
        }

        $galleryArr = [];

        foreach ($request->file('images') as $key => $file) {
            $gFileName = time() . '-' . $key . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/products/gallery'), $gFileName);
            $galleryArr[] = $gFileName;
        }

        $product->images = implode(',', $galleryArr);
    }

    $product->save();

    return redirect()->route('admin.product')->with('status', 'Product updated successfully!');
}

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // حذف الصورة الرئيسية
        if (File::exists(public_path('uploads/products/' . $product->image))) {
            File::delete(public_path('uploads/products/' . $product->image));
        }

        // ⚠️ خطأ عندك هنا (مهم)
        // كنت تستخدم $product->images بدل image

        if (File::exists(public_path('uploads/products/thumbnails/' . $product->image))) {
            File::delete(public_path('uploads/products/thumbnails/' . $product->image));
        }

        // حذف الصور الإضافية
        if ($product->images) {
            foreach (explode(',', $product->images) as $galleryImage) {
                File::delete(public_path('uploads/products/' . $galleryImage));
                File::delete(public_path('uploads/products/thumbnails/' . $galleryImage));
            }
        }

        $product->delete();

        return redirect()->route('admin.product')
            ->with('status', 'Product deleted successfully!');
    }
}
