<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPJasper\PHPJasper; 

class ReportesController extends Controller
{

    protected $RPT_HELLO_WORD;
    protected $INPUT_RPT_PATH;
    protected $OUTPUT_RPT_PATH;

    public function __construct(){
        $this->RPT_HELLO_WORD='hello_world';
        $this->INPUT_RPT_PATH=app_path().'/Documentos/Reportes/';
        $this->OUTPUT_RPT_PATH='/documentos/reportes/';
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
            public_path().$output,
            $options
        )->execute();
        
        //return response()->file($pathToFile);
        return view('reportes.generico')->with('reportName',$output.'.pdf');
        
    }
}
