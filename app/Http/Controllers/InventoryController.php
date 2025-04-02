<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $inventory = $request->user()->inventory()->with('knife')->get();

        $knives = $inventory->map(function ($item) {
            return [
                'id'    => $item->knife->id,
                'name'  => $item->knife->name,
                'price' => $item->knife->price,
                'image' => $item->knife->image_url,
            ];
        });

        return response()->json($knives);
    }
}
