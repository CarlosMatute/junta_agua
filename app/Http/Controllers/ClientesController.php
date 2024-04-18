<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class ClientesController extends Controller
{
    public function ver_clientes()
    {
        return view('juntaagua.clientes');
    }
}
