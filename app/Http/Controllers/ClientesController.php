<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use DB;
use Session;
use Exception;
use Yajra\DataTables\DataTables;

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

    public function getClientesData(){

        $clientesQuery= DB::SELECT("
        SELECT
            TC.ID,
            TC.IDENTIDAD,
            TRIM(
                COALESCE(TRIM(TC.PRIMER_NOMBRE)||' ','')||
                COALESCE(TRIM(TC.SEGUNDO_NOMBRE)||' ','')||
                COALESCE(TRIM(TC.PRIMER_APELLIDO)||' ','')||
                COALESCE(TRIM(TC.SEGUNDO_APELLIDO||' '),'')
            ) as cliente,
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
            TC.CREATED_AT,
            TD.NOMBRE||', '||TM.NOMBRE||', '||TC.DOMICILIO as domicilio_completa
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
            TC.SEGUNDO_APELLIDO
        ");
                                         
        return Datatables($clientesQuery)                
            ->addColumn('opciones', '
            <button class="transition duration-200 border shadow-sm inline-flex items-center justify-center rounded-md font-medium cursor-pointer focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus-visible:outline-none dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&amp;:hover:not(:disabled)]:bg-opacity-90 [&amp;:hover:not(:disabled)]:border-opacity-90 [&amp;:not(button)]:text-center disabled:opacity-70 disabled:cursor-not-allowed text-xs py-1.5 px-2 bg-warning border-warning text-slate-900 dark:border-warning editar mb-2 mr-1 editar"
                data-id="{{$id}}"
                data-primer_nombre="{{$primer_nombre}}" 
                data-segundo_nombre="{{$segundo_nombre}}" 
                data-primer_apellido="{{$primer_apellido}}" 
                data-segundo_apellido="{{$segundo_apellido}}" 
                data-identidad="{{$identidad}}"
                data-celular="{{$celular}}"
                data-correo_electronico="{{$correo_electronico}}"
                data-genero="{{$id_genero}}"
                data-departamento="{{$id_departamento}}"
                data-municipio="{{$id_municipio}}"
                data-domicilio="{{$domicilio}}"
            ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="edit" data-lucide="edit" class="lucide lucide-edit stroke-1.5 h-4 w-4"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z">
            </path></svg></button>
            <button class="transition duration-200 border shadow-sm inline-flex items-center justify-center rounded-md font-medium cursor-pointer focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus-visible:outline-none dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&amp;:hover:not(:disabled)]:bg-opacity-90 [&amp;:hover:not(:disabled)]:border-opacity-90 [&amp;:not(button)]:text-center disabled:opacity-70 disabled:cursor-not-allowed text-xs py-1.5 px-2 bg-danger border-danger text-white dark:border-danger eliminar mb-2 mr-1 eliminar"
                data-id="{{$id}}"
                data-primer_nombre="{{$primer_nombre}}" 
                data-segundo_nombre="{{$segundo_nombre}}" 
                data-primer_apellido="{{$primer_apellido}}" 
                data-segundo_apellido="{{$segundo_apellido}}" 
                data-identidad="{{$identidad}}"
                data-celular="{{$celular}}"
                data-correo_electronico="{{$correo_electronico}}"
                data-genero="{{$id_genero}}"
                data-departamento="{{$id_departamento}}"
                data-municipio="{{$id_municipio}}"
                data-domicilio="{{$domicilio}}"
            ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="trash" data-lucide="trash" class="lucide lucide-trash stroke-1.5 h-4 w-4"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path></svg></button>
            ')                                          
            ->rawColumns(['opciones'])
            ->make(true);
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
