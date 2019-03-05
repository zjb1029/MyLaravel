<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',[
            'except'=>['show','create','store']
        ]);
        $this->middleware('guest',[
            'only'=>['create']
        ]);
    }

    public function index(){
        return view('users.index');
    }

    public function create(){
        return view('users.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);
        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),
        ]);
        Auth::login($user);
        session()->flash('success', '欢迎，您将在这里开启一段新的旅程~');
        return redirect()->route('users.show', [$user]);
    }

    /**
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(User $user){
        try{
            $this->authorize('update', $user);
            return view('users.edit',compact('user'));
        }catch (AuthorizationException $e){
            return 1;
        }
    }

    public function update(User $user,Request $request){
        $this->validate($request,[
            'name' => 'required|max:50',
            'password' => 'nullable|confirmed|min:6'
        ]);
        $this->authorize('update', $user);
        $data = [];
        $data['name'] = $request->name;
        if($request->password){
            $data['password'] = $request->password;
        }
        $user->update($data);
        session()->flash('success','个人资料更新成功!');
        return redirect()->route('users.show',$user->id);
    }

    public function show(User $user){
        return view('users.show', compact('user'));
    }
}
