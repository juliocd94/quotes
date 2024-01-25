<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use App\Models\Favorite;

class QuoteController extends Controller
{
    public function index()
    {
        $quotes = Quote::get();
        return response()->json([
            'status' => true,
            'message'=> "Lista de citas",
            'data'   => $quotes
        ], 200);
    }

    public function quotesUser($userId)
    {
        $quotes = Quote::where('user_id', $userId)->get();

        return response()->json([
            'status' => true,
            'message'=> "Lista de citas",
            'data'   => $quotes
        ], 200);
    }

    public function getExternalQuotes()
    {
        try {
            $randomNumber = mt_rand(1, 1389);

            $url = sprintf('https://dummyjson.com/quotes?limit=5&skip=%d', $randomNumber);

            $response = Http::get($url);
                $quotes = $response->json();
                
                return response()->json([
                    'status' => true,
                    'data' => $quotes,
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Error al obtener citas externas.',
                ], 500);
            }
    }

    public function setFavorite(Request $request)
    {
        try {
            $quoteData = $request->all();

            $quote = new Quote();
            $quote->quote = $quoteData['quote'];
            $quote->author = $quoteData['author'];
            $quote->user_id = $quoteData['userId'];
            $quote->save();

            return response()->json([
                'status' => true,
                'message' => 'Quote agregado a favoritos y guardado en la base de datos',
                'data' => $quoteData
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error al guardar el Quote en la base de datos',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function deleteQuote($id)
    {
        try {
            $quote = Quote::findOrFail($id);
            $quote->delete();

            return response()->json([
                'status' => true,
                'message' => 'Cita eliminada con éxito.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error al eliminar la cita.',
            ], 500);
        }
    }
}
