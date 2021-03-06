<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Paciente;
use Illuminate\Auth\Events\Registered;

class PacienteController extends Controller
{
    public function index() {
        $pacientes = Paciente::all();
        return view('paciente.lista_paciente', ['pacientes' => $pacientes]);
    }

    public function criar(Request $request){
        if($request->id == null){
            return view('paciente.registrar_paciente');
        }else{
            $paciente = Paciente::find($request->id);
            $edit = true;
            return view('paciente.registrar_paciente', compact('edit'), ['paciente' => $paciente]);
        }
    }

    public function criarAction(Request $request) {

        
        $request->validate(
            [
                'cpf' => 'required|integer|unique:pacientes'
            ],
            [
                'integer' => 'O CPF deve possuir somente números',
                'unique' => 'CPF já cadastrado'
            ]
        );

        $paciente = Paciente::create([
            'name' => $request->name,
            'cpf' => $request->cpf,
        ]);

        event(new Registered($paciente));

        return redirect()->back()->with('sucesso', 'Paciente registrado com sucesso');
    }

    public function editar(Request $request) {

        $request->validate(
            [
                'cpf' => 'required|integer'
            ],
            [
                'integer' => 'O CPF deve possuir somente números',
            ]
        );

        Paciente::find($request->id)->update([
            'name'=>$request->name,
            'cpf'=>$request->cpf,
        ]);

        return redirect()->route('listaPaciente');
    }

    public function deletar(Request $request) {

        Paciente::find($request->id)->delete();
        return redirect()->back();
    }
}