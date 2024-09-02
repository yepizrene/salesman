<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Customer;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CustomerController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $customers = Customer::paginate(5);
    return Inertia::render('Customers/Index', compact('customers'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return Inertia::render('Customers/Create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(StoreCustomerRequest $request)
  {
    Customer::create($request->all());
    return Redirect::route('customers.index');
  }

  /**
   * Display the specified resource.
   */
  public function show(Customer $user)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Customer $customer)
  {
    return Inertia::render('Customers/Edit', compact('customer'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UpdateCustomerRequest $request, customer $customer)
  {
    $customer->update($request->validated());
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Customer $customer)
  {
    $customer->delete();
    return Redirect::route('customers.index');
  }
}
