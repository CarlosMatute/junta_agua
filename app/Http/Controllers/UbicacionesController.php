<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use DB;
use Session;
use Exception;

class UbicacionesController extends Controller
{
    public function ver_ubicaciones()
    {
        $ubicaciones = DB::select("SELECT 
            U.ID,
            U.DESCRIPCION_CASA,
            U.CLIENTE_HABITA,
            U.DIRECCION,
            U.FOTO,
            UPPER(P.NOMBRE) PAIS,
            D.NOMBRE DEPARTAMENTO,
            M.NOMBRE MUNICIPIO,
            U.COORDENADAS,
            U.MONTO,
            U.FECHA_COBRO,
            U.QR,
            U.ACTIVO,
            U.CASA_PROPIA,
            U.ID_PAIS,
            U.ID_DEPARTAMENTO,
            U.ID_MUNICIPIO,
            UPPER(P.NOMBRE)||', '||D.NOMBRE||', '||M.NOMBRE UBICACION
        FROM TBL_UBICACION U
            JOIN TBL_PAISES P ON P.id = U.ID_PAIS 
            JOIN TBL_DEPARTAMENTOS D ON D.ID = U.ID_DEPARTAMENTO
            JOIN TBL_MUNICIPIOS M ON M.ID = U.ID_MUNICIPIO
                WHERE U.DELETED_AT IS NULL
                AND P.DELETED_AT IS NULL
                AND D.DELETED_AT IS NULL
                AND M.DELETED_AT IS NULL");
            
            $paises = DB::select('SELECT
            ID,
            NOMBRE
            FROM
            PUBLIC.TBL_PAISES
            WHERE
            DELETED_AT IS NULL
            ORDER BY
            NOMBRE');

            $departamentos = DB::select('SELECT
            ID,
            NOMBRE
            FROM
            PUBLIC.TBL_DEPARTAMENTOS
            WHERE
            DELETED_AT IS NULL
            ORDER BY
            NOMBRE');
        

        return view('juntaagua.ubicaciones')
            ->with('ubicaciones', $ubicaciones)
            ->with('paises', $paises)
            ->with('departamentos', $departamentos);
    }

    public function guardar_ubicaciones(Request $request)
    {
        $accion=$request->accion;
        $id=$request->id;
        $descripcion_casa=$request->descripcion_casa;
        $direccion=$request->direccion;
        $monto=$request->monto;
        $cliente_habita=$request->cliente_habita;
        $fecha_cobro=$request->fecha_cobro;
        $pais=$request->pais;
        $coordenadas=$request->coordenadas;
        $casa_propia=$request->casa_propia;
        $departamento=$request->departamento;
        $municipio=$request->municipio;
        $activo=$request->activo;
        $ubicacion_casa = $request->ubicacion_casa;
        $ubicaciones_list = null;
        $msgSuccess = null;
        $msgError = null;

        if ($cliente_habita == 1) {
            $cliente_habita = true;
        }else {
            $cliente_habita = false;
        }

        if ($casa_propia == 1) {
            $casa_propia = true;
        }else {
            $casa_propia = false;
        }

        if ($activo == 1) {
            $activo = true;
        }else {
            $activo = false;
        }


        if ($id == null && $accion == 2) {
            $accion = 1;
        }

        try {
            //throw New Exception($identidad, true);
            if ($accion == 1) {
                $ubicacion = collect(\DB::select("INSERT INTO public.tbl_ubicacion(
                    descripcion_casa, direccion, monto, cliente_habita, fecha_cobro, id_pais, coordenadas, casa_propia, id_departamento, id_municipio, activo)
                    VALUES (:descripcion_casa, :direccion, :monto, :cliente_habita, :fecha_cobro, :pais, :coordenadas, :casa_propia, :id_departamento, :id_municipio, :activo)
                    returning id;",
                    [
                        "descripcion_casa" => $descripcion_casa,
                        "direccion" => $direccion,
                        "monto" => $monto,
                        "cliente_habita" => $cliente_habita,
                        "fecha_cobro" => $fecha_cobro,
                        "pais" => $pais,
                        "coordenadas" => $ubicacion_casa,
                        "casa_propia" => $casa_propia,
                        "id_departamento" => $departamento,
                        "id_municipio" => $municipio,
                        "activo" => $activo
                    ]
                ))->first();
            
                $id = $ubicacion->id;
                $msgSuccess = "Ubicación ".$id." registrada exitosamente.";
            }else if ($accion == 2) {
                DB::select("UPDATE public.tbl_ubicacion
                    SET descripcion_casa=:descripcion_casa, direccion=:direccion, monto=:monto, cliente_habita=:cliente_habita, 
                    fecha_cobro=:fecha_cobro, id_pais=:pais, coordenadas=:coordenadas, casa_propia=:casa_propia, 
                    id_departamento=:id_departamento, id_municipio=:id_municipio, activo=:activo, updated_at=now()
                    WHERE id = :id;",
                    [
                        "id" => $id,
                        "descripcion_casa" => $descripcion_casa,
                        "direccion" => $direccion,
                        "monto" => $monto,
                        "cliente_habita" => $cliente_habita,
                        "fecha_cobro" => $fecha_cobro,
                        "pais" => $pais,
                        "coordenadas" => $ubicacion_casa,
                        "casa_propia" => $casa_propia,
                        "id_departamento" => $departamento,
                        "id_municipio" => $municipio,
                        "activo" => $activo
                    ]
                );
                $msgSuccess = "Ubicación ".$id." editada exitosamente.";
            } else if ($accion == 3) {
                DB::select("UPDATE public.tbl_ubicacion SET deleted_at = now() WHERE id = :id;", ["id" => $id]);
                $msgSuccess = "Ubicación ".$id." eliminada exitosamente.";
            }else{
                $msgError = "Acción inválida";
            }
                $ubicaciones_list = collect(\DB::select("SELECT 
                U.ID,
                U.DESCRIPCION_CASA,
                U.CLIENTE_HABITA,
                U.DIRECCION,
                U.FOTO,
                UPPER(P.NOMBRE) PAIS,
                D.NOMBRE DEPARTAMENTO,
                M.NOMBRE MUNICIPIO,
                U.COORDENADAS,
                U.MONTO,
                U.FECHA_COBRO,
                U.QR,
                U.ACTIVO,
                U.CASA_PROPIA,
                U.ID_PAIS,
                U.ID_DEPARTAMENTO,
                U.ID_MUNICIPIO,
                UPPER(P.NOMBRE)||', '||D.NOMBRE||', '||M.NOMBRE UBICACION
            FROM TBL_UBICACION U
                JOIN TBL_PAISES P ON P.id = U.ID_PAIS 
                JOIN TBL_DEPARTAMENTOS D ON D.ID = U.ID_DEPARTAMENTO
                JOIN TBL_MUNICIPIOS M ON M.ID = U.ID_MUNICIPIO
                    WHERE U.DELETED_AT IS NULL
                    AND P.DELETED_AT IS NULL
                    AND D.DELETED_AT IS NULL
                    AND M.DELETED_AT IS NULL
                    AND U.ID =:id", ["id" => $id]))->first();
        } catch (Exception $e) {
            $msgError = $e->getMessage();
        }


        return response()->json(['msgSuccess' => $msgSuccess, 'msgError' => $msgError, 'ubicaciones_list' => $ubicaciones_list]);
    }
}
