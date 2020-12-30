<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\MessageBag;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::orderBy('created_at','DESC')->paginate(15);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $request->validate([
          'name'           => 'required|string|max:255',
          'email'          => 'required|string|unique:users,email|email',
          'password'       => 'required|string|min:8|confirmed',
          'role'           => 'integer',
      ]);
      $photoPath = null;
      if($request->hasFile('photo')){
        $request->validate([
          'photo'          => 'nullable|file|image',
        ]);
        $photoPath = Storage::putFile('public', $request->file('photo'));
      }
      $user = User::create([
        'name'      => $request->input('name'),
        'email'     => $request->input('email'),
        'password'  => Hash::make($request->input('password')),
        'role'      => $request->input('role'),
        'bio'      => $request->input('bio'),
        'photo'     => $photoPath
      ]);
      return response(['messages' => 'کاربر با موفقیت ثبت شد'],200);

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {

      $request->validate([
          'name'           => 'required|string|max:255',
          'email'          => 'required|string|unique:users,email,'.$user->id.'|email',
      ]);
      if($request->input('password') != null){
        $request->validate([
            'password'       => 'required|string|min:8|confirmed',
        ]);
        $user->password   = Hash::make($request->input('password'));
      }
      if($request->input('role') != null){
        $request->validate([
          'role'           => 'integer',
        ]);
        $user->role       = $request->input('role');
      }
      if($request->hasFile('photo') != null){
        $request->validate([
          'photo'          => 'nullable|file|image',
        ]);
        $photoPath = Storage::putFile('public', $request->file('photo'));
        $user->photo      = $photoPath;
      }
      $user->name       = $request->input('name');
      $user->email       = $request->input('email');
      $user->bio        = $request->input('bio');
      $user->save();
      return response(['messages' => 'کاربر با موفقیت ویرایش شد'],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response(['messages' => 'کاربر با موفقیت حذف شد'],200);

    }
}
