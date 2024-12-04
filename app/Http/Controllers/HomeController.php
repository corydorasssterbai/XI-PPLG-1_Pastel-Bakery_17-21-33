<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Support\Facedes\DB;
use App\Models\Contact;
use App\Models\Product;


class HomeController extends Controller
{
    public function index (){
        $product = Product::all();
        return view('index', compact('product'));
    }
    public function login (){
        return view('login');
    }
    public function about (){
        return view('about');
    }

    public function store(Request $request)
    {
        // Validasi data
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email',
            'message' => 'required',
        ]);

        // Simpan ke database
        Contact::create($validatedData);

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Pesan Anda berhasil dikirim!');
    }
}

