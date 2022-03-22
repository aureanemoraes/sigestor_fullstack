<header class="header" id="header">
  <div class="header_toggle">
    <i class='bx bx-menu' id="header-toggle"></i>
  </div>
  <div class="header_img">
    <img src="https://i.imgur.com/hczKIze.jpg" alt="">
  </div>
</header>
<div class="l-navbar" id="nav-bar">
  <nav class="nav">
    <div>
      <a href="/" class="nav_logo">
        <img src="https://i.ibb.co/vJ0FXB2/logo-branca.png" alt="Logo" class="rounded logo" height="100px">
      </a>
      <div class="nav_list">
        <a class="nav_link active" data-bs-toggle="collapse" href="#configuracao" role="button" aria-expanded="true" aria-controls="configuracao">
          <i class="bi bi-gear-fill nav_icon"></i>
          Configurações
        </a>
        <div class="collapse show" id="configuracao">
          <a class="nav_link nav_link_secondary" data-bs-toggle="collapse" href="#matriz_orcamamentaria" role="button" aria-expanded="false" aria-controls="matriz_orcamamentaria">
            <i class="bi bi-align-center"></i>
            Matriz Orçamentária
          </a>
          <div class="collapse" id="matriz_orcamamentaria">
            <a href="{{ route('instituicao.index') }}" class="nav_link nav_link_tertiary active">
              <i class="bi bi-align-end"></i>
              <span class="nav_name">Instituições</span>
            </a>
            <a href="{{ route('exercicio.index') }}" class="nav_link nav_link_tertiary">
              <i class="bi bi-align-end"></i>
              <span class="nav_name">Exercícios</span>
            </a>
            <a href="{{ route('unidade_gestora.index') }}" class="nav_link nav_link_tertiary">
              <i class="bi bi-align-end"></i>
              <span class="nav_name">Unidades Gestoras</span>
            </a>
            <a href="{{ route('unidade_administrativa.index') }}" class="nav_link nav_link_tertiary">
              <i class="bi bi-align-end"></i>
              <span class="nav_name">Unidades Administrativas</span>
            </a>
            <a href="{{ route('programa.index') }}" class="nav_link nav_link_tertiary">
              <i class="bi bi-align-end"></i>

              <span class="nav_name">Programas</span>
            </a>
            <a href="{{ route('fonte_tipo.index') }}" class="nav_link nav_link_tertiary">
              <i class="bi bi-align-end"></i>

              <span class="nav_name">Fontes</span>
            </a>
            <a href="{{ route('acao_tipo.index') }}" class="nav_link nav_link_tertiary">
              <i class="bi bi-align-end"></i>

              <span class="nav_name">Ações</span>
            </a>
            <a href="{{ route('natureza_despesa.index') }}" class="nav_link nav_link_tertiary">
              <i class="bi bi-align-end"></i>

              <span class="nav_name">Naturezas de Despesas</span>
            </a>
            <a href="{{ route('subnatureza_despesa.index') }}" class="nav_link nav_link_tertiary">
              <i class="bi bi-align-end"></i>

              <span class="nav_name">Subnaturezas de Despesas</span>
            </a>
            <a href="{{ route('centro_custo.index') }}" class="nav_link nav_link_tertiary">
              <i class="bi bi-align-end"></i>

              <span class="nav_name">Centros de Custo</span>
            </a>
            <a href="#" class="nav_link nav_link_tertiary">
              <i class="bi bi-align-end"></i>

              <span class="nav_name">Usuários</span>
            </a>
          </div>
          <a class="nav_link nav_link_secondary" data-bs-toggle="collapse" href="#metas_estrategicas" role="button" aria-expanded="false" aria-controls="metas_estrategicas">
            <i class="bi bi-align-center"></i>
            Metas Estratégicas
          </a>
          <div class="collapse" id="metas_estrategicas">
            <a href="{{ route('plano_estrategico.index') }}" class="nav_link nav_link_tertiary active">
              <i class="bi bi-align-end"></i>
              <span class="nav_name">Planos Estratégicos</span>
            </a>
            <a href="{{ route('plano_acao.index') }}" class="nav_link nav_link_tertiary active">
              <i class="bi bi-align-end"></i>
              <span class="nav_name">Planos de Ações</span>
            </a>
            <a href="#" class="nav_link nav_link_tertiary active">
              <i class="bi bi-align-end"></i>
              <span class="nav_name">Eixos</span>
            </a>
            <a href="#" class="nav_link nav_link_tertiary active">
              <i class="bi bi-align-end"></i>
              <span class="nav_name">Dimensões</span>
            </a>
          </div>
        </div>
      </div>
    </div>
    <a href="#" class="nav_link">
      <i class='bx bx-log-out nav_icon'></i>
      <span class="nav_name">Sair</span>
    </a>
  </nav>
</div>