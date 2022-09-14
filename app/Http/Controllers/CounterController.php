<?php

namespace App\Http\Controllers;

use App\Models\Counter;
use Exception;
use Illuminate\Http\Request;

class CounterController extends Controller
{
    public function create()
    {
        return view('counter.create');
    }

    public function post(Request $request)
    {
        try{
            Counter::create([
                'nama' => $request->nama
            ]);

            return redirect()->back()->with('success', 'Counter berhasil ditambah');
        }catch(Exception $x){
            return redirect()->back()->with('success', $x->getMessage());
        }
    }
}
