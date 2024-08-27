<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use DB;
use Session;
use Exception;
use File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;

class UbicacionesController extends Controller
{
    public function ver_ubicaciones()
    {
        $ubicaciones = DB::select("SELECT U.ID,
        U.DESCRIPCION_CASA,
        U.ID_CLIENTE,
        UPPER(TRIM(COALESCE(TRIM(C.PRIMER_NOMBRE) || ' ',
    
                                                        '') || COALESCE(TRIM(C.SEGUNDO_NOMBRE) || ' ',
    
                                                                                        '') || COALESCE(TRIM(C.PRIMER_APELLIDO) || ' ',
    
                                                                                                                        '') || COALESCE(TRIM(C.SEGUNDO_APELLIDO || ' '),
    
                                                                                                                                                        ''))) CLIENTE,
        U.CLIENTE_HABITA,
        U.DIRECCION,
        U.FOTO,
        UPPER(P.NOMBRE) PAIS,
        D.NOMBRE DEPARTAMENTO,
        M.NOMBRE MUNICIPIO,
        U.COORDENADAS,
        U.FECHA_COBRO,
        U.ACTIVO,
        U.CASA_PROPIA,
        U.ID_PAIS,
        U.ID_DEPARTAMENTO,
        U.ID_MUNICIPIO,
        UPPER(P.NOMBRE) || ', ' || D.NOMBRE || ', ' || M.NOMBRE UBICACION
    FROM TBL_UBICACION U
    JOIN TBL_PAISES P ON P.ID = U.ID_PAIS
    JOIN TBL_DEPARTAMENTOS D ON D.ID = U.ID_DEPARTAMENTO
    JOIN TBL_MUNICIPIOS M ON M.ID = U.ID_MUNICIPIO
    JOIN TBL_CLIENTES C ON C.ID = U.ID_CLIENTE
    WHERE U.DELETED_AT IS NULL
        AND P.DELETED_AT IS NULL
        AND D.DELETED_AT IS NULL
        AND M.DELETED_AT IS NULL
        AND C.DELETED_AT IS NULL
                ");

            $clientes = DB::SELECT("SELECT C.ID,
            UPPER(TRIM(COALESCE(TRIM(PRIMER_NOMBRE) || ' ',
        
                                                            '') || COALESCE(TRIM(SEGUNDO_NOMBRE) || ' ',
        
                                                                                            '') || COALESCE(TRIM(PRIMER_APELLIDO) || ' ',
        
                                                                                                                            '') || COALESCE(TRIM(SEGUNDO_APELLIDO || ' '),
        
                                                                                                                                                            ''))) CLIENTE
        FROM TBL_CLIENTES C
        WHERE C.DELETED_AT IS NULL
        ORDER BY 2");    
            
            $paises = DB::select('SELECT
            ID,
            NOMBRE
            FROM
            PUBLIC.TBL_PAISES
            WHERE
            DELETED_AT IS NULL
            AND ID = 102
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
            ->with('departamentos', $departamentos)
            ->with('clientes', $clientes)
            ;
    }

    public function guardar_ubicaciones(Request $request)
    {
        $accion=$request->accion;
        $id=$request->id;
        $descripcion_casa=$request->descripcion_casa;
        $direccion=$request->direccion;
        $cliente_habita=$request->cliente_habita;
        //$fecha_cobro=$request->fecha_cobro;
        $pais=$request->pais;
        $coordenadas=$request->coordenadas;
        $casa_propia=$request->casa_propia;
        $departamento=$request->departamento;
        $cliente=$request->cliente;
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
                    id_cliente,descripcion_casa, direccion, cliente_habita, id_pais, coordenadas, casa_propia, id_departamento, id_municipio, activo)
                    VALUES (:id_cliente, :descripcion_casa, :direccion,  :cliente_habita, :pais, :coordenadas, :casa_propia, :id_departamento, :id_municipio, :activo)
                    returning id;",
                    [
                        "id_cliente" => $cliente,
                        "descripcion_casa" => $descripcion_casa,
                        "direccion" => $direccion,
                        "cliente_habita" => $cliente_habita,
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
                    SET id_cliente = :id_cliente ,descripcion_casa=:descripcion_casa, direccion=:direccion, cliente_habita=:cliente_habita, 
                    id_pais=:pais, coordenadas=:coordenadas, casa_propia=:casa_propia, 
                    id_departamento=:id_departamento, id_municipio=:id_municipio, activo=:activo, updated_at=now()
                    WHERE id = :id;",
                    [
                        "id" => $id,
                        "id_cliente" => $cliente,
                        "descripcion_casa" => $descripcion_casa,
                        "direccion" => $direccion,
                        "cliente_habita" => $cliente_habita,
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
                $ubicaciones_list = collect(\DB::select("SELECT U.ID,
                U.DESCRIPCION_CASA,
                U.ID_CLIENTE,
                UPPER(TRIM(COALESCE(TRIM(C.PRIMER_NOMBRE) || ' ',
            
                                                                '') || COALESCE(TRIM(C.SEGUNDO_NOMBRE) || ' ',
            
                                                                                                '') || COALESCE(TRIM(C.PRIMER_APELLIDO) || ' ',
            
                                                                                                                                '') || COALESCE(TRIM(C.SEGUNDO_APELLIDO || ' '),
            
                                                                                                                                                                ''))) CLIENTE,
                U.CLIENTE_HABITA,
                U.DIRECCION,
                U.FOTO,
                UPPER(P.NOMBRE) PAIS,
                D.NOMBRE DEPARTAMENTO,
                M.NOMBRE MUNICIPIO,
                U.COORDENADAS,
                U.FECHA_COBRO,
                U.ACTIVO,
                U.CASA_PROPIA,
                U.ID_PAIS,
                U.ID_DEPARTAMENTO,
                U.ID_MUNICIPIO,
                UPPER(P.NOMBRE) || ', ' || D.NOMBRE || ', ' || M.NOMBRE UBICACION
            FROM TBL_UBICACION U
            JOIN TBL_PAISES P ON P.ID = U.ID_PAIS
            JOIN TBL_DEPARTAMENTOS D ON D.ID = U.ID_DEPARTAMENTO
            JOIN TBL_MUNICIPIOS M ON M.ID = U.ID_MUNICIPIO
            JOIN TBL_CLIENTES C ON C.ID = U.ID_CLIENTE
            WHERE U.DELETED_AT IS NULL
                AND P.DELETED_AT IS NULL
                AND D.DELETED_AT IS NULL
                AND M.DELETED_AT IS NULL
                AND C.DELETED_AT IS NULL
                    AND U.ID =:id", ["id" => $id]))->first();
        } catch (Exception $e) {
            $msgError = $e->getMessage();
        }


        return response()->json(['msgSuccess' => $msgSuccess, 'msgError' => $msgError, 'ubicaciones_list' => $ubicaciones_list]);
    }

    public function guardar_foto_ubicacion(Request $request){
        $id_ubicacion = $request->id_ubicacion;
        if($request->hasFile("profile_picture")){
            $file=$request->file("profile_picture");
            
            // $nombre = "examen_".time().".".$file->guessExtension();
            $nombre_archivo = "foto_ubicacion_".$id_ubicacion.".".$file->guessExtension();

            $ruta = public_path("img\\ubicaciones\\".$nombre_archivo);
            //$ruta = $request->file('profile_picture')->store('build/assets/img_empleados', 'public');
            //$ruta = "/home/shfnuaro/public_html/pdf/examenes_laboratorio/".$nombre_archivo;

            // if($file->guessExtension()=="jpeg"){
            copy($file, $ruta);
                        
                DB::select("UPDATE PUBLIC.tbl_ubicacion
                    SET
                        FOTO = :nombre_archivo,
                        UPDATED_AT = NOW()
                    WHERE
                        ID = :id_ubicacion;
                ", ["id_ubicacion" => $id_ubicacion, "nombre_archivo" => $nombre_archivo]);
            // }else{
            //     dd("NO ES UNA IMAGEN");
            // }

        }
        return Redirect::back()->withHeaders([
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }

}
