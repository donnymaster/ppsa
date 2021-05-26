<?php

namespace App\Http\Controllers\User;

use App\Http\Resources\User\SearchUserResource;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $roleName = $request->input('role') ?? Role::USER;
        $role = Role::where('name', $roleName)->firstOrFail();
        $firstName = $request->input('last-name') ?? '';

        $users = User::where('last_name', 'like', '%' . $firstName . '%')
            ->limit(30)
            ->where('role_id', $role->id)
            ->get();

        return response()->json(SearchUserResource::collection($users));
    }
}
