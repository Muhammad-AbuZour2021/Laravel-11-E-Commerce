<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Surfsidemedia\Shoppingcart\Facades\Cart;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $items = Cart::instance('cart')->content();

        return view('cart', compact('items'));
    }

    public function addToCart(Request $request)
    {
        // 1. جلب المنتج من قاعدة البيانات للتأكد من وجوده ومن سعره الحقيقي
        $product = Product::findOrFail($request->id);

        // 2. تحديد السعر (إما سعر العرض أو السعر العادي) لضمان عدم تلاعب المستخدم
        $price = $product->sale_price ? $product->sale_price : $product->regular_price;

        // 3. إضافة المنتج للسلة
        // المعاملات بالترتيب: (ID, Name, Quantity, Price)
        Cart::instance('cart')->add(
            $product->id,
            $product->name,
            $request->quantity,
            $price
        )->associate(Product::class);

        return redirect()->back()->with('success', 'تم إضافة المنتج للسلة بنجاح!');
    }

    public function increaseQuantity($rowId)
    {

        $product = Cart::instance('cart')->get($rowId);
        $qty = $product->qty + 1;
        Cart::instance('cart')->update($rowId, $qty);
        return redirect()->back();
    }

    public function decreaseQuantity($rowId)
    {

        $product = Cart::instance('cart')->get($rowId);
        $qty = $product->qty - 1;
        Cart::instance('cart')->update($rowId, $qty);
        return redirect()->back();
    }
    public function removeCart($rowId)
    {
        Cart::instance('cart')->remove($rowId);
        return redirect()->back()->with('success', 'تم إزالة المنتج من السلة بنجاح!');
    }
    public function clearCart()
    {
        Cart::instance('cart')->destroy();
        return redirect()->back()->with('success', 'تم تفريغ السلة بنجاح!');
    }

    public function checkout()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        $address = Address::where('user_id', Auth::id())->where('isdefault', 1)->first();
        return view('checkout', compact('address'));
    }
    public function place_an_order(Request $request)
    {

        $user_id = Auth::user()->id;
        $address = Address::where('user_id', $user_id)->where('isdefault', true)->first();
        if (!$address) {

            $request->validate([
                'name' => 'required|max:100',
                'phone' => 'required|numeric|digits:10',
                'zip' => 'required|numeric|digits:6',
                'state' => 'required',
                'city' => 'required',
                'address' => 'required',
                'locality' => 'required',
                'landmark' => 'required',
            ]);
            $address = new Address();
            $address->user_id = $user_id;
            $address->name = $request->name;
            $address->phone = $request->phone;
            $address->zip = $request->zip;
            $address->state = $request->state;
            $address->city = $request->city;
            $address->address = $request->address;
            $address->locality = $request->locality;
            $address->landmark = $request->landmark;
            $address->country = 'Palestine';
            $address->isdefault = true;
            $address->save();
        }
        $this->setAmountforCheckout();
        $checkout = Session::get('checkout');
        $order = new Order();
        $order->user_id = $user_id;
        $order->subtotal = (float) str_replace(',', '', $checkout['subtotal']);
        $order->tax      = (float) str_replace(',', '', $checkout['tax']);
        $order->total    = (float) str_replace(',', '', $checkout['total']);
        $order->name = $address->name;
        $order->phone = $address->phone;
        $order->locality = $address->locality;
        $order->address = $address->address;
        $order->city = $address->city;
        $order->state = $address->state;
        $order->country = $address->country;
        $order->landmark = $address->landmark;
        $order->zip = $address->zip;
        $order->save();
        foreach (Cart::instance('cart')->content() as $item) {
            $orderItem = new OrderItem();
            $orderItem->product_id = $item->id;
            $orderItem->order_id = $order->id;
            $orderItem->quantity = $item->qty;
            $orderItem->price = $item->price;
            $orderItem->save();
        }


        if ($request->mode == "card") {
        } else if ($request->mode == "paypal") {
        } else if ($request->mode == "cod") {
            $transaction = new Transaction();
            $transaction->user_id = $user_id;
            $transaction->order_id = $order->id;
            $transaction->mode = $request->mode;
            $transaction->status = 'pending';
            $transaction->save();
        }



        Cart::instance('cart')->destroy();
        Session::forget('checkout');
        Session::forget('coupon');
        Session::forget('discount');
        Session::PUT('order_id', $order->id);
        return redirect()->route('cart.orders.confirmation');
    }
    public function setAmountforCheckout()
    {
        if (!Cart::instance('cart')->content()->count() > 0) {
            Session::forget('checkout');
            return;
        }
        if (Session::has('coupon')) {
            Session::put('checkout', [
                'discount' => Session::get('discount')['discount'],
                'subtotal' => Session::get('discount')['subtotal'],
                'tax' => Session::get('discount')['tax'],
                'total' => Session::get('discount')['total'],

            ]);
        } else {
            Session::put('checkout', [
                'discount' => 0,
                'subtotal' => Cart::instance('cart')->subtotal(),
                'tax' => Cart::instance('cart')->tax(),
                'total' => Cart::instance('cart')->total(),

            ]);
        }
    }
    public function orders_confirmation()
    {
        if (Session::has('order_id')) {
            $this->setAmountforCheckout();
            $order = Order::find(Session::get('order_id'));
            return view('orders-confirmation', compact('order'));
        }
        return redirect()->route('cart.index');
    }
}
