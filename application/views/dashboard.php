<?php
$data['title'] = 'Dashboard - Projeto Manyminds';
$this->load->view('templates/header', $data);
?>

<div class="welcome-msg text-center">
  <h2>Bem-vindo, <?php echo $this->session->userdata('username'); ?>!</h2>
  <p class="mt-5">Você está logado no painel de controle.</p>  
</div>

<?php
$this->load->view('templates/footer');
?>
