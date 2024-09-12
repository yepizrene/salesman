<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PermissionController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $permissions = Permission::paginate(5);
    
    return Inertia::render('Security/Permissions', compact('permissions'));
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
  public function show(Permission $permission)
  {
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Permission $permission)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Permission $spatiePermissionModelsPermission)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Permission $spatiePermissionModelsPermission)
  {
    //
  }
}
