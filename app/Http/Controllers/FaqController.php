<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        // Renvoie la vue FAQ
        return view('faq');
    }
}

