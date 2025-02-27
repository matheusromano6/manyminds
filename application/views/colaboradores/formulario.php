<?php
$data['title'] = isset($colaborador) ? 'Editar Colaborador' : 'Cadastrar Colaborador';
$this->load->view('templates/header', $data);
?>

<div class="mb-3">
  <a href="<?php echo site_url('colaboradores/listar'); ?>" class="btn btn-secondary">
    <i class="fas fa-arrow-left"></i> Voltar para Lista de Colaboradores
  </a>
</div>

<h2><?php echo isset($colaborador) ? 'Editar Colaborador' : 'Cadastrar Colaborador'; ?></h2>

<?php if ($this->session->flashdata('success')): ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <?php echo $this->session->flashdata('success'); ?>
  </div>
<?php endif; ?>

<form action="<?php echo isset($colaborador)
  ? site_url('colaboradores/atualizar/' . $colaborador->id)
  : site_url('colaboradores/salvar'); ?>" method="post">

  <div class="card mb-4">
    <div class="card-header">
      <h4>Dados Pessoais e Profissionais</h4>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="nome">Nome Completo:</label>
            <input type="text" class="form-control uppercase-input" id="nome" name="nome"
              value="<?php echo isset($colaborador) ? $colaborador->nome : ''; ?>" required>
          </div>
          <div class="form-group">
            <label for="cpf">CPF:</label>
            <input type="text" class="form-control" id="cpf" name="cpf"
              value="<?php echo isset($colaborador) ? $colaborador->cpf : ''; ?>" required
              oninput="this.value = this.value.replace(/[^0-9]/g, '');">
          </div>
          <div class="form-group">
            <label for="data_nascimento">Data de Nascimento:</label>
            <input type="date" class="form-control" id="data_nascimento" name="data_nascimento"
              value="<?php echo isset($colaborador) ? $colaborador->data_nascimento : ''; ?>" required>
          </div>
          <div class="form-group">
            <label for="email">E-mail:</label>
            <input type="email" class="form-control uppercase-input" id="email" name="email"
              value="<?php echo isset($colaborador) ? $colaborador->email : ''; ?>" required>
          </div>
          <div class="form-group">
            <label for="telefone">Telefone:</label>
            <input type="text" class="form-control" id="telefone" name="telefone"
              value="<?php echo isset($colaborador) ? $colaborador->telefone : ''; ?>">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="cargo">Cargo:</label>
            <input type="text" class="form-control uppercase-input" id="cargo" name="cargo"
              value="<?php echo isset($colaborador) ? $colaborador->cargo : ''; ?>" required>
          </div>
          <div class="form-group">
            <label for="departamento">Departamento:</label>
            <input type="text" class="form-control uppercase-input" id="departamento" name="departamento"
              value="<?php echo isset($colaborador) ? $colaborador->departamento : ''; ?>" required>
          </div>
          <div class="form-group">
            <label for="salario">Salário:</label>
            <input type="number" step="0.01" class="form-control" id="salario" name="salario"
              value="<?php echo isset($colaborador) ? $colaborador->salario : ''; ?>" required>
          </div>
          <div class="form-group">
            <label for="data_admissao">Data de Admissão:</label>
            <input type="date" class="form-control" id="data_admissao" name="data_admissao"
              value="<?php echo isset($colaborador) ? $colaborador->data_admissao : ''; ?>" required>
          </div>
          <div class="form-group">
            <label for="observacoes">Observações:</label>
            <textarea class="form-control uppercase-input" id="observacoes"
              name="observacoes"><?php echo isset($colaborador) ? $colaborador->observacoes : ''; ?></textarea>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="text-right mb-4">
    <button type="submit" class="btn btn-success">
      <?php echo isset($colaborador) ? 'Salvar Alterações' : 'Cadastrar'; ?>
    </button>
  </div>

  <h4 class="mt-4">Endereços</h4>
  <div id="enderecos-container">
    <?php
    if (isset($enderecos) && !empty($enderecos)):
      $enderecosPrincipais = array_filter($enderecos, function ($e) {
        return $e->padrao === 'sim';
      });
      $enderecosSecundarios = array_filter($enderecos, function ($e) {
        return $e->padrao !== 'sim';
      });
      if (!empty($enderecosPrincipais)):
        foreach ($enderecosPrincipais as $endereco):
          ?>
          <div class="card mb-3 endereco-item" data-endereco-id="<?php echo $endereco->id; ?>">
            <div class="card-header">
              <h5 class="mb-0">Endereço Principal</h5>
            </div>
            <div class="card-body">
              <div class="form-row align-items-center">
                <div class="col-auto">
                  <label>Rua:</label>
                  <input type="text" class="form-control form-control-sm" name="rua[]" value="<?php echo $endereco->rua; ?>"
                    required>
                </div>
                <div class="col-auto">
                  <label>Bairro:</label>
                  <input type="text" class="form-control form-control-sm" name="bairro[]"
                    value="<?php echo $endereco->bairro; ?>" required>
                </div>
                <div class="col-auto">
                  <label>Número:</label>
                  <input type="text" class="form-control form-control-sm" name="numero[]"
                    value="<?php echo $endereco->numero; ?>" required>
                </div>
                <div class="col-auto">
                  <label>Complemento:</label>
                  <input type="text" class="form-control form-control-sm" name="complemento[]"
                    value="<?php echo $endereco->complemento; ?>">
                </div>
                <div class="col-auto">
                  <label>CEP:</label>
                  <input type="text" class="form-control form-control-sm" name="cep[]" value="<?php echo $endereco->cep; ?>"
                    required>
                </div>
                <div class="col-auto">
                  <label>Cidade:</label>
                  <input type="text" class="form-control form-control-sm" name="cidade[]"
                    value="<?php echo $endereco->cidade; ?>" required>
                </div>
                <div class="col-auto">
                  <label>Estado:</label>
                  <input type="text" class="form-control form-control-sm" name="estado[]"
                    value="<?php echo $endereco->estado; ?>" required>
                </div>
                <div class="col-auto">
                  <label>País:</label>
                  <input type="text" class="form-control form-control-sm" name="pais[]" value="<?php echo $endereco->pais; ?>"
                    required>
                </div>
                <div class="col-auto">
                  <label>Principal:</label>
                  <input type="radio" name="padrao[]" value="<?php echo $endereco->id; ?>" class="endereco-principal" checked>
                </div>
              </div>
            </div>
            <div class="card-footer text-right">
              <button type="button" class="btn btn-warning btn-sm"
                onclick="salvarEndereco(<?php echo $endereco->id; ?>)">Atualizar</button>
              <button type="button" class="btn btn-danger btn-sm"
                onclick="excluirEndereco(<?php echo $endereco->id; ?>)">Excluir</button>
            </div>
          </div>
          <?php
        endforeach;
      endif;
      if (!empty($enderecosSecundarios)):
        ?>
        <div class="card mb-3">
          <div class="card-header">
            <h5 class="mb-0">
              Endereços Secundários
              <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse-secundarios"
                aria-expanded="false" aria-controls="collapse-secundarios">
                Mostrar/Ocultar
              </button>
            </h5>
          </div>
          <div class="collapse" id="collapse-secundarios">
            <div class="card-body">
              <?php foreach ($enderecosSecundarios as $endereco): ?>
                <div class="card mb-2 endereco-item" data-endereco-id="<?php echo $endereco->id; ?>">
                  <div class="card-header">
                    <h6 class="mb-0">Endereço</h6>
                  </div>
                  <div class="card-body">
                    <div class="form-row align-items-center">
                      <div class="col-auto">
                        <label>Rua:</label>
                        <input type="text" class="form-control form-control-sm" name="rua[]"
                          value="<?php echo $endereco->rua; ?>" required>
                      </div>
                      <div class="col-auto">
                        <label>Bairro:</label>
                        <input type="text" class="form-control form-control-sm" name="bairro[]"
                          value="<?php echo $endereco->bairro; ?>" required>
                      </div>
                      <div class="col-auto">
                        <label>Número:</label>
                        <input type="text" class="form-control form-control-sm" name="numero[]"
                          value="<?php echo $endereco->numero; ?>" required>
                      </div>
                      <div class="col-auto">
                        <label>Complemento:</label>
                        <input type="text" class="form-control form-control-sm" name="complemento[]"
                          value="<?php echo $endereco->complemento; ?>">
                      </div>
                      <div class="col-auto">
                        <label>CEP:</label>
                        <input type="text" class="form-control form-control-sm" name="cep[]"
                          value="<?php echo $endereco->cep; ?>" required>
                      </div>
                      <div class="col-auto">
                        <label>Cidade:</label>
                        <input type="text" class="form-control form-control-sm" name="cidade[]"
                          value="<?php echo $endereco->cidade; ?>" required>
                      </div>
                      <div class="col-auto">
                        <label>Estado:</label>
                        <input type="text" class="form-control form-control-sm" name="estado[]"
                          value="<?php echo $endereco->estado; ?>" required>
                      </div>
                      <div class="col-auto">
                        <label>País:</label>
                        <input type="text" class="form-control form-control-sm" name="pais[]"
                          value="<?php echo $endereco->pais; ?>" required>
                      </div>
                      <div class="col-auto">
                        <label>Principal:</label>
                        <input type="radio" name="padrao[]" value="<?php echo $endereco->id; ?>" class="endereco-principal">
                      </div>
                    </div>
                  </div>
                  <div class="card-footer text-right">
                    <button type="button" class="btn btn-warning btn-sm"
                      onclick="salvarEndereco(<?php echo $endereco->id; ?>)">Atualizar</button>
                    <button type="button" class="btn btn-danger btn-sm"
                      onclick="excluirEndereco(<?php echo $endereco->id; ?>)">Excluir</button>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
        <?php
      endif;
    else:
      ?>
    <?php endif; ?>
  </div>
  <button type="button" class="btn btn-info mb-3" id="adicionar-endereco">Adicionar Endereço</button>
</form>

<button id="scroll-top" class="btn btn-secondary" style="position: fixed; bottom: 20px; right: 20px; display: none;">
  <i class="fas fa-arrow-up"></i>
</button>

<div id="template-endereco" style="display: none;">
  <div class="card mb-3 endereco-item">
    <div class="card-header">
      <h5 class="mb-0">Novo Endereço</h5>
    </div>
    <div class="card-body">
      <div class="form-row align-items-center">
        <div class="col-auto">
          <label>Rua:</label>
          <input type="text" class="form-control form-control-sm" name="rua[]" required>
        </div>
        <div class="col-auto">
          <label>Bairro:</label>
          <input type="text" class="form-control form-control-sm" name="bairro[]" required>
        </div>
        <div class="col-auto">
          <label>Número:</label>
          <input type="text" class="form-control form-control-sm" name="numero[]" required>
        </div>
        <div class="col-auto">
          <label>Complemento:</label>
          <input type="text" class="form-control form-control-sm" name="complemento[]">
        </div>
        <div class="col-auto">
          <label>CEP:</label>
          <input type="text" class="form-control form-control-sm" name="cep[]" required>
        </div>
        <div class="col-auto">
          <label>Cidade:</label>
          <input type="text" class="form-control form-control-sm" name="cidade[]" required>
        </div>
        <div class="col-auto">
          <label>Estado:</label>
          <input type="text" class="form-control form-control-sm" name="estado[]" required>
        </div>
        <div class="col-auto">
          <label>País:</label>
          <input type="text" class="form-control form-control-sm" name="pais[]" required>
        </div>
        <div class="col-auto">
          <label>Principal:</label>
          <input type="radio" name="padrao[]" value="novo" class="endereco-principal">
        </div>
      </div>
    </div>
    <div class="card-footer text-right">
      <button type="button" class="btn btn-success btn-sm" onclick="salvarNovoEndereco()">Cadastrar Novo
        Endereço</button>
      <button type="button" class="btn btn-secondary btn-sm" onclick="cancelarNovoEndereco(this)">Cancelar</button>
    </div>
  </div>
</div>

<script>
  document.getElementById('adicionar-endereco').addEventListener('click', function () {
    var container = document.getElementById('enderecos-container');
    var template = document.getElementById('template-endereco');
    var clone = template.firstElementChild.cloneNode(true);
    clone.querySelectorAll('input').forEach(function (input) {
      input.value = '';
      if (input.type === 'radio') {
        input.checked = false;
      }
    });
    container.appendChild(clone);
  });

  function cancelarNovoEndereco(btn) {
    var enderecoItem = btn.closest('.endereco-item');
    enderecoItem.remove();
  }

  function salvarNovoEndereco() {
    var enderecoItem = event.target.closest('.endereco-item');
    var dados = {
      colaborador_id: <?php echo isset($colaborador) ? $colaborador->id : 'null'; ?>,
      cep: enderecoItem.querySelector('input[name="cep[]"]').value,
      rua: enderecoItem.querySelector('input[name="rua[]"]').value,
      numero: enderecoItem.querySelector('input[name="numero[]"]').value,
      complemento: enderecoItem.querySelector('input[name="complemento[]"]').value,
      bairro: enderecoItem.querySelector('input[name="bairro[]"]').value,
      cidade: enderecoItem.querySelector('input[name="cidade[]"]').value,
      estado: enderecoItem.querySelector('input[name="estado[]"]').value,
      pais: enderecoItem.querySelector('input[name="pais[]"]').value,
      padrao: enderecoItem.querySelector('input[name="padrao[]"]:checked') ? 'sim' : 'nao'
    };

    $.ajax({
      url: "<?php echo site_url('colaboradores/salvar_endereco'); ?>",
      type: "POST",
      data: dados,
      dataType: "json",
      success: function (response) {
        if (response.status === 'success') {
          mostrarMensagemSucesso('Endereço cadastrado com sucesso!');
          location.reload();
        } else {
          alert("Erro ao cadastrar novo endereço!");
        }
      }
    });
  }

  function mostrarMensagemSucesso(mensagem) {
    var alertDiv = document.createElement('div');
    alertDiv.className = 'alert alert-success alert-dismissible fade show';
    alertDiv.role = 'alert';
    alertDiv.innerHTML = mensagem +
      '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
    document.querySelector('h2').after(alertDiv);
  }

  function salvarEndereco(id) {
    var enderecoItem = event.target.closest('.endereco-item');
    var dados = {
      id: id,
      colaborador_id: <?php echo isset($colaborador) ? $colaborador->id : 'null'; ?>,
      cep: enderecoItem.querySelector('input[name="cep[]"]').value,
      rua: enderecoItem.querySelector('input[name="rua[]"]').value,
      numero: enderecoItem.querySelector('input[name="numero[]"]').value,
      complemento: enderecoItem.querySelector('input[name="complemento[]"]').value,
      bairro: enderecoItem.querySelector('input[name="bairro[]"]').value,
      cidade: enderecoItem.querySelector('input[name="cidade[]"]').value,
      estado: enderecoItem.querySelector('input[name="estado[]"]').value,
      pais: enderecoItem.querySelector('input[name="pais[]"]').value,
      padrao: enderecoItem.querySelector('input[name="padrao[]"]:checked') ? 'sim' : 'nao'
    };
    $.post("<?php echo site_url('colaboradores/atualizar_endereco'); ?>", dados, function (response) {
      if (response === 'success') {
        alert("Endereço " + id + " atualizado com sucesso!");
        location.reload();
      } else {
        alert("Erro ao atualizar o endereço " + id);
      }
    });
  }

  function excluirEndereco(id) {
    if (confirm("Tem certeza que deseja excluir este endereço?")) {
      $.ajax({
        url: "<?php echo site_url('colaboradores/excluir_endereco'); ?>/" + id,
        type: "DELETE",
        success: function (response) {
          if (response === 'success') {
            alert("Endereço " + id + " excluído com sucesso!");
            location.reload();
          } else {
            alert("Erro ao excluir o endereço " + id);
          }
        }
      });
    }
  }

  window.addEventListener('scroll', function () {
    var scrollTopBtn = document.getElementById('scroll-top');
    if (window.pageYOffset > 200) {
      scrollTopBtn.style.display = 'block';
    } else {
      scrollTopBtn.style.display = 'none';
    }
  });

  document.getElementById('scroll-top').addEventListener('click', function () {
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  });

  document.addEventListener("DOMContentLoaded", function () {
    if (window.location.hash === "#enderecos-container") {
      var target = document.getElementById("enderecos-container");
      if (target) {
        window.scrollTo({
          top: target.offsetTop - 80,
          behavior: "smooth"
        });
      }
    }
  });

  document.querySelectorAll('.uppercase-input').forEach(function (input) {
    input.addEventListener('input', function () {
      this.value = this.value.toUpperCase();
    });
  });

</script>

<?php
$this->load->view('templates/footer');
?>