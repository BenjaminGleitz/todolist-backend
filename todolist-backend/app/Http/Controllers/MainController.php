<?php

namespace App\Http\Controllers;

class MainController extends Controller
{
    /**
     * HTTP Method : GET
     * URL : '/'
     */
    public function home() {
        echo "je suis sur la page d'accueil";
    }
}
