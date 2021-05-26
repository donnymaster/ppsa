<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    /**
     * Show user account
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $role = Role::where('id', $user->role_id)->firstOrFail();

        return view('pages.user.account', compact('user', 'role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request)
    {
        $validatedData = $request->validated();
        $user = Auth::user();

        if ($validatedData['password'] && $validatedData['new_password']) {
            if (Hash::check($validatedData['password'], $user->password)) {
                $user->password = Hash::make($validatedData['new_password']);
            }
            return redirect()
                ->route('account.index')
                ->withErrors(['password' => 'Ви вказали неправильний пароль']);
        }

        $user->email      = $validatedData['email'];
        $user->first_name = $validatedData['first_name'];
        $user->last_name  = $validatedData['last_name'];
        $user->save();

        return back();
    }
}
