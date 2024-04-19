<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use DB;
use Session;
use Exception;

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

    public function guardar_clientes(Request $request)
    {
        $accion=$request->accion;
        $id=$request->id;
        $primer_nombre=$request->primer_nombre;
        $segundo_nombre=$request->segundo_nombre;
        $primer_apellido=$request->primer_apellido;
        $segundo_apellido=$request->segundo_apellido;
        $genero=$request->genero;
        $celular=$request->celular;
        $correo=$request->correo;
        $departamento=$request->departamento;
        $municipio=$request->municipio;
        $domicilio=$request->domicilio;
        $id_departamento=$request->id_departamento;
        $msgSuccess = null;
        $msgError = null;

        try {
            throw New Exception($primer_nombre, true);
        } catch (Exception $e) {
            $msgError = $e->getMessage();
        }

        return response()->json(['msgSuccess' => $msgSuccess, 'msgError' => $msgError]);
    }
}
