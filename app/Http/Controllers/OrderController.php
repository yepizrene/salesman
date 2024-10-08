<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
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

    return Inertia::render('Orders/Create', compact('user', 'products', 'customers'));
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
    foreach ($items as $item) {
      $order->items()->create([
        'price' => $item['price'],
        'quantity' => $item['quantity'],
        'product_id' => $item['product']['id']
      ])->save();
    }

    return Redirect::route('orders.index')->with('message', 'Order created correctly!');
  }

  /**
   * Display the specified resource.
   */
  public function show(Order $order)
  {
    $products = Product::getActives();
    return Inertia::render('Orders/Show', compact('order', 'products'));
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Order $order)
  {
    $products = Product::getActives();
    return Inertia::render('Orders/Edit', compact('order', 'products'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UpdateOrderRequest $request, Order $order)
  {
    $orderRequest = json_decode($request->getContent());
    $orderSaved = json_decode($order);

    $itemsRequest = $orderRequest->items;
    $itemsSaved = $orderSaved->items;

    $evalItemslength = (count($itemsRequest) > count($itemsSaved));
    $equalsItemslength = (count($itemsRequest) === count($itemsSaved));

    $option = ($evalItemslength) ? 'major' : (($equalsItemslength) ? 'equals' : 'minor');

    switch ($option):
      case 'major':
        //order request items are major of order saved items
        foreach ($orderRequest->deleted_items as $item):
          $itemDeleted = OrderITem::find($item->id);
          $itemDeleted->delete();
          $order->save();
        endforeach;
        foreach ($itemsRequest as $item):
          if ($item->id !== null):
            $this->updateOrderItem($item);
          endif;
          if ($item->id === null):
            $order->items()->create([
              'price' => $item->price,
              'quantity' => $item->quantity,
              'product_id' => $item->product->id
            ])->save();
          endif;
        endforeach;
        break;
      case 'minor':
        //order request items are minor of order saved items
        foreach ($orderRequest->deleted_items as $item):
          $itemDeleted = OrderITem::find($item->id);
          $itemDeleted->delete();
          $order->save();
        endforeach;
        foreach ($itemsRequest as $item):
          if ($item->id !== null):
            $this->updateOrderItem($item);
          endif;
          if ($item->id === null):
            $this->createOrderItem($order, $item);
          endif;
        endforeach;

        break;
      case 'equals':
        //order request items are equals of order saved items
        foreach ($orderRequest->deleted_items as $item):
          $itemDeleted = OrderITem::find($item->id);
          $itemDeleted->delete();
          $order->save();
        endforeach;
        foreach ($itemsRequest as $item):
          if ($item->id !== null):
            $this->updateOrderItem($item);
          endif;
          if ($item->id === null):
            $this->createOrderItem($order, $item);
          endif;
        endforeach;
        break;
    endswitch;

    return Redirect::route('orders.index')->with('message', 'Order updated correctly!');
  }

  private function updateOrderItem($item)
  {
    $itemSaved = OrderItem::find($item->id);
    $itemSaved->quantity = $item->quantity;
    $itemSaved->price = $item->price;
    $itemSaved->save();
  }

  private function createOrderItem(Order $order, $item){
    $order->items()->create([
      'price' => $item->price,
      'quantity' => $item->quantity,
      'product_id' => $item->product->id
    ])->save();
  }

  public function cancel(UpdateOrderRequest $request)
  {
    $order = Order::find($request->all()['id']);
    $order->status = false;
    $order->save();

    return Redirect::route('orders.index')->with('message', 'Order canceled correctly!');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Order $order)
  {
    //
  }
}
