<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function getAllUsers()
    {
        if (1 == 1) {
            try {
                $users = User::all();

                return response()->json([
                    'status' => true,
                    'data' => $users,
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Error al obtener la lista de usuarios.',
                ], 500);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Acceso no autorizado.',
            ], 403);
        }
    }

    public function blockUser($userId)
    {
        try {
            $user = User::find($userId);
        
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Usuario no encontrado.',
                ], 404);
            }

            $user->update(['banning' => true]);
    
            
            return response()->json([
                'status' => true,
                'message' => 'Usuario bloqueado exitosamentew.',
            ]);

            
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error al bloquear al usuario.',
            ], 500);
        }
    }

    public function unblockUser($userId)
    {
        try {
            $user = User::find($userId);

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Usuario no encontrado.',
                ], 404);
            }

            $user->update(['banning' => false]);
           
            return response()->json([
                'status' => true,
                'message' => 'Usuario desbloqueado exitosamente.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error al desbloquear al usuario.',
            ], 500);
        }
    }
}
