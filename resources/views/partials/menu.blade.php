<header class="header" id="header">
  <div class="header_toggle">
    <i class='bx bx-menu' id="header-toggle"></i>
  </div>
  <div class="header_user">
    <!-- Example single danger button -->
    @if(Auth::user() != null)
      <div class="btn-group">
        <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
          {{ Auth::user()->nome }}
        </button>
        <ul class="dropdown-menu dropdown-menu-right">
          <li><a class="dropdown-item" href="{{ route('user.show', Auth::id()) }}">Perfil</a></li>
        </ul>
      </div>
    @endif
  </div>
</header>
<div class="l-navbar" id="nav-bar">
  <nav class="nav">
    <div>
      <a href="/" class="nav_logo">
        <img src="{{ asset('/storage/img/logo_branca.png') }}" alt="Logo" class="rounded logo" height="100px">
      </a>
      <div class="nav_list">
        @if(userType('institucional'))
          <a class="nav_link active" data-bs-toggle="collapse" href="#configuracao" role="button" aria-expanded="true" aria-controls="configuracao">
            <i class="bi bi-gear-fill nav_icon"></i>
            Configurações
          </a>
          <div class="collapse" id="configuracao">
            <a class="nav_link nav_link_secondary" data-bs-toggle="collapse" href="#matriz_orcamamentaria" role="button" aria-expanded="false" aria-controls="matriz_orcamamentaria">
              <i class="bi bi-align-center"></i>
              Matriz Orçamentária
            </a>
            <div class="collapse" id="matriz_orcamamentaria">
              <a href="{{ route('instituicao.index') }}" class="nav_link nav_link_tertiary active">
                <span class="nav_name">Instituições</span>
              </a>
              <a href="{{ route('exercicio.index') }}" class="nav_link nav_link_tertiary">
                <span class="nav_name">Exercícios</span>
              </a>
              <a href="{{ route('unidade_gestora.index') }}" class="nav_link nav_link_tertiary">
                <span class="nav_name">Unidades Gestoras</span>
              </a>
              <a href="{{ route('unidade_administrativa.index') }}" class="nav_link nav_link_tertiary">
                <span class="nav_name">Unidades Administrativas</span>
              </a>
              <a href="{{ route('programa.index') }}" class="nav_link nav_link_tertiary">
                <span class="nav_name">Programas</span>
              </a>
              <a href="{{ route('fonte_tipo.index') }}" class="nav_link nav_link_tertiary">
                <span class="nav_name">Fontes</span>
              </a>
              <a href="{{ route('acao_tipo.index') }}" class="nav_link nav_link_tertiary">
                <span class="nav_name">Ações</span>
              </a>
              <a href="{{ route('natureza_despesa.index') }}" class="nav_link nav_link_tertiary">
                <span class="nav_name">Naturezas de Despesas</span>
              </a>
              <a href="{{ route('subnatureza_despesa.index') }}" class="nav_link nav_link_tertiary">
                <span class="nav_name">Subnaturezas de Despesas</span>
              </a>
              <a href="{{ route('centro_custo.index') }}" class="nav_link nav_link_tertiary">
                <span class="nav_name">Centros de Custo</span>
              </a>
              <a href="{{ route('meta_orcamentaria.index') }}" class="nav_link nav_link_tertiary">
                <span class="nav_name">Metas Orçamentárias</span>
              </a>
              <a href="{{ route('despesa_modelo.index') }}" class="nav_link nav_link_tertiary">
                <span class="nav_name">Despesas Modelos</span>
              </a>
              <a href="{{ route('user.index') }}" class="nav_link nav_link_tertiary">
                <span class="nav_name">Usuários</span>
              </a>
            </div>
            <a class="nav_link nav_link_secondary" data-bs-toggle="collapse" href="#metas_estrategicas" role="button" aria-expanded="false" aria-controls="metas_estrategicas">
              <i class="bi bi-align-center"></i>
              Metas Estratégicas
            </a>
            <div class="collapse" id="metas_estrategicas">
              <a href="{{ route('plano_estrategico.index') }}" class="nav_link nav_link_tertiary active">
                <span class="nav_name">Planos Estratégicos</span>
              </a>
              <a href="{{ route('plano_acao.index') }}" class="nav_link nav_link_tertiary active">
                <span class="nav_name">Planos de Ações</span>
              </a>
              <a href="{{ route('eixo_estrategico.index') }}" class="nav_link nav_link_tertiary active">
                <span class="nav_name">Eixos</span>
              </a>
              <a href="{{ route('dimensao.index') }}" class="nav_link nav_link_tertiary active">
                <span class="nav_name">Dimensões</span>
              </a>
              <a href="{{ route('objetivo.index') }}" class="nav_link nav_link_tertiary active">
                <span class="nav_name">Objetivos</span>
              </a>
            </div>
          </div>
        @endif
        @if(userType('institucional'))
          <a class="nav_link" data-bs-toggle="collapse" href="#matriz_estratégica" role="button" aria-expanded="true" aria-controls="matriz_estratégica">
            <i class="bi bi-gear-fill nav_icon"></i>
            Matriz Estratégica
          </a>
          <div class="collapse" id="matriz_estratégica">
            <a href="{{ route('objetivo.index', ['modo_exibicao' => 'metas']) }}" class="nav_link nav_link_secondary">
              <i class="bi bi-align-center"></i>
              <span class="nav_name">Metas</span>
            </a>
            <a href="{{ route('objetivo.index') }}" class="nav_link nav_link_secondary">
              <i class="bi bi-align-center"></i>
              <span class="nav_name">Relatórios</span>
            </a>
          </div>
        @endif
        <a class="nav_link" data-bs-toggle="collapse" href="#matriz_orcamentaria_planejamento" role="button" aria-expanded="true" aria-controls="matriz_orcamentaria_planejamento">
          <i class="bi bi-gear-fill nav_icon"></i>
          Matriz Orçamentária
        </a>
        <div class="collapse" id="matriz_orcamentaria_planejamento">
          <a class="nav_link nav_link_secondary" data-bs-toggle="collapse" href="#ploa_planejamento" role="button" aria-expanded="false" aria-controls="ploa_planejamento">
            <i class="bi bi-align-center"></i>
            PLOA
          </a>
          <div class="collapse" id="ploa_planejamento">
            @if(userType('institucional'))
              <a href="{{ route('agenda.index') }}" class="nav_link nav_link_tertiary">
                <span class="nav_name">Agenda</span>
              </a>
              <a href="{{ route('ploa.index') }}" class="nav_link nav_link_tertiary">
                <span class="nav_name">Matriz - Institucional</span>
              </a>
            @endif
            @if(userType('gestor'))
              <a href="{{ route('ploa_gestora.index') }}" class="nav_link nav_link_tertiary">
                <span class="nav_name">Matriz - Gestora</span>
              </a>
            @endif
            @if(userType('administrativo'))
              <a href="{{ route('ploa_administrativa.index') }}" class="nav_link nav_link_tertiary">
                <span class="nav_name">Matriz - Administrativa</span>
              </a>
            @endif
            <a href="{{ route('relatorio.index') }}" class="nav_link nav_link_tertiary">
              <span class="nav_name">Relatórios</span>
            </a>
          </div>
          <a class="nav_link nav_link_secondary" data-bs-toggle="collapse" href="#loa_planejamento" role="button" aria-expanded="false" aria-controls="loa_planejamento">
            <i class="bi bi-align-center"></i>
            LOA
          </a>
          <div class="collapse" id="loa_planejamento">
            @if(userType('institucional'))
              <a href="{{ route('loa.lista') }}" class="nav_link nav_link_tertiary">
                <span class="nav_name">LOA - Institucional</span>
              </a>
            @endif
            @if(userType('gestor'))
              <a href="{{ route('loa-gestora.lista') }}" class="nav_link nav_link_tertiary">
                <span class="nav_name">LOA - Gestora</span>
              </a>
            @endif
            @if(userType('administrativo'))
              <a href="{{ route('loa-administrativa.lista') }}" class="nav_link nav_link_tertiary">
                <span class="nav_name">LOA - Administrativa</span>
              </a>
            @endif
          </div>
        </div>
      </div>
    </div>
    <div class="">
      <a href="{{ asset('storage/file/manual_sigestor.pdf') }}" download class="nav_link">
        <i class="bi bi-info-circle-fill"></i>
        <span class="nav_name">Manual</span>
      </a>
      <a href="{{ route('logout') }}" class="nav_link">
        <i class='bx bx-log-out nav_icon'></i>
        <span class="nav_name">Sair</span>
      </a>
    </div>
  </nav>
</div>