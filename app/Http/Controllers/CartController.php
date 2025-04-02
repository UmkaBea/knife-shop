<?php

namespace App\Http\Controllers;

use App\Models\Knife;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{

    public function index(Request $request)
    {
        $cart = session()->get('cart', []);
        return response()->json($cart);
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'knife_id' => 'required|exists:knives,id'
        ]);

        $knife = Knife::findOrFail($request->knife_id);

        $cart = session()->get('cart', []);
        $cart[$knife->id] = [
            'id'    => $knife->id,
            'name'  => $knife->name,
            'price' => $knife->price,
            'image' => $knife->image_url,
        ];

        session()->put('cart', $cart);

        return response()->json(['message' => 'Добавлено в корзину', 'cart' => $cart]);
    }

    public function buy(Request $request)
    {
        $user = $request->user();
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return response()->json(['message' => 'Корзина пуста'], 400);
        }

        $total = collect($cart)->sum('price');

        if ($user->balance < $total) {
            return response()->json(['message' => 'Недостаточно средств'], 400);
        }
    }
}