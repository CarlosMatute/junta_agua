<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use DB;

class ClientesController extends Controller
{
    public function ver_clientes()
    {
        $clientes = DB::select('SELECT * from users where deleted_at is null');

        $generos = DB::select('SELECT id, nombre from public.tbl_generos where deleted_at is null');

        $departamentos = DB::select('SELECT id, nombre from public.tbl_departamentos where deleted_at is null order by nombre');

        return view('juntaagua.clientes')
            ->with('clientes', $clientes)
            ->with('generos', $generos)
            ->with('departamentos', $departamentos);
    }
}
