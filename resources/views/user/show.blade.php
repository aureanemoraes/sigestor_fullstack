@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
        <h3>Meu perfil</h3>
        @php
            $route = route('user.update.perfil', $user->id);
        @endphp
        <form action="{{ $route }}" method="POST" id="form">
            @csrf
            @if(isset($user))
            @method('PUT')
            @endif
            <div class="form-floating mb-3">
                <input type="text" class="form-control @error('nome') is-invalid @enderror" id="nome" name="nome" value="{{ isset($user->nome) ? $user->nome : ''}}" placeholder="Nome...">
                <label for="nome">Nome</label>
                @error('nome')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            
            <div class="form-floating mb-3">
                <input type="text" class="form-control @error('cpf') is-invalid @enderror" id="cpf" name="cpf" value="{{ isset($user->cpf) ? $user->cpf : ''}}" placeholder="Nome...">
                <label for="cpf">CPF</label>
                @error('cpf')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            
            <div class="form-floating mb-3">
                <input type="text" class="form-control @error('matricula') is-invalid @enderror" id="matricula" name="matricula" value="{{ isset($user->matricula) ? $user->matricula : ''}}" placeholder="Nome...">
                <label for="matricula">Matrícula</label>
                @error('matricula')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            
            <div class="form-floating mb-3">
                <select class="form-control form-select @error('titulacao') is-invalid @enderror" id="titulacao" name="titulacao" aria-label="Selecione a instituição">
                    <option selected value="">-- selecione --</option>
                    <option value="1" {{ isset($user->titulacao) && $user->titulacao == '1' ? 'selected' : ''  }}>
                        Reitor(a)
                    </option>
                    <option value="2" {{ isset($user->titulacao) && $user->titulacao == '2' ? 'selected' : ''  }}>
                        Pró-Reitor(a)
                    </option>
                    <option value="3" {{ isset($user->titulacao) && $user->titulacao == '3' ? 'selected' : ''  }}>
                        Diretor(a) Geral 
                    </option>
                    <option value="4" {{ isset($user->titulacao) && $user->titulacao == '4' ? 'selected' : ''  }}>
                        Diretor(a)
                    </option>
                    <option value="5" {{ isset($user->titulacao) && $user->titulacao == '5' ? 'selected' : ''  }}>
                        Chefe
                    </option>
                    <option value="6" {{ isset($user->titulacao) && $user->titulacao == '6' ? 'selected' : ''  }}>
                        Supervisor(a)
                    </option>
                </select>
                <label for="titulacao">
                    Titulação
                </label>
                @error('titulacao')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="mb-3">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="1" id="altera_senha" name="altera_senha">
                  <label class="form-check-label" for="altera_senha">
                    Alterar senha
                  </label>
                </div>
              </div>

            <div class="form-floating mb-3">
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Senha..." disabled>
                <label for="password">Senha atual</label>
                @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="form-floating mb-3">
                <input type="password" class="form-control @error('new_password') is-invalid @enderror" id="new_password" name="new_password" placeholder="Senha..." disabled>
                <label for="new_password">Nova senha</label>
                @error('new_password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
    </div>
</div>
@endsection

@section('js')
    <script>
        $('#altera_senha').on('change', () => {
            let altera_senha = $('#altera_senha').is(':checked');
            if (altera_senha) {
                $('#password').removeAttr('disabled');
                $('#new_password').removeAttr('disabled');
            } else {
                $('#password').attr('disabled', 'disabled');
                $('#new_password').attr('disabled', 'disabled');
            }
        });
    </script>
@endsection