<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use DB;
use Session;
use Exception;

class EmpleadosController extends Controller
{
    public function ver_per_empleado() {
        $pais_list = DB::select("select id, nombre as pais from public.tbl_paises where deleted_at is null");
        $per_empleado_list = DB::select("
        select pe.id, pe.primer_nombre, pe.segundo_nombre, pe.primer_apellido, pe.segundo_apellido, pe.identidad,
       pe.telefono, pe.id_pais, tp.nombre as pais, pe.domicilio, pe.id_usuario, pe.correo 
       from public.per_empleado pe 
       join public.tbl_paises tp on tp.id = pe.id_pais
       join public.users uu on uu.id = pe.id_usuario
       where pe.deleted_at is null
       order by 1 desc
       
       "
       );
       return view("empleado.empleados")->with("per_empleado_list", $per_empleado_list)
       ->with("pais_list", $pais_list)
       ;
       }
       
       public function guardar_per_empleado(Request $request) {
       $id=$request->id;
       $primer_nombre=$request->primer_nombre;
       $segundo_nombre=$request->segundo_nombre;
       $primer_apellido=$request->primer_apellido;
       $segundo_apellido=$request->segundo_apellido;
       $identidad=$request->identidad;
       $telefono=$request->telefono;
       $id_pais=$request->id_pais;
       $domicilio=$request->domicilio;
       $correo=$request->correo;
       $msgError=null;
       $msgSuccess=null;
       $accion=$request->accion;
       $per_empleado_list=null;
       if($id==null && $accion==2){
                   $accion=1;
               }
       try{ 
       
       if($accion==1){
       $sql_per_empleado = DB::select("insert INTO public.per_empleado (
       correo,domicilio,id_pais,identidad,primer_apellido,primer_nombre,segundo_apellido,segundo_nombre,telefono
       , created_at) values (
       :correo,:domicilio,:id_pais,:identidad,:primer_apellido,:primer_nombre,:segundo_apellido,:segundo_nombre,:telefono
       , now() )
       RETURNING  id
       ", ['correo'=>$correo,'domicilio'=>$domicilio,'id_pais'=>$id_pais,'identidad'=>$identidad,'primer_apellido'=>$primer_apellido,'primer_nombre'=>$primer_nombre,'segundo_apellido'=>$segundo_apellido,'segundo_nombre'=>$segundo_nombre,'telefono'=>$telefono
       ]
       );
       foreach($sql_per_empleado as $r){
       $id=$r->id;
       }
       $msgSuccess="Registro creado con el código: ".$id;
       }else if($accion==2){
       $sql_per_empleado = DB::select("update public.per_empleado set  updated_at = now(),
       correo=:correo,domicilio=:domicilio,id_pais=:id_pais,identidad=:identidad,primer_apellido=:primer_apellido,primer_nombre=:primer_nombre,segundo_apellido=:segundo_apellido,segundo_nombre=:segundo_nombre,telefono=:telefono
       where id=:id
       "
       , ['correo'=>$correo,'domicilio'=>$domicilio,'id'=>$id,'id_pais'=>$id_pais,'identidad'=>$identidad,'primer_apellido'=>$primer_apellido,'primer_nombre'=>$primer_nombre,'segundo_apellido'=>$segundo_apellido,'segundo_nombre'=>$segundo_nombre,'telefono'=>$telefono]
       );
       $msgSuccess="Registro ".$id." actualizado";
       
       }else if($accion==3){
       
       $sql_per_empleado = DB::select("update public.per_empleado set deleted_at=now() where
       id=:id
       "
       , ['id'=>$id]
       );
       $msgSuccess="Registro ".$id." eliminado";
       
       }else{
                   $msgError="Accion invalida";
               }
       if($msgError==null){
        $per_empleado_list = DB::select("select * from (
        select pe.id, pe.primer_nombre, pe.segundo_nombre, pe.primer_apellido, pe.segundo_apellido, pe.identidad,
       pe.telefono, pe.id_pais, tp.nombre as pais, pe.domicilio, pe.id_usuario, pe.correo 
       from public.per_empleado pe 
       join public.tbl_paises tp on tp.id = pe.id_pais
       join public.users uu on uu.id = pe.id_usuario
       where pe.deleted_at is null
       order by 1 desc
       
       ) x where id=:id
       ",[
       "id"=>$id
       ]);
       }
       }catch (Exception $e){
                   $msgError=$e->getMessage();
               }
       return response()->json(["msgSuccess" => $msgSuccess,"msgError"=>$msgError, "per_empleado_list"=>$per_empleado_list]);
       }
       
}
