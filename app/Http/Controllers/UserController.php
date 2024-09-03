<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class UserController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $users = User::paginate(5);
    return Inertia::render('Users/Index', compact('users'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return Inertia::render('Users/Create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(StoreUserRequest $request)
  {
    User::create($request->all());
    return Redirect::route('users.index');
  }

  /**
   * Display the specified resource.
   */
  public function show(User $user)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(User $user)
  {
    return Inertia::render('Users/Edit', compact('user'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UpdateUserRequest $request, User $user)
  {
    $user -> update($request -> validated());
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(User $user)
  {
    $user -> delete();
    return Redirect::route('users.index');
  }
}
