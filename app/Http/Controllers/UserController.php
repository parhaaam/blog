<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Storage;
use Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View('users.index',[
          'users' => User::paginate(15)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return View('users.create');

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
          'email'          => 'required|string|unique:users|email',
          'password'       => 'required|string|min:8|confirmed',
          'role'           => 'integer',
          'photo'          => 'nullable|file|image',
      ]);

      $photoPath = Storage::putFile('profile', $request->file('photo'));
      $user = User::create([
        'name'      => $request->input('name'),
        'email'     => $request->input('email'),
        'password'  => Hash::make($request->input('password')),
        'role'      => $request->input('role'),
        'bio'      => $request->input('bio'),
        'photo'     => $photoPath
      ]);
      return redirect()->route('usersList')->withErrors(new MessageBag(['messages' => 'کاربر با موفقیت ثبت شد']));
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
      return View('users.edit')->with(['user' => $user]);
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
        $photoPath = Storage::putFile('profile', $request->file('photo'));
        $user->photo      = $photoPath;
      }
      $user->name       = $request->input('name');
      $user->bio        = $request->input('bio');
      $user->save();
      return redirect()->route('usersList')->withErrors(new MessageBag(['messages' => 'کاربر با موفقیت ویرایش شد']));
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
        return redirect()->route('usersList')->withErrors(new MessageBag(['messages' => 'کاربر با موفقیت حذف شد']));

    }
}
