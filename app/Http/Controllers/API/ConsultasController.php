<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Agendamento;
use Illuminate\Support\Facades\Auth;

class ConsultasController extends Controller{
    public function consultas(Request $request){
        //Select geral para busca de consultas por médico
        $consultas = Agendamento::all()->where('concluida', 0)->where('idMedico', $request->id);
        return response()->json($consultas, 200);
    }
}