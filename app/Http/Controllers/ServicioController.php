<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use DB;
use Session;
use Exception;

class ServicioController extends Controller
{
    public function ver_servicio()
    {
        $tipo_servicio = DB::select("SELECT id, nombre from tbl_tipo_servicio where deleted_at is null order by nombre");

        return view('juntaagua.servicios')
            ->with('tipo_servicio', $tipo_servicio);
    }


    public function guardar_servicio(Request $request)
    {
        $accion=$request->accion;
        $id=$request->id;
        $nombre=$request->nombre;       
        $servicio_list = null;
        $msgSuccess = null;
        $msgError = null;

        if ($id == null && $accion == 2) {
            $accion = 1;
        }

        try {
            //throw New Exception($identidad, true);
            if ($accion == 1) {
                $nuevo_servicio = collect(\DB::select("INSERT into tbl_tipo_servicio (nombre, created_at) values (:nombre, now() ) 
                    returning id;",
                    ["nombre" => $nombre]))->first();

                $id = $nuevo_servicio->id;
                $msgSuccess = "Servicio ".$id." registrado exitosamente.";
            }else if ($accion == 2) {
                DB::select("UPDATE tbl_tipo_servicio set nombre = :nombre , updated_at=now() where id = :id",
                    ["id" => $id, "nombre" => $nombre]);
                $msgSuccess = "Servicio ".$id." editado exitosamente.";
            }else if ($accion == 3) {
                DB::select("UPDATE tbl_tipo_servicio set deleted_at = now() where id = :id", ["id" => $id]);
                $msgSuccess = "Servicio ".$id." eliminado exitosamente.";
            }else{
                $msgError = "Acción inválida";
            }
                $servicio_list = collect(\DB::select("SELECT id, nombre from tbl_tipo_servicio 
                where deleted_at is null  and id = :id order by nombre", ["id" => $id]))->first();
        } catch (Exception $e) {
            $msgError = $e->getMessage();
        }

        return response()->json(['msgSuccess' => $msgSuccess, 'msgError' => $msgError, 'servicio_list' => $servicio_list]);
    }
    
}
