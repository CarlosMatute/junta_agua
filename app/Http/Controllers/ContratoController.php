<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use DB;
use Session;
use Exception;
use Illuminate\Support\Facades\Auth;

class ContratoController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    //Funciones de Modulo de Contratos

    public function index(){
        //Obtener lsita de contratos
        $listarContratos = DB::select("
        SELECT
            tc.id,
            tc.id_cliente,
            TRIM(
                COALESCE(TRIM(c.primer_nombre)||' ','')||
                COALESCE(TRIM(c.segundo_nombre)||' ','')||
                COALESCE(TRIM(c.primer_apellido)||' ','')||
                COALESCE(TRIM(c.segundo_apellido||' '),'')

            ) as nombre_cliente,
            tc.id_ubicacion,
            tu.descripcion_casa,
            tc.id_servicio,
            ts.descripcion as servicio,
            tc.fecha_inicio,
            tc.fecha_fin,
            tc.created_at,
            tc.updated_at,
            tc.deleted_at
        FROM public.tbl_contrato tc
        JOIN tbl_clientes c on tc.id_cliente = c.id
        JOIN tbl_ubicacion tu on tc.id_ubicacion = tu.id
        JOIN tbl_servicio ts on tc.id_servicio = ts.id
        WHERE
            tc.deleted_at is null
            and c.deleted_at is null
            and tu.deleted_at is null
            and ts.deleted_at is null");

        return view('juntaagua.contrato.viewContratos')
                ->with('listarContratos', $listarContratos);
    }

    public function crear(){
        //Redirige al formulario crear contrato

        return view("juntaagua.contrato.viewCrearContrato");

    }

    public function guardar(Request $request){
        //Guardar el contrato

        //declarar variables
        $msgError = null;
        $msgSuccess = null;
        $msgWarning = null;

        $id = null;
        $id_cliente = $request->id_cliente;
        $id_ubicacion = $request->id_ubicacion;
        $id_servicio = $request->id_servicio;
        $fecha_inicio = $request->fecha_inicio;
        $fecha_fin = $request->fecha_fin;

        try{
            $saveContrato = collect(\DB::SELECT("
            INSERT INTO public.tbl_contrato(
                id_cliente, id_ubicacion, id_servicio, fecha_inicio, fecha_fin, created_at, updated_at)
            VALUES (:id_cliente, :id_ubicacion, :id_servicio, :fecha_inicio, :fecha_fin, now(), now())
            returning id;
            ",["id_cliente"=>$id_cliente, "id_ubicacion"=>$id_ubicacion, "id_servicio"=>$id_servicio, "fecha_inicio"=>$fecha_inicio, "fecha_fin"=>$fecha_fin]))->first();

            $id = $saveContrato->id;
            $msgSuccess = "¡Excelente!, El contrato N° ".$id." ha sido creado correctamente.";
        }catch(Exception $e){
            $msgError = $e->getMessage();
        }

        return redirect()
            ->route('editar_contrato',['id'=>$id])
            ->with('msgError', $msgError)
            ->with('msgSuccess',$msgSuccess)
            ->with('msgWarning',$msgWarning);

    }

    public function editar(Request $request){
        //Redirige al formulario editar contrato

        //declarar variables
        $id_contrato = $request->id;

        $listarContrato = DB::select("
        SELECT
            tc.id,
            tc.id_cliente,
            TRIM(
                COALESCE(TRIM(c.primer_nombre)||' ','')||
                COALESCE(TRIM(c.segundo_nombre)||' ','')||
                COALESCE(TRIM(c.primer_apellido)||' ','')||
                COALESCE(TRIM(c.segundo_apellido||' '),'')

            ) as nombre_cliente,
            tc.id_ubicacion,
            tu.descripcion_casa,
            tc.id_servicio,
            ts.descripcion as servicio,
            tc.fecha_inicio,
            tc.fecha_fin,
            tc.created_at,
            tc.updated_at,
            tc.deleted_at
        FROM public.tbl_contrato tc
        JOIN tbl_clientes c on tc.id_cliente = c.id
        JOIN tbl_ubicacion tu on tc.id_ubicacion = tu.id
        JOIN tbl_servicio ts on tc.id_servicio = ts.id
        WHERE
            tc.deleted_at is null
            and c.deleted_at is null
            and tu.deleted_at is null
            and ts.deleted_at is null
            and tc.id = :id_contrato",["id_contrato" =>$id_contrato]);

        return view("juntaagua.contrato.viewEditarContrato")
            ->with("listarContrato",$listarContrato);
    }

    public function update(Request $request){
        //Actualiza el contrato seleccionado

        //declarar variables
        $msgError = null;
        $msgSuccess = null;
        $msgWarning = null;

        $id = $request->id;
        $id_cliente = $request->id_cliente;
        $id_ubicacion = $request->id_ubicacion;
        $id_servicio = $request->id_servicio;
        $fecha_inicio = $request->fecha_inicio;
        $fecha_fin = $request->fecha_fin;

        try{
            $editContrato = DB::SELECT("
            UPDATE public.tbl_contrato
                SET
                    id_cliente=:id_cliente,
                    id_ubicacion=:id_ubicacion,
                    id_servicio=:id_servicio,
                    fecha_inicio=:fecha_inicio,
                    fecha_fin=:fecha_fin,
                    updated_at=now()
            WHERE
                id=id_contrato;
            ",["id_contrato"=>$id,"id_cliente"=>$id_cliente, "id_ubicacion"=>$id_ubicacion, "id_servicio"=>$id_servicio, "fecha_inicio"=>$fecha_inicio, "fecha_fin"=>$fecha_fin]);


            $msgSuccess = "¡Excelente!, El contrato N° ".$id." ha sido actualizado correctamente.";
        }catch(Exception $e){
            $msgError = $e->getMessage();
        }

        return redirect()
            ->route('editar_contrato',['id'=>$id])
            ->with('msgError', $msgError)
            ->with('msgSuccess',$msgSuccess)
            ->with('msgWarning',$msgWarning);
    }

    public function eliminar(Request $request){
        //Eliminar el contrato seleccionado
        //declarar variables
        $msgError = null;
        $msgSuccess = null;
        $msgWarning = null;

        $id = $request->id;


        try{
            $editContrato = DB::SELECT("
            UPDATE public.tbl_contrato
                SET
                    deleted_at=now()
            WHERE
                id=id_contrato;
            ",["id_contrato"=>$id]);


            $msgSuccess = "¡Excelente!, El contrato N° ".$id." ha sido eliminado correctamente.";
        }catch(Exception $e){
            $msgError = $e->getMessage();
        }

        return redirect()
            ->route('ver_contrato')
            ->with('msgError', $msgError)
            ->with('msgSuccess',$msgSuccess)
            ->with('msgWarning',$msgWarning);
    }
}
