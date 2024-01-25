<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = User::where('email', $request->email)->first();

            if($user->banning == true){
                return response()->json([
                    "status" => false,
                    "message" => "¡El usuario está bloqueado por el administrador!",
                ]);
            }

            $token = $user->createToken("auth_token")->plainTextToken;

            return response()->json([
                "status" => true,
                "message" => "¡Usuario autenticado exitosamente!",
                "access_token" => $token,
                "user" => $user,
            ]);
        } else {
            return response()->json([
                "status" => false,
                "message" => "La contraseña es incorrecta"
            ], 401);
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'nullable|min:6',
            'name' => 'required',
        ]);

        $user = User::where('id', $request->id)->first();
        $user->email = $request->email;
        $user->name = $request->name;
    
        if (!empty($request->password)) {
            $user->password = bcrypt($request->password);
        }
    
        $user->save();
    
        return response()->json([
            'status' => true,
            'message' => 'Perfil actualizado con éxito',
            'user' => $user,
        ]);
    }
}
