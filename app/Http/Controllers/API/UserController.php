<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\User;
use App\Movie;

class UserController extends Controller
{
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
    public function store(User $user,  Request $request)
    {
        if (auth('api')->user()->role !== 'admin') {
            abort(403);
        }
        $request->validate(
            [
                'email' => ['required', 'string', 'email', 'max:191', 'unique:users'],
                'name' => ['required', 'string', 'max:191'],
                'last_name' => ['required', 'string', 'max:191'],
                'role' => ['required'],
                'age' => ['required'],
                'password' => 'required|string|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',

            ]
        );
        return User::create([
            'email' => $request['email'],
            'name' => $request['name'],
            'last_name' => $request['last_name'],
            'role' => $request['role'],
            'age' => $request['age'],
            'password' => Hash::make($request['password']),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        // return $favorites = $user->favorites()->all();
        $favorites =  $user->favorites;
        $arr = [];
        foreach ($favorites as $key) {
            $arr[] = Movie::find($key->movie_id);
        }
        return [
            'user' => $user,
            'favorite_movies' => $arr
        ];
        // dd($favorites);
        // return $user;
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
        $validation = $request->validate(
            [
                'email' => 'required|string|email|max:191|unique:users,email,' . $user->id,
                'name' => ['required', 'string', 'max:191'],
                'last_name' => ['required', 'string', 'max:191'],
                'role' => ['required'],
                'age' => ['required'],
                'password' => ['sometimes', 'string', 'min:8'],

            ]
        );
        $user->update($request->all());
        return ['message' => 'updated'];
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
        return ['message' => 'user deleted'];
    }
    public function findUser()
    {
        if ($search = \Request::get('q')) {
            $user = User::where(function ($query) use ($search) {
                $query->where('name', 'LIKE', "%$search%");
            })->paginate(20);
        } else {
            $user = User::latest()->paginate(10);
        }
        return $user;
    }
}
