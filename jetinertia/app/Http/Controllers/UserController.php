<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserPost;
use App\Http\Requests\UpdateUserPut;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy("id");

        $name="";

        if(request()->has("name")){
            $name=request("name");
            $users = $users->where('name','like','%'.$name.'%')
            ->orwhere('email','like','%'.$name.'%');
        }

        $users = $users->paginate(5)->appends(request()->except("page"));

        return Inertia::render('User/Index',compact('users','name'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('User/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserPost $request)
    {
        User::create($request->validated());
        return Redirect::route('user.index')->with('message', 'Usuario creado');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $customer)
    {
        return Inertia::render('User/Show',compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $customer)
    {
        return Inertia::render('User/Update',compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserPut $request, User $customer)
    {
        $customer->update($request->validated());
        //request()->session()->flash('message', 'Usuario editado');

        if(request()->hasFile('avatar')){
            $customer->updateProfilePhoto(request()->file("avatar"));
        }
        return Redirect::route('user.index', $customer)->with('message', 'Usuario editado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $customer)
    {
        $customer->delete();
        return redirect()->back()->with('message', 'Usuario eliminado');
    }

    public function deleteAvatar(User $customer)
    {
        $customer->deleteProfilePhoto();
        return redirect()->back()->with('message', 'Avatar eliminado');
    }
}
