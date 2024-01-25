<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Quote;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{

    public function favoritesToUser($userId)
    {
        $quotes = Quote::where('user_id', $userId)->get();

        return response()->json([
            'status' => true,
            'data'  => $quotes
        ], 200);
    }

    public function destroy(Quote $quote)
    {
        try {
            $quote->delete();
    
            return response()->json([
                'status' => true,
                'message' => 'Quote eliminado con éxito',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error al eliminar el Quote',
            ]);
        }
    }
}
