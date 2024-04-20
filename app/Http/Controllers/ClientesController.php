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
        $clientes = DB::select("SELECT tc.id, tc.identidad, tc.primer_nombre, tc.segundo_nombre, tc.primer_apellido, 
            tc.segundo_apellido, tc.id_genero, tg.nombre genero, tc.celular, tc.domicilio, tc.id_departamento, 
            td.nombre departamento, tc.id_municipio, tm.nombre municipio, tc.correo_electronico, tc.created_at
        FROM public.tbl_clientes tc
        join public.tbl_generos tg on tc.id_genero = tg.id
        join public.tbl_departamentos td on tc.id_departamento = td.id
        join public.tbl_municipios tm on tc.id_municipio = tm.id
            where tc.deleted_at is null;");

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
        $identidad=$request->identidad;
        $departamento=$request->departamento;
        $municipio=$request->municipio;
        $domicilio=$request->domicilio;
        $id_departamento=$request->id_departamento;
        $clientes_list = null;
        $msgSuccess = null;
        $msgError = null;

        if ($id == null && $accion == 2) {
            $accion = 1;
        }

        try {
            //throw New Exception($identidad, true);
            if ($accion == 1) {
                $cliente = collect(\DB::select("INSERT INTO public.tbl_clientes(
                    identidad, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, id_genero, celular, domicilio, id_departamento, id_municipio, correo_electronico)
                    VALUES (:identidad, :primer_nombre, :segundo_nombre, :primer_apellido, :segundo_apellido, :id_genero, :celular, :domicilio, :id_departamento, :id_municipio, :correo_electronico)
                    returning id;",
                    ["identidad" => $identidad, "primer_nombre" => $primer_nombre, "segundo_nombre" => $segundo_nombre, 
                    "primer_apellido" => $primer_apellido, "segundo_apellido" => $segundo_apellido, "id_genero" => $genero, 
                    "celular" => $celular, "domicilio" => $domicilio, "id_departamento" => $id_departamento, 
                    "id_municipio" => $municipio, "correo_electronico" => $correo]))->first();

                $id = $cliente->id;
                $msgSuccess = "Cliente ".$id." registrado exitosamente.";
            }else if ($accion == 2) {

            }else if ($accion == 3) {
                DB::select("UPDATE public.tbl_clientes SET deleted_at = now() WHERE id = :id;", ["id" => $id]);
                $msgSuccess = "Cliente ".$id." eliminado exitosamente.";
            }else{
                $msgError = "Acción inválida";
            }
                $clientes_list = collect(\DB::select("SELECT tc.id, tc.identidad, tc.primer_nombre, tc.segundo_nombre, tc.primer_apellido, 
                    tc.segundo_apellido, tc.id_genero, tg.nombre genero, tc.celular, tc.domicilio, tc.id_departamento, 
                    td.nombre departamento, tc.id_municipio, tm.nombre municipio, tc.correo_electronico, tc.created_at
                FROM public.tbl_clientes tc
                join public.tbl_generos tg on tc.id_genero = tg.id
                join public.tbl_departamentos td on tc.id_departamento = td.id
                join public.tbl_municipios tm on tc.id_municipio = tm.id
                    where tc.deleted_at is null and tc.id = :id;", ["id" => $id]))->first();
        } catch (Exception $e) {
            $msgError = $e->getMessage();
        }

        return response()->json(['msgSuccess' => $msgSuccess, 'msgError' => $msgError, 'clientes_list' => $clientes_list]);
    }
}
