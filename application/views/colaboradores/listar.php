<?php
$data['title'] = 'Listagem de Colaboradores';
$this->load->view('templates/header', $data);
?>

<h2 class="mb-4">Colaboradores Cadastrados</h2>

<a href="<?php echo site_url('colaboradores/cadastrar'); ?>" class="btn btn-success mb-3">
  <i class="fas fa-user-plus"></i> Novo Colaborador
</a>

<div class="mb-3">
  <button id="btn-inativar-massa" class="btn btn-warning" style="display: none;">Inativar Selecionados</button>
  <button id="btn-ativar-massa" class="btn btn-success" style="display: none;">Ativar Selecionados</button>
</div>

<form id="form-massa" action="#" method="post">
  <div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
      <thead class="thead-dark text-center">
        <tr>
          <th><input type="checkbox" id="selecionar-todos"></th>
          <th><br><input type="text" class="form-control filtro" data-coluna="1" placeholder="ID"></th>
          <th><br><input type="text" class="form-control filtro" data-coluna="2" placeholder="Nome"></th>
          <th><br><input type="text" class="form-control filtro" data-coluna="3" placeholder="CPF"></th>
          <th><br><input type="text" class="form-control filtro" data-coluna="4" placeholder="Email"></th>
          <th><br><input type="text" class="form-control filtro" data-coluna="5" placeholder="Telefone"></th>
          <th><br><input type="text" class="form-control filtro" data-coluna="6" placeholder="Data Nasc."></th>
          <th><br><input type="text" class="form-control filtro" data-coluna="7" placeholder="Cargo"></th>
          <th><br><input type="text" class="form-control filtro" data-coluna="8" placeholder="Depto"></th>
          <th><br><input type="text" class="form-control filtro" data-coluna="9" placeholder="Salário"></th>
          <th><br><input type="text" class="form-control filtro" data-coluna="10" placeholder="Admissão"></th>
          <th><br><input type="text" class="form-control filtro" data-coluna="11" placeholder="Obs"></th>
          <th style="width:130px"><br>
            <select class="form-control filtro-status">
              <option value="todos">Todos</option>
              <option value="active">Ativo</option>
              <option value="inactive">Inativo</option>
            </select>
          </th>
          <th style="text-align: center; width:130px">Ações</th>
        </tr>
      </thead>
      <tbody id="corpo-tabela">
        <?php if (!empty($colaboradores)): ?>
          <?php foreach ($colaboradores as $colaborador): ?>
            <tr data-status="<?php echo $colaborador->status; ?>">
              <td class="text-center"><input type="checkbox" class="selecionar" name="ids[]"
                  value="<?php echo $colaborador->id; ?>" data-status="<?php echo $colaborador->status; ?>"></td>
              <td class="text-center" style="width:90px"><?php echo $colaborador->id; ?></td>
              <td class="text-truncate" style="max-width: 150px;"><?php echo $colaborador->nome; ?></td>
              <td class="text-truncate"><?php echo $colaborador->cpf; ?></td>
              <td class="text-truncate" style="max-width: 150px;"><?php echo $colaborador->email; ?></td>
              <td class="text-truncate"><?php echo $colaborador->telefone; ?></td>
              <td><?php echo date('d/m/Y', strtotime($colaborador->data_nascimento)); ?></td>
              <td class="text-truncate" style="max-width: 120px;"><?php echo $colaborador->cargo; ?></td>
              <td class="text-truncate"><?php echo $colaborador->departamento; ?></td>
              <td class="text-truncate"><?php echo 'R$ ' . number_format($colaborador->salario, 2, ',', '.'); ?></td>
              <td><?php echo date('d/m/Y', strtotime($colaborador->data_admissao)); ?></td>
              <td class="text-truncate" style="max-width: 150px;"><?php echo $colaborador->observacoes; ?></td>
              <td class="text-center">
                <?php echo $colaborador->status == 'active'
                  ? '<span class="badge badge-success">Ativo</span>'
                  : '<span class="badge badge-secondary">Inativo</span>'; ?>
              </td>
              <td class="text-center">
                <?php if ($colaborador->status == 'active'): ?>
                  <a href="<?php echo site_url('colaboradores/editar/' . $colaborador->id); ?>"
                    class="text-primary editar mx-2" title="Editar">
                    <i class="fas fa-pencil-alt"></i>
                  </a>
                <?php else: ?>
                  <a href="#" class="text-secondary editar mx-2 disabled" title="Usuário Inativo - Não pode editar" style="cursor: not-allowed; pointer-events: none;">
                    <i class="fas fa-pencil-alt"></i>
                  </a>
                <?php endif; ?>
                <?php if ($colaborador->status == 'active'): ?>
                  <a href="#" class="text-warning alterar-status mx-2" data-id="<?php echo $colaborador->id; ?>"
                    data-status="inactive" title="Inativar">
                    <i class="fas fa-times"></i>
                  </a>
                <?php else: ?>
                  <a href="#" class="text-success alterar-status mx-2" data-id="<?php echo $colaborador->id; ?>"
                    data-status="active" title="Ativar">
                    <i class="fas fa-check"></i>
                  </a>
                <?php endif; ?>
                <a class="text-info mx-2" data-toggle="collapse" href="#endereco-<?php echo $colaborador->id; ?>"
                  role="button" aria-expanded="false" aria-controls="endereco-<?php echo $colaborador->id; ?>"
                  title="Mostrar Endereço">
                  <i class="fas fa-map-marker-alt"></i>
                </a>
              </td>
            </tr>
            <tr>
              <td colspan="14" class="p-0">
                <div class="collapse" id="endereco-<?php echo $colaborador->id; ?>">
                  <div class="card card-body">
                    <div class="row">
                      <div class="col-md-6">
                        <h5>Endereço Padrão:</h5>
                        <p>
                          <strong>Rua:</strong> <?php echo $colaborador->rua; ?><br>
                          <strong>Número:</strong> <?php echo $colaborador->numero; ?><br>
                          <strong>Complemento:</strong> <?php echo $colaborador->complemento; ?><br>
                          <strong>Bairro:</strong> <?php echo $colaborador->bairro; ?><br>
                          <strong>Cidade:</strong> <?php echo $colaborador->cidade; ?> -
                          <?php echo $colaborador->estado; ?><br>
                          <strong>CEP:</strong> <?php echo $colaborador->cep; ?><br>
                          <strong>País:</strong> <?php echo $colaborador->pais; ?>
                        </p>
                      </div>
                      <div class="col-md-6 text-center">
                        <img src="<?php echo base_url('assets/images/api_googlemaps.png'); ?>"
                          alt="Mapa Ilustrativo do Endereço" class="img-fluid rounded shadow-sm"
                          style="max-width: 100%; height: auto;">
                      </div>
                    </div>
                  </div>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="14" class="text-center">Nenhum colaborador cadastrado.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</form>

<div class="mt-4">
  <?php echo $pagination; ?>
</div>

<style>
  .mapa-container img {
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s;
  }

  .mapa-container img:hover {
    transform: scale(1.05);
  }
</style>

<script>
  document.querySelectorAll('.filtro').forEach(function (input) {
    input.addEventListener('keyup', function () {
      var coluna = this.getAttribute('data-coluna');
      var valorFiltro = this.value.toLowerCase();
      var linhas = document.querySelectorAll('#corpo-tabela tr');

      if (coluna === "1") {
        linhas.forEach(function (linha) {
          var colunaTexto = linha.querySelectorAll('td')[coluna].textContent.toLowerCase();
          if (colunaTexto.indexOf(valorFiltro) > -1) {
            linha.style.display = '';
          } else {
            linha.style.display = 'none';
          }
        });
      }
      else {
        if (valorFiltro.length >= 3) {
          linhas.forEach(function (linha) {
            var colunaTexto = linha.querySelectorAll('td')[coluna].textContent.toLowerCase();
            if (colunaTexto.indexOf(valorFiltro) > -1) {
              linha.style.display = '';
            } else {
              linha.style.display = 'none';
            }
          });
        } else {
          linhas.forEach(function (linha) {
            linha.style.display = '';
          });
        }
      }
      verificarSelecao();
    });
  });

  document.querySelector('.filtro-status').addEventListener('change', function () {
    var statusFiltro = this.value;
    var linhas = document.querySelectorAll('#corpo-tabela tr');

    linhas.forEach(function (linha) {
      var status = linha.getAttribute('data-status');
      if (statusFiltro === 'todos') {
        linha.style.display = '';
      } else if (status === statusFiltro) {
        linha.style.display = '';
      } else {
        linha.style.display = 'none';
      }
    });
  });

  document.getElementById('selecionar-todos').addEventListener('click', function () {
    var checkboxes = document.querySelectorAll('.selecionar');
    checkboxes.forEach(checkbox => {
      checkbox.checked = this.checked;
    });
    verificarSelecao();
  });

  document.querySelectorAll('.selecionar').forEach(function (checkbox) {
    checkbox.addEventListener('change', verificarSelecao);
  });

  function verificarSelecao() {
    var selecionados = document.querySelectorAll('.selecionar:checked');
    var btnInativar = document.getElementById('btn-inativar-massa');
    var btnAtivar = document.getElementById('btn-ativar-massa');

    var ativos = 0;
    var inativos = 0;

    selecionados.forEach(function (checkbox) {
      var status = checkbox.getAttribute('data-status');
      if (status === 'active') {
        ativos++;
      } else if (status === 'inactive') {
        inativos++;
      }
    });

    if (ativos > 0 && inativos === 0) {
      btnInativar.style.display = 'inline-block';
      btnAtivar.style.display = 'none';
    } else if (inativos > 0 && ativos === 0) {
      btnAtivar.style.display = 'inline-block';
      btnInativar.style.display = 'none';
    } else if (ativos > 0 && inativos > 0) {
      btnInativar.style.display = 'inline-block';
      btnAtivar.style.display = 'inline-block';
    } else {
      btnInativar.style.display = 'none';
      btnAtivar.style.display = 'none';
    }
  }

  document.querySelectorAll('.alterar-status').forEach(function (button) {
    button.addEventListener('click', function (event) {
      event.preventDefault();
      var id = this.getAttribute('data-id');
      var status = this.getAttribute('data-status');
      var confirmacao = confirm('Tem certeza que deseja alterar o status deste colaborador?');
      if (confirmacao) {
        $.post("<?php echo site_url('colaboradores/alterar_status'); ?>", {
          id: id,
          status: status
        }, function (data) {
          if (data === 'success') {
            alert('Status alterado com sucesso.');
            location.reload();
          } else {
            alert('Erro ao alterar status.');
          }
        });
      }
    });
  });

  document.getElementById('btn-inativar-massa').addEventListener('click', function () {
    var ids = [];
    document.querySelectorAll('.selecionar:checked').forEach(function (checkbox) {
      ids.push(checkbox.value);
    });

    if (ids.length > 0) {
      var confirmacao = confirm('Tem certeza que deseja inativar os colaboradores selecionados?');
      if (confirmacao) {
        $.post("<?php echo site_url('colaboradores/inativar_massa'); ?>", {
          ids: ids
        }, function (data) {
          if (data === 'success') {
            alert('Colaboradores inativados com sucesso.');
            location.reload();
          } else {
            alert('Erro ao inativar colaboradores.');
          }
        });
      }
    } else {
      alert('Selecione pelo menos um colaborador.');
    }
  });

  document.getElementById('btn-ativar-massa').addEventListener('click', function () {
    var ids = [];
    document.querySelectorAll('.selecionar:checked').forEach(function (checkbox) {
      ids.push(checkbox.value);
    });

    if (ids.length > 0) {
      var confirmacao = confirm('Tem certeza que deseja ativar os colaboradores selecionados?');
      if (confirmacao) {
        $.post("<?php echo site_url('colaboradores/ativar_massa'); ?>", {
          ids: ids
        }, function (data) {
          if (data === 'success') {
            alert('Colaboradores ativados com sucesso.');
            location.reload();
          } else {
            alert('Erro ao ativar colaboradores.');
          }
        });
      }
    } else {
      alert('Selecione pelo menos um colaborador.');
    }
  });
</script>

<?php
$this->load->view('templates/footer');
?>