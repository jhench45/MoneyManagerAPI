<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegistrationController extends Controller
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
        $validator = Validator::make($request->all(),[
            'fname' => 'required',
            'lname' => 'required',
            'password' => 'required|min:8',
            'email' => 'required|email|unique:users,email',
        ]);

        if($validator->fails()){
            $errors = $validator->errors();
            $err = array(
                'fname'=>$errors->first('fname'),
                'lname'=>$errors->first('lname'),
                'email'=>$errors->first('email'),
                'password'=>$errors->first('password'),

            );

            return response()->json(array(
                'message' => 'Cannot process request. Check your input.',
                'errors' => $err
            ),422);
        }

        $user=new User;
        $user->fname = $request->input('fname');
        $user->lname = $request->input('lname');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->save();

        return response()->json(array(
            'message' => 'Registration Successful',
            'user' => $user
        ),201);
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
