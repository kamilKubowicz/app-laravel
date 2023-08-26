<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        //By default, the role should be set as user, and the other roles should be assigned by the super admin
        // (editor,admin) from the panel. The super admin itself should be created by the command
        User::create(
            [
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'role' => $request->role ?? User::ROLE_USER,
            ]
        );

        return response()->json([
            'message' => 'Registration successful'
        ]);
    }
}
