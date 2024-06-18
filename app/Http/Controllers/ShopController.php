<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::withWhereHas('stocks')->get();
        return response()->json($products);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    public function postCheckout(Request $request){
        $products = json_decode($request->getContent(), true);
        $user = Auth::user();
        $customerId = $user->customer->id;

        $request->validate([
            'products' => 'required|array',
            'products.*.product_id' => 'required|integer|exists:stocks,product_id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            $cartItems = Cart::where('customer_id', $customerId)->get();

            $order = new Order();
            $order->customer_id = $customerId;
            $order->date_placed = Carbon::now();
            $order->date_shipped = Carbon::now();
            $order->shipping = 10.00;
            $order->status = 'Processing';
            $order->courier_id = $request->courier_id;
            $order->save();

            foreach ($cartItems as $cartItem) {
                $stock = Stock::where('product_id', $cartItem['product_id'])->firstOrFail();
                if ($stock->quantity < $cartItem['quantity']) {
                    throw new \Exception('Not enough stock for this product: ' . $cartItem['product_id']);
                }

                $order->products()->attach($cartItem['product_id'], [
                    'quantity' => $cartItem['quantity'],
                    'order_id' => $order->id,
                ]);

                $stock->quantity -= $cartItem['quantity'];
                $stock->save();
            }

            Payment::create([
                'order_id' => $order->id,
                'mode_of_payment' => $request->input('payment_method'),
                'date_of_payment' => now(),
            ]);

            Cart::where('customer_id', $customerId)->delete();

            DB::commit();

            return response()->json([
                'status' => 'Order Success',
                'code' => 200,
                'orderId' => $order->id,
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'Order failed',
                'code' => 409,
                'error' => $e->getMessage(),
            ], 409);
        }
    }


    // public function checkout(Request $request)
    // {
    //     $rules = [
    //         'shipping_address' => 'required',
    //         'shipment_id' => 'required',
    //         'payment_id' => 'required',
    //         'credit_card' => 'min:16|max:16'
    //     ];

    //     $messages = [
    //         'shipping_address.required' => 'Please input your shipping address',
    //         'shipment_id.required' => 'Please select a shipment',
    //         'payment_id.required' => 'Please select a payment',
    //         'credit_card' => 'Please input a proper credit card info format'
    //     ];

    //     Validator::make($request->all(), $rules, $messages)->validate();

    //     $user = auth()->user()->id;

    //     $cart = DB::table('carts')
    //         ->join('customers', 'customers.id', "=", 'carts.customer_id')
    //         ->join('products', 'products.id', "=", 'carts.product_id')
    //         ->select('carts.*', 'products.product_img', 'products.product_name')
    //         ->where('user_id', $user)->get();

    //     $order = new Order;
    //     $order = Order::create([
    //         'user_id' => $user,
    //         'shipment_id' => $request->shipment_id,
    //         'payment_id' => $request->payment_id,
    //         'credit_card' => $request->credit_card,
    //         'shipping_address' => $request->shipping_address,
    //         'status' => 'Processing',
    //         'date_ordered' => now(),
    //         'date_shipped' => null,
    //     ]);

    //     $order->save();

    //     foreach ($cart as $carts) {
    //         // $orderitem = new Orderitem;
    //         // $orderitem = Orderitem::insert([
    //         //     'order_id' => $order->id,
    //         //     'user_id' => $order->user_id,
    //         //     'product_id' => $carts->product_id,
    //         //     'quantity' => $carts->quantity,
    //         //     'price' => $carts->price
    //         // ]);
    //         // $orderitem->orders()->products()->attach($carts->product_id, [
    //         //     'user_id' => $user,
    //         //     'quantity' => $carts->quantity,
    //         //     'price' => $carts->price
    //         // ]);
    //         $order->products()->attach($carts->product_id, [
    //             'user_id' => $user,
    //             'quantity' => $carts->quantity,
    //             'price' => $carts->price
    //         ]);

    //         $stocks = stock::where('product_id', $carts->product_id)->first();
    //         stock::where('product_id', $carts->product_id)->update([
    //             "stock" => $stocks->stock - $carts->quantity
    //         ]);
    //         $stocks->save();
    //     }

    //     if ($stocks->save()) {
    //         $name = auth()->user()->name;
    //         $totalprice = 0;
    //         $cart = DB::table('carts')
    //             ->join('users', 'users.id', "=", 'carts.user_id')
    //             ->join('products', 'products.id', "=", 'carts.product_id')
    //             ->select('carts.*', 'products.product_img', 'products.product_name')
    //             ->where('user_id', $user)->get();

    //         $processorders = DB::table('orders')
    //             ->join('users', 'users.id', '=', 'orders.user_id')
    //             ->join('shipments', 'shipments.id', '=', 'orders.shipment_id')
    //             ->join('payments', 'payments.id', '=', 'orders.payment_id')
    //             ->select(
    //                 'orders.*',
    //                 'shipments.shipment_name',
    //                 'shipments.shipment_cost',
    //                 'payments.payment_name'
    //             )
    //             ->where('orders.id', $order->id)
    //             ->where('user_id', $user)
    //             ->where('status', 'Processing')
    //             ->first();

    //         foreach ($cart as $carts) {
    //             $totalprice += $carts->price;
    //         }

    //         Mail::to('kicks6873@gmail.com')->send(new Notification($name, $cart, $processorders, $totalprice));
    //     }

    //     cart::where('user_id', $user)->delete();
    //     return redirect()->back()->with('message', 'An order request has been sent!');
    // }
}
