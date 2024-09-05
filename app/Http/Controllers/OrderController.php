<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class OrderController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $orders = Order::paginate(5);
    return Inertia::render('Orders/Index', compact('orders'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    $user = Auth::user();
    $products = Product::getActives();
    $customers = Customer::all();

    return Inertia::render('Orders/Create', compact('user','products', 'customers'));
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(StoreOrderRequest $request)
  {
    $order = Order::create([
      'customer_id' => null,
      'user_id' => $request->user()->id
    ]);

    $items = $request['items'];
    foreach($items as $item){
      $order->items()->create([
        'price' => $item['price'],
        'quantity' => $item['quantity'],
        'product_id' => $item['product']['id']
      ])->save();
    }

    return Redirect::route('orders.index')->with('message','Order created correctly!');
  }

  /**
   * Display the specified resource.
   */
  public function show(Order $order)
  {
    $user = $order->user;
    $products = Product::getActives();
    $customers = Customer::all();

    return Inertia::render('Orders/Show', compact('order','user','products'));
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Order $order)
  {
    $products = Product::getActives();
    return Inertia::render('Orders/Edit', compact('order','products'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UpdateOrderRequest $request, Order $order)
  {
    
  }

  public function cancel(UpdateOrderRequest $request){
    $order = Order::find($request->all()['id']);
    $order->status = false;
    $order->save();
    
    return Redirect::route('orders.index')->with('message','Order canceled correctly!');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Order $order)
  {
    //
  }
}
