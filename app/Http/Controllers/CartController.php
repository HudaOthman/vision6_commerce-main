<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use App\Notifications\NewOrderNotification;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function add_cart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|min:1'
        ]);

        $product = Product::find($request->product_id);

        Cart::updateOrCreate([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id
        ], [
            'quantity' => DB::raw('quantity + '. $request->quantity),
            // 'quantity' => $request->quantity,
            'user_id' => Auth::id(),
            'price' => $product->final_price
        ]);

        // $cart = Cart::where('user_id', Auth::id())->where('product_id', $request->product_id)->first();

        // if($cart) {
        //     $cart->update(['quantity' => $request->quantity + $cart->quantity]);
        // }else {
        //     Cart::create([
        //         'product_id' => $request->product_id,
        //         'quantity' => $request->quantity,
        //         'user_id' => Auth::id(),
        //         'price' => $product->final_price
        //     ]);
        // }



        // dd($request->all());
        return redirect()->back()->with('msg', 'Product added to cart successfully');
    }

    public function cart()
    {
        $carts = Auth::user()->carts;
        return view('site.cart', compact('carts'));
    }

    public function remove_cart($id)
    {
        Cart::destroy($id);

        return redirect()->back()->with('msg', 'Cart removed');
    }

    public function update_cart(Request $request)
    {
        // return $request->all();
        foreach($request->qty as $id => $value) {
            Cart::find($id)->update(['quantity' => $value]);
        }

        $carts = Auth::user()->carts;

        return view('site.cart-items', compact('carts'))->render();
    }

    public function checkout()
    {
        $carts = Auth::user()->carts;

        $total = 0;
        foreach ($carts as $cart):
            $total += $cart->quantity * $cart->price;
        endforeach;

        $url = "https://eu-test.oppwa.com/v1/checkouts";
        $data = "entityId=8a8294174b7ecb28014b9699220015ca" .
                    "&amount=$total" .
                    "&currency=USD" .
                    "&paymentType=DB";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Authorization:Bearer OGE4Mjk0MTc0YjdlY2IyODAxNGI5Njk5MjIwMDE1Y2N8c3k2S0pzVDg='));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if(curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);

        $responseData = json_decode($responseData, true);

        // dd($responseData);

        $checkoutId = $responseData['id'];

        return view('site.checkout', compact('carts', 'total', 'checkoutId'));
    }

    public function thanks()
    {
        // dd(request()->all());

        $resourcePath = request()->resourcePath;

        $url = "https://eu-test.oppwa.com/$resourcePath";
        $url .= "?entityId=8a8294174b7ecb28014b9699220015ca";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Authorization:Bearer OGE4Mjk0MTc0YjdlY2IyODAxNGI5Njk5MjIwMDE1Y2N8c3k2S0pzVDg='));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if(curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        $responseData = json_decode($responseData, true);

        if($responseData['result']['code'] == '000.100.110') {

            $carts = Auth::user()->carts;

            $total = 0;
            foreach ($carts as $cart):
                $total += $cart->quantity * $cart->price;
            endforeach;

            $vat = env('VAT') / 100 * $total;

            DB::beginTransaction();

            try {
                // 1 Create New Order
                $order = Order::create([
                    'user_id' => Auth::id(),
                    'total' => $total,
                    'vat' => $vat,
                    'final_total' => $total + $vat,
                    'payment_status' => 'completed'
                ]);

                // 2 Add Cart Items to ORder Cart Table
                foreach ($carts as $cart) {
                    OrderItem::create([
                        'user_id' => $cart->user_id,
                        'order_id' => $order->id,
                        'product_id' => $cart->product_id,
                        'price' => $cart->price,
                        'quantity' => $cart->quantity,
                    ]);
                }

                // 3 Remove cart form Carts Table

                User::find(Auth::id())->carts()->delete();

                // 4 Create New payment record
                // order_id	user_id	total	transaction_id
                Payment::create([
                    'order_id' => $order->id,
                    'user_id' => Auth::id(),
                    'total' => $total+$vat,
                    'transaction_id' => $responseData['id']
                ]);

                DB::commit();
            }catch(Exception $e) {
                DB::rollBack();

                throw $e->getMessage();
            }

            // Send Notification to admin
            $admin = User::where('type', 'super-admin')->first();
            $admin->notify(new NewOrderNotification($order));

            return view('site.success');

        }else {
            return view('site.error');
        }
    }
}
