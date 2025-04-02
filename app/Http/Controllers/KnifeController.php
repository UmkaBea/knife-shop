<?php

namespace App\Http\Controllers;

use App\Models\Knife;
use Illuminate\Http\Request;

class KnifeController extends Controller
{
    public function index()
    {
        return response()->json(Knife::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'image_url'   => 'nullable|string'
        ]);

        $knife = Knife::create([
            'name'      => $request->name,
            'price'     => $request->price,
            'image_url' => $request->image_url
        ]);

        return response()->json($knife, 201);
    }
}
