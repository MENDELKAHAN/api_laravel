<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Permission;
use App\Http\Resources\User as UserResource;
use App\Http\Requests\StoreUser;

class UserController extends Controller
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
       return UserResource::collection(User::paginate(10)); 
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(StoreUser $request)
    {
        // isset($this->item->id) ? $itemID = $this->item->id : $itemID = "";
        
        $validatedData = $request->validated();

        $validatedData['password'] = bcrypt($validatedData['password']);
        $user = new User();
        $new_user = $user-> create($validatedData);
        return new UserResource( $new_user );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
         return new UserResource($user);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   public function update(StoreUser $request, $id)
    {
        $validatedData = $request->validated();
         $result = User::where('id', '=', $id)->update($validatedData);
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
         return User::destroy($id);
    }


    public function storeUserRole(Request $request)
    {
        // validate

        // set user role
        $user = User::find($request -> user);
        $user -> roles() -> sync($request -> role);
        $user -> save();   
       
        // return 
        return response()->json(['success' => 'true']);    
    }

     public function storeUserPermission(Request $request)
    {
        // validate

        // get permission
        $permission = Permission::find($request->permission);
        $user = User::find($request->user);
        $user->permissions()->attach($permission);
       
        // // return 
        return response()->json(['success' => 'true']);    
    }

    public function destroyUserPermission(Request $request)
    {
        // validate

        // get permission
        $permission = Permission::find($request->permission);
        $user = User::find($request->user);
        $user->permissions()->detach($permission);

        // return 
        return response()->json(['success' => 'true']);    
    }

    $user->roles()->detach($roleId);
}
