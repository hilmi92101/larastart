<?php

// COMMAND: php artisan make:controller API/UserController --api

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

Use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
        return User::latest()->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            "name" => 'required|string|max:191',
            "email" => 'required|string|email|max:191|unique:users',
            "password" => 'required|string|min:6',
        ]);

        /*$val_rules =  [
            "name" => 'required|string|max:191',
            "email" => 'required|string|email|max:191|unique:users',
            "password" => 'required|string|min:6',
        ];

        $custom_messages = [
            'name.required' => 'The :attribute field is required.',
            'password.required' => 'The :attribute field is required.',
        ];

        $validator = Validator::make($request->all(), $val_rules, $custom_messages);
        if($validator->fails()){
            return response()->json([
                //'status' => false,
                'message'    => 'The given data was invalid.',
                //'status_type' => 'validation failed',
                //'passwordIncorrect' => false,
                'errors' => $validator->errors(),
            ]);
        }*/

 
        return User::create([

            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "type" => $request->type,
            "bio" => $request->bio,
            "photo" => $request->photo,

        ]);

        //return User::latest()->paginate(10);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $this->validate($request, [
            "name" => 'required|string|max:191',
            "email" => 'required|string|email|max:191|unique:users,email,' . $user->id,
            "password" => 'string|min:6',
        ]);

        $user = User::findOrFail($id);
        $user->update($request->all());
        $users =  User::latest()->paginate(10);
        $data = [
            'status' => true,
            'users' => $users,
        ];
        return response()->json($data); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::where('id',$id)->delete();

        $users = User::latest()->paginate(10);

        return [

            "users" => $users,
            "status" => true
        ];
    }
}
