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
        $clientes = DB::select("SELECT
                TC.ID,
                TC.IDENTIDAD,
                TC.PRIMER_NOMBRE,
                COALESCE(TC.SEGUNDO_NOMBRE, '') SEGUNDO_NOMBRE,
                TC.PRIMER_APELLIDO,
                COALESCE(TC.SEGUNDO_APELLIDO, '') SEGUNDO_APELLIDO,
                TC.ID_GENERO,
                TG.NOMBRE GENERO,
                TC.CELULAR,
                TC.DOMICILIO,
                TC.ID_DEPARTAMENTO,
                TD.NOMBRE DEPARTAMENTO,
                TC.ID_MUNICIPIO,
                TM.NOMBRE MUNICIPIO,
                TC.CORREO_ELECTRONICO,
                TC.CREATED_AT
            FROM
                PUBLIC.TBL_CLIENTES TC
                JOIN PUBLIC.TBL_GENEROS TG ON TC.ID_GENERO = TG.ID
                JOIN PUBLIC.TBL_DEPARTAMENTOS TD ON TC.ID_DEPARTAMENTO = TD.ID
                JOIN PUBLIC.TBL_MUNICIPIOS TM ON TC.ID_MUNICIPIO = TM.ID
            WHERE
                TC.DELETED_AT IS NULL
            ORDER BY
                TC.PRIMER_NOMBRE,
                TC.SEGUNDO_NOMBRE,
                TC.PRIMER_APELLIDO,
                TC.SEGUNDO_APELLIDO");

        $generos = DB::select('SELECT
                ID,
                NOMBRE
            FROM
                PUBLIC.TBL_GENEROS
            WHERE
                DELETED_AT IS NULL');

        $departamentos = DB::select('SELECT
                ID,
                NOMBRE
            FROM
                PUBLIC.TBL_DEPARTAMENTOS
            WHERE
                DELETED_AT IS NULL
            ORDER BY
                NOMBRE');

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
                    "celular" => $celular, "domicilio" => $domicilio, "id_departamento" => $departamento, 
                    "id_municipio" => $municipio, "correo_electronico" => $correo]))->first();

                $id = $cliente->id;
                $msgSuccess = "Cliente ".$id." registrado exitosamente.";
            }else if ($accion == 2) {
                DB::select("UPDATE public.tbl_clientes
                    SET identidad=:identidad, primer_nombre=:primer_nombre, segundo_nombre=:segundo_nombre, primer_apellido=:primer_apellido, 
                    segundo_apellido=:segundo_apellido, id_genero=:id_genero, celular=:celular, domicilio=:domicilio, 
                    id_departamento=:id_departamento, id_municipio=:id_municipio, correo_electronico=:correo_electronico, updated_at=now()
                    WHERE id = :id;",
                    ["id" => $id, "identidad" => $identidad, "primer_nombre" => $primer_nombre, "segundo_nombre" => $segundo_nombre, 
                    "primer_apellido" => $primer_apellido, "segundo_apellido" => $segundo_apellido, "id_genero" => $genero, 
                    "celular" => $celular, "domicilio" => $domicilio, "id_departamento" => $departamento, 
                    "id_municipio" => $municipio, "correo_electronico" => $correo]);
                $msgSuccess = "Cliente ".$id." editado exitosamente.";
            }else if ($accion == 3) {
                DB::select("UPDATE public.tbl_clientes SET deleted_at = now() WHERE id = :id;", ["id" => $id]);
                $msgSuccess = "Cliente ".$id." eliminado exitosamente.";
            }else{
                $msgError = "Acción inválida";
            }
                $clientes_list = collect(\DB::select("SELECT
                        TC.ID,
                        TC.IDENTIDAD,
                        TC.PRIMER_NOMBRE,
                        COALESCE(TC.SEGUNDO_NOMBRE, '') SEGUNDO_NOMBRE,
                        TC.PRIMER_APELLIDO,
                        COALESCE(TC.SEGUNDO_APELLIDO, '') SEGUNDO_APELLIDO,
                        TC.ID_GENERO,
                        TG.NOMBRE GENERO,
                        TC.CELULAR,
                        TC.DOMICILIO,
                        TC.ID_DEPARTAMENTO,
                        TD.NOMBRE DEPARTAMENTO,
                        TC.ID_MUNICIPIO,
                        TM.NOMBRE MUNICIPIO,
                        TC.CORREO_ELECTRONICO,
                        TC.CREATED_AT
                    FROM
                        PUBLIC.TBL_CLIENTES TC
                        JOIN PUBLIC.TBL_GENEROS TG ON TC.ID_GENERO = TG.ID
                        JOIN PUBLIC.TBL_DEPARTAMENTOS TD ON TC.ID_DEPARTAMENTO = TD.ID
                        JOIN PUBLIC.TBL_MUNICIPIOS TM ON TC.ID_MUNICIPIO = TM.ID
                    WHERE
                        TC.DELETED_AT IS NULL
                        AND TC.ID =:id
                    ORDER BY
                        TC.PRIMER_NOMBRE,
                        TC.SEGUNDO_NOMBRE,
                        TC.PRIMER_APELLIDO,
                        TC.SEGUNDO_APELLIDO;", ["id" => $id]))->first();
        } catch (Exception $e) {
            $msgError = $e->getMessage();
        }

        return response()->json(['msgSuccess' => $msgSuccess, 'msgError' => $msgError, 'clientes_list' => $clientes_list]);
    }
    
    public function ver_balance_general() {
        
        $sql_balance_general = DB::SELECT("with saldos as (
            select TRIM(
                    COALESCE(TRIM(tc.primer_nombre)||' ','')||
                    COALESCE(TRIM(tc.segundo_nombre)||' ','')||
                    COALESCE(TRIM(tc.primer_apellido)||' ','')||
                    COALESCE(TRIM(tc.segundo_apellido||' '),'')
            ) as nombre_cliente,
            sum( coalesce( tm.debe, 0 ) ) as debe, sum( coalesce(tm.haber, 0) ) as haber, tm.id_cliente,
            case when sum( coalesce( tm.debe, 0 ) ) > sum( coalesce(tm.haber, 0) ) then 'DEUDA' else 'SOLVENTE' end estado_cuenta,
            tm.id_contrato,
            sum( coalesce( tm.debe, 0 ) ) - sum( coalesce(tm.haber, 0) ) as total
            from public.tbl_movimientos tm
            join public.tbl_clientes tc on tc.id = tm.id_cliente
            where tm.deleted_at is null
            group by 1,4,6
        ) 
        select * from saldos 
        where estado_cuenta = 'DEUDA'");
        
        return view('juntaagua.balance')
                ->with('sql_balance_general',$sql_balance_general);
        
    }
}
