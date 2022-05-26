{{-- 
<style>
  .select2-selection__choice{
    margin-top: 0px!important;
    padding-right: 5px!important;
    padding-left: 5px!important;
    background-color: transparent!important;
    border:none!important;
    border-radius: 4px!important;
    background-color: rgba(0, 139, 139, 0.09) !important;
}

.select2-selection__choice__remove{
    border: none!important;
    border-radius: 0!important;
    padding: 0 2px!important;
}

.select2-selection__choice__remove:hover{
    background-color: transparent!important;
    color: #ef5454 !important;
}
</style> --}}

<h3>Usuários</h3>
@php
    if(isset($user)) {
      $route = route('user.update', $user->id);
    } else {
      $route = route('user.store');
    }
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

  <div class="form-floating mb-3">
    <select class="form-control form-select @error('perfil') is-invalid @enderror" id="perfil" name="perfil" aria-label="Selecione a instituição">
      <option selected value="">-- selecione --</option>
      <option value="basico" {{ isset($user->perfil) && $user->perfil == 'basico' ? 'selected' : ''  }}>
        Básico
      </option>
      <option value="institucional" {{ isset($user->perfil) && $user->perfil == 'institucional' ? 'selected' : ''  }}>
        Institucional
      </option>
      <option value="gestor" {{ isset($user->perfil) && $user->perfil == 'gestor' ? 'selected' : ''  }}>
        Gestor
      </option>
      <option value="administrativo" {{ isset($user->perfil) && $user->perfil == 'administrativo' ? 'selected' : ''  }}>
        Administrativo
      </option>
    </select>
    <label for="perfil">
      Perfil
    </label>
    @error('perfil')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>

    <div class="mb-3">
      <label for="unidade_gestora_id">Unidades Gestoras</label>
      <select class="form-select @error('unidade_gestora_id') is-invalid @enderror" id="unidade_gestora_id" name="unidade_gestora_id[]" aria-label="Selecione o grupo" {{ isset($user) && ($user->perfil == 'gestor' || $user->perfil == 'administrativo') ? '' : 'disabled' }} multiple>
        @if(isset($unidades_gestoras))
          @foreach($unidades_gestoras as $unidade_gestora)
            <option value="{{ $unidade_gestora->id }}" {{ isset($user) && (in_array($unidade_gestora->id, $user->unidades_gestoras)  || in_array($unidade_gestora->id, $unidades_gestoras_ids))? 'selected' : '' }}>{{ $unidade_gestora->nome }}</option>
          @endforeach
        @endif
      </select>
      @error('unidade_gestora_id')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
      @enderror
    </div>

    <div class="mb-3">
      <label for="unidade_administrativa_id">Unidades Administrativas</label>
      <select class="form-select @error('unidade_administrativa_id') is-invalid @enderror" id="unidade_administrativa_id" name="unidade_administrativa_id[]" aria-label="Selecione o grupo" {{ isset($user) && $user->perfil == 'administrativo'? '' : 'disabled' }} multiple>
        @if(isset($unidades_administrativas))
          @foreach($unidades_administrativas as $unidade_administrativa)
            <option value="{{ $unidade_administrativa->id }}" {{ isset($user) && in_array($unidade_administrativa->id, $user->unidades_administrativas) ? 'selected' : '' }}>{{ $unidade_administrativa->nome }}</option>
          @endforeach
        @endif
      </select>
      @error('unidade_administrativa_id')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
      @enderror
    </div>

    <div class="mb-3">
      <div class="form-check">
        <input class="form-check-input" type="checkbox" value="1" id="ativo" name="ativo" checked>
        <label class="form-check-label" for="ativo">
          Ativar perfil
        </label>
      </div>
    </div>
  
  <button type="submit" class="btn btn-primary">Salvar</button>
</form>