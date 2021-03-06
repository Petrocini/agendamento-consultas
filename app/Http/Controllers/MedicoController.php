<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Faker\Provider\Medical;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class MedicoController extends Controller
{
    public function index(){
        $users = User::all();

        return view('medico.lista_medico', ['medicos' => $users]);
    }

    public function criar(Request $request) {
        if ($request->id == null) {
            return view('medico.registrar_medico');
        } else {
            $user = User::find($request->id);
            $edit = true;
            return view('medico.registrar_medico', compact('edit'), ['medico' => $user]);
        }
    }

    public function criarAction(Request $request) {

        $request->validate(
            [
                'name' => 'required|string|max:255',
                'login' => 'required|string|max:255|unique:users',
                'password' => 'required',
                'crm' => 'required|integer'
            ],
            [
                'integer' => 'O CRM deve possuir somente números',
                'unique' => 'O Usuário informado já está em uso'
            ]
        );

        $crm = $request->crm;
        $uf = $request->uf;

        $crmCompleto = $crm . '/' . $uf;

        if ($medico = User::first() != null) {
            $medico = User::first()->where('crm', $crmCompleto)->get();
            if(count($medico) > 0) {
                return redirect()->back()->with('erro', 'Já existe um médico cadastrado com este CRM');
            }
        }

        $user = User::create([
            'name' => $request->name,
            'login' => $request->login,
            'password' => Hash::make($request->password),
            'crm' => $crmCompleto
        ]);

        $user->attachRole(2);
        event(new Registered($user));

        return redirect()->back()->with('sucesso', 'Médico registrado com sucesso');
    }

    public function editar(Request $request) {

        $request->validate(
            [
                'name' => 'required|string|max:255',
                'login' => 'required|string|max:255|unique:users',
                'password' => 'required',
                'crm' => 'required|integer'
            ],
            [
                'integer' => 'O CRM deve possuir somente números',
            ]
        );

        $crm = $request->crm;
        $uf = $request->uf;

        $crmCompleto = $crm . '/' . $uf;

        User::find($request->id)->update([
            'name' => $request->name,
            'login' => $request->login,
            'password' => Hash::make($request->password),
            'crm' => $crmCompleto
        ]);

        return redirect()->route('listaMedico')->with('sucesso', 'Médico atualizado com sucesso!');
    }

    public function apagar(Request $request) {

        User::find($request->id)->delete();
        return redirect()->back();
    }
}
