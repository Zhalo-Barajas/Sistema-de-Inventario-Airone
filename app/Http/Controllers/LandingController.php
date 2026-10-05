<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LandingController extends Controller
{
    public function index(){
        //Comprueba que el usuario este autenticado, caso contrario lo redirigirá a la página de registro.
        if (Auth::check()) {
            return view('landing.index');
        } else {
            return view('auth.register');
            
        }
        // return view('landing.index');
    }
    public function about(){
        //Vista con acerca de.
        return view('landing.about');
    }

}
