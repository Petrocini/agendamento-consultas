@extends('layouts.layout')

@section('pg_title', 'Registrar médicos')

@section('body')
    <form @if($edit ?? '') action="{{ route('editarMedicoAction', ['id' => $medico->id]) }}" @else action="{{ route('registrarMedicoAction') }}" @endif method="post">
        @csrf
        <div class="register_inputs">
            <div class="form-group">
                <label for="name">Nome do médico: </label>
                <input type="text" name="name" class="form-control" @if($edit ?? '') value="{{$medico->name}}"@endif required>
            </div>
            <div class="form-group">
                <label for="name">Login: </label>
                <input type="text" name="login" class="form-control" @if($edit ?? '') value="{{$medico->login}}" @endif required>
            </div>
            <div class="form-group">
                <label for="name">Senha: </label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="name">CRM: </label>
                <div class="input-group">
                    <input type="text" minlength="6" maxlength="6" min="0" max="999999" name="crm" class="form-control" @if($edit ?? '') value="{{substr($medico->crm, 0, 6)}}" readonly @endif required>
                    <div class="input-group-append">
                        <select name="uf" class="form-control" >
                            <option value="AC">AC</option>
                            <option value="AL">AL</option>
                            <option value="AM">AM</option>
                            <option value="AP">AP</option>
                            <option value="BA">BA</option>
                            <option value="CE">CE</option>
                            <option value="DF">DF</option>
                            <option value="ES">ES</option>
                            <option value="GO">GO</option>
                            <option value="MA">MA</option>
                            <option value="NT">MT</option>
                            <option value="MS">MS</option>
                            <option value="MG">MG</option>
                            <option value="PA">PA</option>
                            <option value="PB">PB</option>
                            <option value="PE">PE</option>
                            <option value="PR">PR</option>
                            <option value="PT">PI</option>
                            <option value="RJ">RJ</option>
                            <option value="RN">RN</option>
                            <option value="RS">RS</option>
                            <option value="RO">RO</option>
                            <option value="RR">RR</option>
                            <option value="SC">SC</option>
                            <option value="SE">SE</option>
                            <option value="SP">SP</option>
                            <option value="TO">TO</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" @if($edit ?? '') value="Editar" @else value="Criar" @endif>
            </div>
            @if (session('msg'))
                <div class="alert alert-success" role="alert">
                    {{session('msg')}}
                </div>
            @endif
            @if (session('erro'))
                <div class="alert alert-danger" role="alert">
                    {{session('erro')}}
                </div>
            @endif
            @if (session('warning'))
            <div class="alert alert-danger" role="alert">
                {{session('warning')}}
            </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </form>

@endsection