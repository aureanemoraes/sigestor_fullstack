<div class="modal face" id="formCheckin" tabindex="-1" aria-labelledby="formCheckinLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Check-in</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" id="form-modal">
          @csrf
          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="valor" name="valor" placeholder="Nome...">
            <label for="valor">Valor</label>
          </div>
          <div class="form-floating mb-3">
            <textarea class="form-control @error('descricao') is-invalid @enderror" placeholder="Descrição" id="descricao" name="descricao"></textarea>
            <label for="floatingTextarea">Descrição</label>
          </div>
          <button class="btn btn-sm btn-primary" type="submit">Salvar</button>
        </form>
      </div>
    </div>
  </div>
</div>