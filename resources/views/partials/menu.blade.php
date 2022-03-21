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
      <a href="#" class="nav_logo">
        <i class='bx bx-layer nav_logo-icon'></i>
        <span class="nav_logo-name">Sigestor</span>
      </a>
      <div class="nav_list">
        <a class="nav_link active" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
          <i class="bi bi-gear-fill nav_icon"></i>
          Configurações
        </a>
        <div class="collapse" id="collapseExample">
          <a href="{{ route('instituicao.index') }}" class="nav_link nav_link_secondary active">
            <i class="bi bi-align-end"></i>
            <span class="nav_name">Instituições</span>
          </a>
          <a href="{{ route('exercicio.index') }}" class="nav_link nav_link_secondary">
            <i class="bi bi-align-end"></i>
            <span class="nav_name">Exercícios</span>
          </a>
          <a href="{{ route('unidade_gestora.index') }}" class="nav_link nav_link_secondary">
            <i class="bi bi-align-end"></i>
            <span class="nav_name">Unidades Gestoras</span>
          </a>
          <a href="{{ route('unidade_administrativa.index') }}" class="nav_link nav_link_secondary">
            <i class="bi bi-align-end"></i>
            <span class="nav_name">Unidades Administrativas</span>
          </a>
          <a href="{{ route('programa.index') }}" class="nav_link nav_link_secondary">
            <i class="bi bi-align-end"></i>
            <span class="nav_name">Programas</span>
          </a>
          <a href="{{ route('fonte_tipo.index') }}" class="nav_link nav_link_secondary">
            <i class="bi bi-align-end"></i>
            <span class="nav_name">Fontes</span>
          </a>
          <a href="#" class="nav_link nav_link_secondary">
            <i class="bi bi-align-end"></i>
            <span class="nav_name">Ações</span>
          </a>
          <a href="#" class="nav_link nav_link_secondary">
            <i class="bi bi-align-end"></i>
            <span class="nav_name">Naturezas de Despesas</span>
          </a>
          <a href="#" class="nav_link nav_link_secondary">
            <i class="bi bi-align-end"></i>
            <span class="nav_name">Centros de Custo</span>
          </a>
          <a href="#" class="nav_link nav_link_secondary">
            <i class="bi bi-align-end"></i>
            <span class="nav_name">Usuários</span>
          </a>
        </div>

        
      </div>
    </div>
    <a href="#" class="nav_link">
      <i class='bx bx-log-out nav_icon'></i>
      <span class="nav_name">Sair</span>
    </a>
  </nav>
</div>