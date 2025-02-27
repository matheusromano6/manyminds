<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $title; ?></title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <style>
    body,
    html {
      height: 100%;
    }

    .wrapper {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    .content {
      flex: 1;
      display: flex;
    }

    .sidebar {
      width: 180px;
      background: #343a40;
      min-height: 100vh;
      padding: 20px;
      color: #fff;
    }

    .sidebar a {
      color: #ccc;
      text-decoration: none;
      display: block;
      padding: 10px;
      border-radius: 4px;
      margin-bottom: 5px;
    }

    .sidebar a:hover,
    .sidebar a.active {
      background: #495057;
      color: #fff;
    }

    .main-content {
      flex: 1;
      padding: 20px;
    }
  </style>
</head>

<body>
  <div class="wrapper">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <a class="navbar-brand" href="<?php echo site_url('dashboard'); ?>">Manyminds</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="<?php echo site_url('dashboard'); ?>">Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo site_url('dashboard/logout'); ?>">Logout</a>
          </li>
        </ul>
      </div>
    </nav>

    <div class="content">
      <div class="sidebar">
        <h4>Menu</h4>
        <a href="<?php echo site_url('colaboradores/listar'); ?>"
          class="<?php echo ($this->uri->segment(1) == 'colaboradores') ? 'active' : ''; ?>">Colaboradores</a>
        <a href="<?php echo site_url('logs/listar'); ?>"
          class="<?php echo ($this->uri->segment(1) == 'logs') ? 'active' : ''; ?>">Logs do Sistema</a>
      </div>
      <div class="main-content">