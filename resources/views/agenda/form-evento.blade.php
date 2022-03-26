<div class="modal face" id="formEvento" tabindex="-1" aria-labelledby="formEventoLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Novo período de planejamento</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" id="form-modal" action="{{ route('evento.store') }}">
          @csrf
          <div class="mb-3">
            <label for="plano_estrategico_id">Agenda</label>
            <select class="form-select"  id="agenda_id" name="agenda_id" aria-label="Selecione o grupo">
            </select>
          </div>
        
          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="nome" name="nome" value="" placeholder="Nome...">
            <label for="nome">Nome</label>
          </div>
        
          <div class="form-floating mb-3">
            <input type="date" class="form-control" id="data_inicio" name="data_inicio" value="" placeholder="Sigla...">
            <label for="data_inicio">Ínicio</label>
          </div>
        
          <div class="form-floating mb-3">
            <input type="date" class="form-control" id="data_fim" name="data_fim" value="" placeholder="Sigla...">
            <label for="data_fim">Fim</label>
          </div>
          <button class="btn btn-sm btn-primary" type="submit">Salvar</button>
        </form>
      </div>
    </div>
  </div>
</div>