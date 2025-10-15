<?php

namespace App\Http\Controllers;

use App\Models\Aviao;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MainController extends Controller
{
    public function home(): View
    {
        $avios = Aviao::all();

        return view('home', compact('avios'));
    }
}
