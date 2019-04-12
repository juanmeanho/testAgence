<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;


class ConsultoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $consultores = DB::table('cao_usuario')
            ->join('permissao_sistema', 'cao_usuario.co_usuario', '=', 'permissao_sistema.co_usuario')
            ->where('permissao_sistema.co_sistema', '=', 1)
            ->whereIn('permissao_sistema.co_tipo_usuario', array(0, 1, 2))
            ->get();

        return response()->json(['consultores' => $consultores], 200);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function getRelatorio($periodo, $co_usuario)
    {
        $date_explode = explode('-', $periodo);

        $receita_liquida = DB::table('cao_fatura')
                ->join('cao_os', 'cao_fatura.co_os', '=', 'cao_os.co_os')
                ->where('cao_os.co_usuario', '=', $co_usuario)
                ->whereYear('cao_fatura.data_emissao', $date_explode[0])
                ->whereMonth('cao_fatura.data_emissao', $date_explode[1]);

        $valor = $receita_liquida->sum('cao_fatura.valor');
        $comissao_cn = $receita_liquida->avg('cao_fatura.comissao_cn');
        $total_imp_inc = $receita_liquida->avg('cao_fatura.total_imp_inc');

        $custo_fixo = DB::table('cao_salario')
                ->where('co_usuario', '=', $co_usuario)
                ->get('brut_salario');
        
        if(count($custo_fixo) > 0)
            $cf = round($custo_fixo[0]->brut_salario, 2);
        else
            $cf = 0;

        $comissao = ($valor - ($valor * ($total_imp_inc/100))) * ($comissao_cn/100);
        $lucro = $valor - $cf - $comissao;

        $libro = new \stdClass();
        $arreglo_datos = [];

        $arreglo_datos = array(
            'receita_liquida' => round($valor, 2),
            'custo_fixo' => $cf,
            'comissao' => round($comissao, 2),
                    'lucro' => round($lucro, 2)
        );

        return response()->json(['datos_relatorio' => $arreglo_datos], 200);

    }
}
