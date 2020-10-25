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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
