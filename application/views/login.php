<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Projeto Manyminds</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
</head>

<body>
  <div class="login-container">
    <img src="<?php echo base_url('assets/images/logo_manyminds.jpeg'); ?>" alt="Logo" class="login-image">
    <h5>Login</h5>

    <?php if ($this->session->flashdata('error')): ?>
      <div class="alert alert-danger">
        <?php echo $this->session->flashdata('error'); ?>
      </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('success')): ?>
      <div class="alert alert-success">
        <?php echo $this->session->flashdata('success'); ?>
      </div>
    <?php endif; ?>

    <?php if (isset($tempo_espera) && $tempo_espera > 0): ?>
      <div class="alert alert-danger">
        Seu IP está temporariamente bloqueado. Tente novamente em <span id="contador"><?php echo $tempo_espera; ?></span>
        segundos.
      </div>
    <?php else: ?>
      <form id="loginForm" action="<?php echo base_url('login/authenticate'); ?>" method="post">
        <div class="form-group">
          <label for="username">Usuário:</label>
          <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="form-group">
          <label for="password">Senha:</label>
          <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Entrar</button>
        <a href="#" class="register-link" data-toggle="modal" data-target="#registerModal">Registrar-se</a>
      </form>
    <?php endif; ?>
  </div>

  <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="registerModalLabel">Registrar-se</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="registerForm" action="<?php echo site_url('login/register'); ?>" method="post">
            <div class="form-group">
              <label for="reg_name">Nome Completo:</label>
              <input type="text" class="form-control" id="reg_name" name="name" required>
            </div>
            <div class="form-group">
              <label for="reg_username">Usuário:</label>
              <input type="text" class="form-control" id="reg_username" name="username" required>
            </div>
            <div class="form-group">
              <label for="reg_password">Senha:</label>
              <input type="password" class="form-control" id="reg_password" name="password" required>
            </div>
            <button type="submit" class="btn btn-success">Registrar</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <style>
    body {
      background: #f8f9fa;
    }

    .login-container {
      max-width: 400px;
      margin: 50px auto;
      background: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .login-container h5 {
      text-align: center;
      margin-bottom: 20px;
    }

    .form-group label {
      font-weight: bold;
    }

    .form-group input {
      border-radius: 5px;
    }

    .btn-primary {
      width: 100%;
      border-radius: 5px;
    }

    .register-link {
      display: block;
      text-align: center;
      margin-top: 15px;
    }

    .login-image {
      display: block;
      margin: 0 auto 20px auto;
      max-width: 150px;
      height: auto;
    }
  </style>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      var tempo_espera = <?php echo isset($tempo_espera) ? $tempo_espera : 0; ?>;
      var contador = document.getElementById('contador');

      if (tempo_espera > 0) {
        var intervalo = setInterval(function () {
          tempo_espera--;
          contador.textContent = tempo_espera;

          if (tempo_espera <= 0) {
            clearInterval(intervalo);
            window.location.href = "<?php echo site_url('login'); ?>";
          }
        }, 1000);
      }
    });
  </script>
</body>

</html>