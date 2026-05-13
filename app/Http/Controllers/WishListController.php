<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Surfsidemedia\Shoppingcart\Facades\Cart;
class WishListController extends Controller
{
    public function addToWishlist(request $request)
    {

    Cart::instance('wishlist')->add($request->id, $request->name, $request->qty, $request->price)->associate('App\Models\Product');
    return redirect()->back()->with('success_message', 'Product added to wishlist successfully!');
    }

}
