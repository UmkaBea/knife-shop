<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Knife;

class KnifeController extends Controller
{
    public function index()
    {
        return Knife::all();
    }

    public function buy(Request $request)
    {
        $user = $request->user();
        $knife = Knife::findOrFail($request->knife_id);

        if ($user->balance < $knife->price) {
            return response()->json(['message' => 'Недостаточно средств'], 400);
        }

        $user->balance -= $knife->price;
        $user->save();

        $user->inventory()->create([
            'knife_id' => $knife->id
        ]);
        

        return response()->json(['message' => 'Покупка успешна']);
    }

    public function inventory(Request $request)
    {
        return $request->user()->inventory; 
    }
}

