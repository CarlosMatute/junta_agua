<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPJasper\PHPJasper; 
use DB;
use Session;
use Exception;
use Illuminate\Support\Facades\Auth;

class ReportesController extends Controller
{

    protected $RPT_HELLO_WORD;
    protected $RPT_FACTURA_JUNTA_AGUA;
    protected $INPUT_RPT_PATH;
    protected $OUTPUT_RPT_PATH;
    protected $dbConnection=array();

    public function __construct(){
        $this->RPT_HELLO_WORD='hello_world';
        $this->RPT_FACTURA_JUNTA_AGUA='factura_junta_agua';
        $this->INPUT_RPT_PATH=app_path().'/Documentos/Reportes/';
        $this->OUTPUT_RPT_PATH='/documentos/reportes/';
        //$this->OUTPUT_RPT_PATH='/home/tdmxafft/public_html/documentos/reportes/';
        $this->dbConnection= [
                'driver' => 'postgres', //env('DB_CONNECTION') //mysql, ....
                'username' => env('DB_USERNAME'),
                'password' => env('DB_PASSWORD'),
                'host' =>env('DB_HOST'),
                'database' => env('DB_DATABASE'),
                'port' => env('DB_PORT'),
                /*
                'driver' => 'postgres', //env('DB_CONNECTION') //mysql, ....
                'username' => 'reports',
                'password' => 'D34dp00l',
                'host' => '10.15.0.2',
                'database' => 'una_2019_periodo_ii',
                'port' => '5432'*/
            ];
    }

    public function imprimir_reporte(){

        $input = $this->INPUT_RPT_PATH.$this->RPT_HELLO_WORD.'.jrxml';
        //dd($input);
        $inputCompile = $this->INPUT_RPT_PATH.$this->RPT_HELLO_WORD.'.jasper';
        $output = $this->OUTPUT_RPT_PATH.$this->RPT_HELLO_WORD;

        if(!file_exists($inputCompile)){
            $jasper = new PHPJasper;
            $jasper->compile($input)->execute();
        }        
        
        $options = [
            'format' => ['pdf']
        ];

        $jasper = new PHPJasper;

        //$jasper->debug = true;

        $jasper->process(
            $inputCompile,
            $output,
            $options
        )->execute();

        return view('reportes.reporteria')
            ->with('reportName',$output.'.pdf')
            ->with('reportDoc',$this->RPT_HELLO_WORD.'.pdf');        
            ;        
    }
    
    public function factura_junta_agua_old($idMovimiento){

        $input = $this->INPUT_RPT_PATH.$this->RPT_FACTURA_JUNTA_AGUA.'.jrxml';
        //dd($input);
        $inputCompile = $this->INPUT_RPT_PATH.$this->RPT_FACTURA_JUNTA_AGUA.'.jasper';
        $output = $this->OUTPUT_RPT_PATH.$this->RPT_FACTURA_JUNTA_AGUA;

        if(!file_exists($inputCompile)){
            $jasper = new PHPJasper;
            $jasper->compile($input)->execute();
        }
               
        $options = [ 
            'format' => ['pdf'],
            'params' =>['id_movimiento'=>$idMovimiento],            
            'db_connection' => $this->dbConnection
        ];
        
        $jasper = new PHPJasper;

        $jasper->process(
            $inputCompile,
            public_path().$output,
            $options
        )->execute();
        
        //return response()->file($pathToFile);
        return view('reportes.generico')->with('reportName',$output.'.pdf');
        
    }
    
    public function ver_factura_junta_agua($idMovimiento){        
        
        //return response()->file($pathToFile);
        return view('reportes.generico')
                ->with('idMovimiento',$idMovimiento);
        
    }
    
    public function factura_junta_agua(Request $request) {
    $id=$request->id;    
    $id_movimiento=$request->id_movimiento;
    $msgError=null;
    $msgSuccess=null;
    $accion=$request->accion;
    $tbl_movimientos_list=null;
    $resultado=null;
    $msgAlert=null;

    try{ 

        $tbl_movimientos_list=DB::select("select
            ts.descripcion as servicio,
            to_char( now() , 'YYYY-MM-DD HH:MM:SS' ) as fecha_hora_genera,
            coalesce(tc1.primer_nombre,'')||' '||coalesce(tc1.segundo_nombre,'')||' '||coalesce(tc1.primer_apellido,'')||' '||coalesce(tc1.segundo_apellido,'') as cliente,
            tu.descripcion_casa as contrato, 
            tts.nombre as concepto_pago_servicio,
            tm.concepto as pago_servicio,
            tm.haber as monto_pago,
            to_char( tm.fecha_hora , 'YYYY-MM-DD HH:MM:SS' ) as fecha_hora_pago,
            u.name as cobrador,
            cast(tm.id_contrato as text ) as id_contrato 
            from
            public.tbl_movimientos tm
            join public.tbl_contrato tc on tc.id_cliente = tm.id_cliente and tc.id = tm.id_contrato
            join public.tbl_clientes tc1 on tc1.id = tc.id_cliente
            join public.tbl_servicio ts on ts.id = tc.id_servicio
            join public.tbl_ubicacion tu on tu.id = tc.id_ubicacion
            join public.tbl_tipo_servicio tts on tts.id = ts.id_tipo
            join users u on u.id = tm.id_cobrador 
            where
            tc.deleted_at is null
            and tm.id = :id_movimiento",[
            "id_movimiento"=>$id_movimiento
        ]);
    
    }catch (Exception $e){
        $msgError=$e->getMessage();
    }    
   return response()->json(["msgSuccess" => $msgSuccess,"msgError"=>$msgError,"msgAlert" => $msgAlert, "tbl_movimientos_list"=>$tbl_movimientos_list]);
   }
}
