<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class DepartamentosMunicipiosController extends Controller
{
    public function ver_departamento_municipios(Request $request)
    {
        $id_departamento = $request->id_departamento;
        $departamento_municipios = DB::select('SELECT tm.id id_municipio, tm.nombre from public.tbl_municipios tm
            join tbl_departamentos_municipios tdm on tm.id = tdm.id_municipio
            where tdm.id_departamento = :id_departamento
            order by nombre', ['id_departamento' => $id_departamento]);

        return response()->json(['departamento_municipios' => $departamento_municipios]);
    }
}
