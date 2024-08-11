<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use DB;
use Session;
use Exception;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Auth;

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
        $id_usuario=null;
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
        $password = '$2y$10$F3bJcMM59hkGE6PZHCtg/.mtddeSQhwQ.I7GnprYpDNNVpBvWokb6';
        $sql_per_empleado =null;
        $empleado_existe = null;
        $empleado_existe_permitido = 1;
        $sql_per_empleado_existente = null;
       if($id==null && $accion==2){
                   $accion=1;
               }
       try{ 
       
       if($accion==1){
            $sql_per_empleado_existente =collect( DB::select("select count(1) empleado_existe from per_empleado where identidad = :identidad",['identidad'=>$identidad]) )->first();

            $empleado_existe = intval(isset($sql_per_empleado_existente->empleado_existe) ? $sql_per_empleado_existente->empleado_existe : null);
            
            if( $empleado_existe !=  $empleado_existe_permitido){
                $sql_users = DB::select("insert INTO public.users (email,username,password, created_at, name, forzar_cambio_contrasenia)
                select x.email::text, x.username::text, x.password::text, x.created_at, x.name::text, true::bool forzar_cambio_contrasenia from (
                    select :email::text email, 
                    lower(substr(trim(:primer_nombre::text),1,1)||substr(coalesce(trim(:segundo_nombre::text),''),1,1)||trim(:primer_apellido::text)||substr(coalesce(trim(:segundo_apellido::text),''),1,1)||length(trim(:primer_nombre::text)||trim(:primer_apellido::text))) as username, 
                    :password::text as password, (now() at time zone 'CST') created_at,
                    TRIM(
                    COALESCE(TRIM(:primer_nombre::text)||' ','')||
                    COALESCE(TRIM(:segundo_nombre::text)||' ','')||
                    COALESCE(TRIM(:primer_apellido::text)||' ','')||
                    COALESCE(TRIM(:segundo_apellido::text||' '),'')
                    ) as name
                )x
                RETURNING id", 
                ['email'=>$correo,'password'=>$password,
                    'primer_apellido'=>$primer_apellido,'primer_nombre'=>$primer_nombre,
                    'segundo_apellido'=>$segundo_apellido,'segundo_nombre'=>$segundo_nombre
                ]);

                foreach($sql_users as $r){
                    $id_usuario=$r->id;
                }

                $sql_per_empleado = DB::select("insert INTO public.per_empleado (
                correo,domicilio,id_pais,identidad,primer_apellido,primer_nombre,segundo_apellido,segundo_nombre,telefono, id_usuario
                , created_at) values (
                :correo,:domicilio,:id_pais,:identidad,:primer_apellido,:primer_nombre,:segundo_apellido,:segundo_nombre,:telefono, :id_usuario
                , now() )
                RETURNING  id
                ", ['correo'=>$correo,'domicilio'=>$domicilio,'id_pais'=>$id_pais,'identidad'=>$identidad,
                    'primer_apellido'=>$primer_apellido,'primer_nombre'=>$primer_nombre,'segundo_apellido'=>$segundo_apellido,
                    'segundo_nombre'=>$segundo_nombre,'telefono'=>$telefono, 'id_usuario'=>$id_usuario
                ]
                );

                foreach($sql_per_empleado as $r){
                    $id=$r->id;
                }

                $msgSuccess="Registro creado con el código: ".$id;
            }else if( $empleado_existe ==  $empleado_existe_permitido ){
                $msgError="Registro duplicado, ya existe un empleado!";
            }
            
            
            
            
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
       
     public function ver_seg_usuario_permisos( $idEmpleado ) {
        $permisos_list = DB::select("select id, nombre from public.seg_permisos where deleted_at is null");
        $seg_usuario_permisos_list = DB::select("
        select sup.id, sup.id_usuario, u.name, sup.permiso, sp.nombre as permiso_otorgado
        from public.seg_usuario_permisos sup 
        join public.users u on u.id = sup.id_usuario 
        join public.seg_permisos sp on sp.id = sup.permiso 
        join per_empleado pe on pe.id_usuario = u.id
        where sup.deleted_at is null
        and sup.id_usuario = :id_empleado
        order by 1 desc
        ", ['id_empleado'=>$idEmpleado]
        );
        
       return view("empleado.empleadosPermisos")
                ->with("seg_usuario_permisos_list", $seg_usuario_permisos_list)
                ->with("permisos_list", $permisos_list)
                ->with("id_empleado", $idEmpleado)
       ;
   }

    public function guardar_seg_usuario_permisos(Request $request) {
        $id=$request->id;
        $permiso=$request->permiso;
        $id_empleado=$request->id_empleado;
        $msgError=null;
        $msgSuccess=null;
        $accion=$request->accion;
        $seg_usuario_permisos_list=null;
        
        if($id==null && $accion==2){
            $accion=1;
        }
        
        try{ 

        if($accion==1){
            $sql_seg_usuario_permisos = DB::select("insert INTO public.seg_usuario_permisos (permiso, created_at, id_usuario) 
                values (:permiso, now(), :id_usuario )
            RETURNING  id
            ", ['permiso'=>$permiso, 'id_usuario'=>$id_empleado]
            );
            
            foreach($sql_seg_usuario_permisos as $r){
                $id=$r->id;
            }
            
            $msgSuccess="Registro creado con el código: ".$id;
            
        }else if($accion==2){
            $sql_seg_usuario_permisos = DB::select("update public.seg_usuario_permisos set  updated_at = now(),permiso=:permiso where id=:id
            "
            , ['id'=>$id,'permiso'=>$permiso]
            );
            
            $msgSuccess="Registro ".$id." actualizado";

        }else if($accion==3){

            $sql_seg_usuario_permisos = DB::select("update public.seg_usuario_permisos set deleted_at=now() where id=:id"
            , ['id'=>$id]
            );
            
            $msgSuccess="Registro ".$id." eliminado";

        }else{
            $msgError="Accion invalida";
        }
        
        if($msgError==null){
            $seg_usuario_permisos_list = DB::select("select * from (
               select sup.id, sup.id_usuario, u.name, sup.permiso, sp.nombre as permiso_otorgado
               from public.seg_usuario_permisos sup 
               join public.users u on u.id = sup.id_usuario 
               join public.seg_permisos sp on sp.id = sup.permiso 
               join per_empleado pe on pe.id_usuario = u.id
               where sup.deleted_at is null
               and sup.id_usuario = :id_empleado
               order by 1 desc
           ) x where id=:id
           ",[
           "id"=>$id, , 'id_empleado'=>$id_empleado
           ]);
        }
        }catch (Exception $e){
            $msgError=$e->getMessage();
        }
        return response()->json(["msgSuccess" => $msgSuccess,"msgError"=>$msgError, "seg_usuario_permisos_list"=>$seg_usuario_permisos_list]);
    }
  
       
}
