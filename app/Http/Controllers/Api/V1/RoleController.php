<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Role;
use App\Http\Resources\Role as RoleResource;
use App\Http\Requests\StoreRole;

class RoleController extends Controller
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
       return RoleResource::collection(Role::paginate(10)); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRole $request)
    {
        isset($this->item->id) ? $itemID = $this->item->id : $itemID = "";
        
        $validatedData = $request->validated();
        $role = new Role();
        $new_role = $role-> create($validatedData);
        return new RoleResource( $new_role );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {

        return new RoleResource($role);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function update(StoreRole $request, $id)
    {
        $validatedData = $request->validated();
         $result = Role::where('id', '=', $id)->update($validatedData);
         if($result){
             return response()->json(['success' => 'true']);
         }
         // else{

         // }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Role::destroy($id);
    }



     public function storeUserPermission(Request $request)
    {
        // validate

        // get permission
        $permission = Permission::find($request->permission);
        $role = Role::find($request->role);
        $role->permissions()->attach($permission);
       
        // return 
        return response()->json(['success' => 'true']);    
    }

    public function destroyUserPermission(Request $request)
    {
        // validate

        // get permission
        $permission = Permission::find($request->permission);
        $role = Role::find($request->role);
        $role->permissions()->detach($permission);
       
        // return 
        return response()->json(['success' => 'true']);    
    }
}
