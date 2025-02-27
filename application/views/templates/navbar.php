<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="<?php echo site_url('dashboard'); ?>">Manyminds</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="<?php echo site_url('dashboard'); ?>">Dashboard</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="colaboradoresMenu" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Colaboradores
        </a>
        <div class="dropdown-menu" aria-labelledby="colaboradoresMenu">
          <a class="dropdown-item" href="<?php echo site_url('colaboradores/cadastrar'); ?>">Cadastrar Colaborador</a>
          <a class="dropdown-item" href="<?php echo site_url('colaboradores/listar'); ?>">Listar Colaboradores</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo site_url('dashboard/logout'); ?>">Logout</a>
      </li>
    </ul>
  </div>
</nav>
