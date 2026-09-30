<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return response()->json(User::paginate(10), 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);

        $user = User::create([
            'username' => $validated['username'],
            'email'    => $validated['email'],
            'password' => $validated['password'],
        ]);

        return response()->json($user, 201);
    }

    private function authenticateUser(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return null;
        }

        return $user;
    }

    public function login(Request $request)
    {
        $user = $this->authenticateUser($request);
        if (!$user) {
            return response()->json(['message' => 'Credenciales incorrectas'], 401);
        }
        return response()->json($user, 200);
    }

    public function updateUsername(Request $request)
    {
        $user = $this->authenticateUser($request);
        if (!$user) {
            return response()->json(['message' => 'Credenciales incorrectas'], 401);
        }

        $request->validate([
            'new_username' => 'required|string|max:255|unique:users,username',
        ]);

        $user->username = $request->new_username;
        $user->save();

        return response()->json(['message' => 'Username actualizado', 'user' => $user], 200);
    }

    public function updateEmail(Request $request)
    {
        $user = $this->authenticateUser($request);
        if (!$user) {
            return response()->json(['message' => 'Credenciales incorrectas'], 401);
        }

        $request->validate([
            'new_email' => 'required|email|unique:users,email',
        ]);

        $user->email = $request->new_email;
        $user->save();

        return response()->json(['message' => 'Email actualizado', 'user' => $user], 200);
    }

    public function updatePassword(Request $request)
    {
        $user = $this->authenticateUser($request);
        if (!$user) {
            return response()->json(['message' => 'Credenciales incorrectas'], 401);
        }

        $request->validate([
            'new_password' => 'required|min:8',
        ]);

        $user->password = $request->new_password;
        $user->save();

        return response()->json(['message' => 'Contraseña actualizada'], 200);
    }

    public function destroy(Request $request)
    {
        $user = $this->authenticateUser($request);
        if (!$user) {
            return response()->json(['message' => 'Credenciales incorrectas'], 401);
        }

        $user->delete();

        return response()->json(['message' => 'Usuario eliminado'], 200);
    }
}