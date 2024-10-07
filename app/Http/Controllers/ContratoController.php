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
            tc.deleted_at,
            to_char(tc.monto,'LFM999,999,999.00') monto
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
        $listClientes=DB::SELECT("
        select 
        c.id,
        TRIM(
            COALESCE(TRIM(c.primer_nombre)||' ','')||
            COALESCE(TRIM(c.segundo_nombre)||' ','')||
            COALESCE(TRIM(c.primer_apellido)||' ','')||
            COALESCE(TRIM(c.segundo_apellido||' '),'')
            ) as cliente
        from 
            tbl_clientes c
        where 
            c.deleted_at is null
        ");

        //
        $listServicios = DB::SELECT("
        select
            s.id,
            ts.nombre as tipo,
            s.descripcion as servicio
        from tbl_servicio s
        join tbl_tipo_servicio ts on s.id_tipo = ts.id
        where s.deleted_at is null
            and ts.deleted_at is null
        ");

        return view("juntaagua.contrato.viewCrearContrato")
            ->with("clientes", $listClientes)
            ->with("servicios", $listServicios);

    }

    public function guardar(Request $request){
        
        //Guardar el contrato

        //Validacion datos 
        $request->validate([
            'id_cliente' => 'required|integer',
            'id_ubicacion' => 'required|integer',
            'id_servicio' => 'required|integer',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'monto' => 'required|numeric',
        ], [], [
            'id_cliente' => 'cliente',
            'id_ubicacion' => 'ubicación',
            'id_servicio' => 'servicio',
            'fecha_inicio' => 'fecha de inicio',
            'fecha_fin' => 'fecha de fin',
            'monto' => 'monto',
        ]);

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
        $monto = $request->monto;
        //dd($request);
        try{
            $saveContrato = collect(\DB::SELECT("
            INSERT INTO public.tbl_contrato(
                id_cliente, id_ubicacion, id_servicio, fecha_inicio, fecha_fin, created_at, updated_at, monto)
            VALUES (:id_cliente, :id_ubicacion, :id_servicio, :fecha_inicio, :fecha_fin, now(), now(), :monto)
            returning id;
            ",["id_cliente"=>$id_cliente, "id_ubicacion"=>$id_ubicacion, "id_servicio"=>$id_servicio, "fecha_inicio"=>$fecha_inicio, "fecha_fin"=>$fecha_fin, "monto"=>$monto]))->first();

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

        $listarContrato = collect(\DB::select("
        SELECT
            tc.id,
            tc.id_cliente,
            tc.id_ubicacion,
            tu.descripcion_casa,
            tc.id_servicio,
            tc.fecha_inicio::date,
            tc.fecha_fin::date,
            tc.monto
        FROM public.tbl_contrato tc
        JOIN tbl_clientes c on tc.id_cliente = c.id
        JOIN tbl_ubicacion tu on tc.id_ubicacion = tu.id
        JOIN tbl_servicio ts on tc.id_servicio = ts.id
        WHERE
            tc.deleted_at is null
            and c.deleted_at is null
            and tu.deleted_at is null
            and ts.deleted_at is null
            and tc.id = :id_contrato",["id_contrato" =>$id_contrato]))->first();

            $listClientes=DB::SELECT("
            select 
            c.id,
            TRIM(
                COALESCE(TRIM(c.primer_nombre)||' ','')||
                COALESCE(TRIM(c.segundo_nombre)||' ','')||
                COALESCE(TRIM(c.primer_apellido)||' ','')||
                COALESCE(TRIM(c.segundo_apellido||' '),'')
                ) as cliente
            from 
                tbl_clientes c
            where 
                c.deleted_at is null
            ");
    
            //
            $listServicios = DB::SELECT("
            select
                s.id,
                ts.nombre as tipo,
                s.descripcion as servicio
            from tbl_servicio s
            join tbl_tipo_servicio ts on s.id_tipo = ts.id
            where s.deleted_at is null
                and ts.deleted_at is null
            ");
    
        return view("juntaagua.contrato.viewEditarContrato")
            ->with("listarContrato",$listarContrato)
            ->with("clientes", $listClientes)
            ->with("servicios", $listServicios);
    }

    public function update(Request $request){
        //Actualiza el contrato seleccionado

        //Validacion datos 
        $request->validate([
            'id_cliente' => 'required|integer',
            'id_ubicacion' => 'required|integer',
            'id_servicio' => 'required|integer',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'monto' => 'required|numeric',
        ], [], [
            'id_cliente' => 'cliente',
            'id_ubicacion' => 'ubicación',
            'id_servicio' => 'servicio',
            'fecha_inicio' => 'fecha de inicio',
            'fecha_fin' => 'fecha de fin',
            'monto' => 'monto',
        ]);

        //declarar variables
        $msgError = null;
        $msgSuccess = null;
        $msgWarning = null;

        $id = $request->id_contrato;
        $id_cliente = $request->id_cliente;
        $id_ubicacion = $request->id_ubicacion;
        $id_servicio = $request->id_servicio;
        $fecha_inicio = $request->fecha_inicio;
        $fecha_fin = $request->fecha_fin;
        $monto = $request->monto;
        //dd($request);
        try{
            $editContrato = DB::SELECT("
            UPDATE public.tbl_contrato
                SET
                    id_cliente=:id_cliente,
                    id_ubicacion=:id_ubicacion,
                    id_servicio=:id_servicio,
                    fecha_inicio=:fecha_inicio,
                    fecha_fin=:fecha_fin,
                    updated_at=now(),
                    monto =:monto
            WHERE
                id=:id_contrato;
            ",["id_contrato"=>$id,"id_cliente"=>$id_cliente, "id_ubicacion"=>$id_ubicacion, "id_servicio"=>$id_servicio, "fecha_inicio"=>$fecha_inicio, "fecha_fin"=>$fecha_fin, "monto"=>$monto]);


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
                id=:id_contrato;
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

    public function getUbicaciones($id_cliente)
    {
        $ubicaciones = DB::SELECT("
        select * from tbl_ubicacion where id_cliente =:id_cliente and deleted_at is null
        ", ["id_cliente"=>$id_cliente]);
        return response()->json($ubicaciones);
    }
    
    public function ver_tbl_movimientos( $idContrato ) {
    $tipo_movimiento_list = DB::select("select id, nombre as movimiento from public.tbl_tipo_movimiento where deleted_at is null");
    $tbl_movimientos_list = DB::select("
    select tm.id, tm.fecha_hora, tm.concepto, tm.debe, tm.haber, tm.id_tipo_movimiento, ttm.nombre as tipo_movimiento, tm.id_contrato, tm.id_cobrador, u.name as cobrador 
   from public.tbl_movimientos tm 
   join public.tbl_clientes ct on ct.id = tm.id_cliente 
   join public.tbl_contrato tc on tc.id = tm.id_contrato 
   join public.tbl_tipo_movimiento ttm on ttm.id = tm.id_tipo_movimiento 
   left join public.users u on u.id = tm.id_cobrador
   where tm.deleted_at is null
   and tm.id_contrato = :id_contrato
   order by 1 desc
   ",[
       'id_contrato'=>$idContrato
   ]);
    
    $saldos = DB::SELECT("with saldos as (
            select TRIM(
                COALESCE(TRIM(tc.primer_nombre)||' ','')||
                COALESCE(TRIM(tc.segundo_nombre)||' ','')||
                COALESCE(TRIM(tc.primer_apellido)||' ','')||
                COALESCE(TRIM(tc.segundo_apellido||' '),'')
            ) as nombre_cliente,
            sum( coalesce( tm.debe, 0 ) ) as debe, sum( coalesce(tm.haber, 0) ) as haber, tm.id_cliente,
            case when sum( coalesce( tm.debe, 0 ) ) > sum( coalesce(tm.haber, 0) ) then 'DEUDA' 
                when sum( coalesce( tm.debe, 0 ) ) < sum( coalesce(tm.haber, 0) ) then 'SALDO A FAVOR' 
                when sum( coalesce( tm.debe, 0 ) ) = sum( coalesce(tm.haber, 0) ) then 'SOLVENTE'
            else '' end estado_cuenta,
            abs( sum( coalesce( tm.debe, 0 ) ) - sum( coalesce(tm.haber, 0) ) ) as total ,
            tm.id_contrato
            from public.tbl_movimientos tm
            join public.tbl_clientes tc on tc.id = tm.id_cliente
            where tm.deleted_at is null            
            and tm.id_contrato = :id_contrato
            group by 1,4,7
        ) 
        select * from saldos",[           
            "id_contrato"=>$idContrato
        ]);
    
   return view("juntaagua.movimientos.movimientos")
            ->with("tbl_movimientos_list", $tbl_movimientos_list)
            ->with("tipo_movimiento_list", $tipo_movimiento_list)
            ->with("saldos", $saldos)
            ->with("id_contrato", $idContrato)
   ;
   
   }

   public function guardar_tbl_movimientos(Request $request) {
    $id=$request->id;
    $id_contrato=$request->id_contrato;
    $fecha_hora=$request->fecha_hora;
    $concepto=$request->concepto;
    $debe=$request->debe;
    $haber=$request->haber;
    $id_tipo_movimiento=$request->id_tipo_movimiento;
    $msgError=null;
    $msgSuccess=null;
    $accion=$request->accion;
    $tbl_movimientos_list=null;
    $resultado=null;
    $id_cobrador= Auth::user()->id;
    $id_haber = 2;
    $msgAlert=null;
    $saldos=null;

    
    if($id==null && $accion==2){
        $accion=1;
    }
    try{ 

        if($accion==1){
            $sql_tbl_movimientos = DB::select("insert INTO public.tbl_movimientos (concepto,debe,fecha_hora,haber,id_tipo_movimiento, id_cobrador, created_at) 
                values (:concepto,:debe,:fecha_hora,:haber,:id_tipo_movimiento, :id_cobrador , now() )
            RETURNING  id
            ", ['concepto'=>$concepto,'debe'=>$debe,'fecha_hora'=>$fecha_hora,'haber'=>$haber,'id_tipo_movimiento'=>$id_tipo_movimiento,'id_cobrador'=>$id_cobrador
            ]
            );
            foreach($sql_tbl_movimientos as $r){
                $id=$r->id;
            }
            $msgSuccess="Registro creado con el código: ".$id;
        }else if($accion==2){
            $sql_tbl_movimientos = DB::select("update public.tbl_movimientos set  updated_at = now(),
            concepto=:concepto,debe=:debe,fecha_hora=:fecha_hora,haber=:haber,id_tipo_movimiento=:id_tipo_movimiento, id_cobrador=:id_cobrador
            where id=:id
            "
            , ['concepto'=>$concepto,'debe'=>$debe,'fecha_hora'=>$fecha_hora,'haber'=>$haber,'id'=>$id,'id_tipo_movimiento'=>$id_tipo_movimiento,'id_cobrador'=>$id_cobrador]
            );
            $msgSuccess="Registro ".$id." actualizado";

        }else if($accion==3){

            $sql_tbl_movimientos = DB::select("update public.tbl_movimientos set deleted_at=now() where
            id=:id
            "
            , ['id'=>$id]
            );
            $msgSuccess="Registro ".$id." eliminado";

        }else if($accion == 4){
            
            $sql_tbl_movimientos = db::select("insert into tbl_movimientos(
                fecha_hora,
                concepto,
                haber,
                id_tipo_movimiento,
                id_cliente,
                id_contrato,
                created_at,
                id_cobrador
            )
            select
                now() as fecha_hora,
                concat('PAGO DE ', upper(cma.nombre_espanol),' - ', ts.descripcion  )	concepto,
                :haber as haber,
                :id_haber as id_tipo_movimiento,
                tc.id_cliente,
                tc.id as id_contrato,
                now() as created_at,
                :id_cobrador as id_cobrador
            from
                public.tbl_contrato tc
                join public.tbl_servicio ts on ts.id = tc.id_servicio	
                join public.cat_meses_anio cma on cma.id_mes_bd::int = to_char( current_date::date,'MM')::int
            where
                tc.deleted_at is null    
                and tc.id = :id_contrato
                RETURNING id
                ",[
                        'id_contrato'=>$id_contrato,
                        'id_haber'=>$id_haber,
                        'haber'=>$haber,
                        'id_cobrador'=>$id_cobrador
                    ]);
            
            foreach($sql_tbl_movimientos as $rt){
                $id=$rt->id;
            }
            $msgSuccess="Registro de pago creado: ".$id;
            
        }else if ($accion == 5){
            $sql_tbl_movimientos = collect(db::select("select cast(s.resultado as bool ), s.id_movimiento from public.f_registro_cobro_cliente_mes( :id_contrato ) as s(resultado)",[
                'id_contrato'=>$id_contrato
            ]))->first();
            
            $resultado = isset($sql_tbl_movimientos->resultado) ? $sql_tbl_movimientos->resultado : null;
            $id = $sql_tbl_movimientos->id_movimiento;
            if($resultado){
                $msgSuccess="Registro de cobro creado: ".$sql_tbl_movimientos->id_movimiento;
            }else{
                $msgAlert="¡Ya existe un cobro para el mes actual!";
            }
                        
        }else{
            $msgError="Accion invalida";
        }
        if($msgError==null){
            $tbl_movimientos_list = DB::select("select * from (
            select tm.id, tm.fecha_hora, tm.concepto, tm.debe, tm.haber, tm.id_tipo_movimiento, ttm.nombre as tipo_movimiento, tm.id_contrato, tm.id_cobrador, u.name as cobrador 
            from public.tbl_movimientos tm 
            join public.tbl_clientes ct on ct.id = tm.id_cliente 
            join public.tbl_contrato tc on tc.id = tm.id_contrato 
            join public.tbl_tipo_movimiento ttm on ttm.id = tm.id_tipo_movimiento 
            left join public.users u on u.id = tm.id_cobrador
            where tm.deleted_at is null
            and tm.id_contrato = :id_contrato
            order by 1 desc

            ) x where id=:id
            ",[
               "id"=>$id,
                "id_contrato"=>$id_contrato
            ]);
        }

        $saldos = DB::SELECT("with saldos as (
            select TRIM(
                COALESCE(TRIM(tc.primer_nombre)||' ','')||
                COALESCE(TRIM(tc.segundo_nombre)||' ','')||
                COALESCE(TRIM(tc.primer_apellido)||' ','')||
                COALESCE(TRIM(tc.segundo_apellido||' '),'')
            ) as nombre_cliente,
            sum( coalesce( tm.debe, 0 ) ) as debe, sum( coalesce(tm.haber, 0) ) as haber, tm.id_cliente,
            case when sum( coalesce( tm.debe, 0 ) ) > sum( coalesce(tm.haber, 0) ) then 'DEUDA' 
                when sum( coalesce( tm.debe, 0 ) ) < sum( coalesce(tm.haber, 0) ) then 'SALDO A FAVOR' 
                when sum( coalesce( tm.debe, 0 ) ) = sum( coalesce(tm.haber, 0) ) then 'SOLVENTE'
            else '' end estado_cuenta,
            abs( sum( coalesce( tm.debe, 0 ) ) - sum( coalesce(tm.haber, 0) ) ) as total ,
            tm.id_contrato
            from public.tbl_movimientos tm
            join public.tbl_clientes tc on tc.id = tm.id_cliente
            where tm.deleted_at is null            
            and tm.id_contrato = :id_contrato
            group by 1,4,7
        ) 
        select * from saldos",[           
            "id_contrato"=>$id_contrato
        ]);


    
    }catch (Exception $e){
        $msgError=$e->getMessage();
    }    
   return response()->json(["msgSuccess" => $msgSuccess,"msgError"=>$msgError,"msgAlert" => $msgAlert, 
   "tbl_movimientos_list"=>$tbl_movimientos_list, "saldos"=>$saldos
]);
   }



}
