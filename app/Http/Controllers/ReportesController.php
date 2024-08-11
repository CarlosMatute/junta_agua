<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPJasper\PHPJasper; 

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
        $this->OUTPUT_RPT_PATH=public_path().'/documentos/reportes/';
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

        $jasper->process(
            $inputCompile,
            $output,
            $options
        )->execute();
        
        //return response()->file($pathToFile);
        return view('reportes.generico')->with('reportName',$output.'.pdf');
        
    }
    
    public function factura_junta_agua($idMovimiento){

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
}
