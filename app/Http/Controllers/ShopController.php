<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Brand;
use Ramsey\Uuid\Codec\OrderedTimeCodec;
use App\Models\Category;
use App\Models\Slide;

class ShopController extends Controller
{
public function index(Request $request)
{
    $size = $request->query('size', 12);
    $order = $request->query('order', -1);
    $f_brands = $request->query('brands');
    $f_categories = $request->query('categories');

    // ✅ فلتر السعر
    $minPrice = $request->query('min_price') ? $request->query('min_price') : 1;
    $maxPrice = $request->query('max_price') ? $request->query('max_price') : 5000;

    // الترتيب
    switch ($order) {
        case 1:
            $oOcolumn = 'created_at';
            $oOdirection = 'desc';
            break;
        case 2:
            $oOcolumn = 'created_at';
            $oOdirection = 'asc';
            break;
        case 3:
            $oOcolumn = 'regular_price';
            $oOdirection = 'asc';
            break;
        case 4:
            $oOcolumn = 'regular_price';
            $oOdirection = 'desc';
            break;
        default:
            $oOcolumn = 'created_at';
            $oOdirection = 'desc';
    }

    // Query
    $query = Product::query();

    // ✅ فلترة البراند
    if (!empty($f_brands)) {
        $brandArray = array_filter(explode(',', $f_brands));

        if (!empty($brandArray)) {
            $query->whereIn('brand_id', $brandArray);
        }
    }

    // ✅ فلترة التصنيفات
    if (!empty($f_categories)) {
        $categoryArray = array_filter(explode(',', $f_categories));

        if (!empty($categoryArray)) {
            $query->whereIn('category_id', $categoryArray);
        }
    }

    // ✅ فلترة السعر (المهم 🔥)
    $query->whereBetween('regular_price', [$minPrice, $maxPrice]);

    // التنفيذ
    $products = $query->orderBy($oOcolumn, $oOdirection)
        ->paginate($size)
        ->appends($request->query());

    // البيانات
    $brands = Brand::withCount('products')
        ->orderBy('name', 'ASC')
        ->get();

    $categories = Category::orderBy('name', 'ASC')->get();
        $slides = Slide::where('status', 1)->get()->take(3);

    return view('shop', compact(
        'products',
        'brands',
        'categories',
        'size',
        'order',
        'f_brands',
        'f_categories',
        'minPrice',
        'maxPrice',
        'slides'
    ));
}
    public function productDetails($id)
    {
        $product = Product::where('slug', $id)->firstOrFail();
        $relatedProducts = Product::where('slug', '<>', $id)->take(4)->get();
        return view('details', compact('product', 'relatedProducts'));
    }

}
