<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Permission;
use App\Http\Resources\Permission as PermissionResource;
use App\Http\Requests\StorePermission;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return PermissionResource::collection(Permission::paginate(10)); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePermission $request)
    {        
        $validatedData = $request->validated();
        $permission = new Permission();
        $new_permission = $permission-> create($validatedData);
        return new PermissionResource( $new_permission );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        return new PermissionResource($permission);
    } 

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function update(StorePermission $request, Permission $permission)
    {
        $validatedData = $request->validated();
         $result = Permission::where('id', '=', $permission -> id)->update($validatedData);
         if($result){
             return response()->json(['success' => 'true']);
         }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Permission::destroy($id);
    }
}


