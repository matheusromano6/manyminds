<?php
$data['title'] = 'Logs do Sistema';
$this->load->view('templates/header', $data);
?>

<h2 class="mb-4">Logs do Sistema</h2>

<form method="get" action="<?php echo site_url('logs/listar'); ?>" class="mb-4">
    <div class="row">
        <div class="col-md-2">
            <select name="categoria" class="form-control">
                <option value="">Categoria</option>
                <?php foreach ($categorias as $categoria): ?>
                    <option value="<?php echo $categoria; ?>" <?php echo ($this->input->get('categoria') == $categoria) ? 'selected' : ''; ?>>
                        <?php echo ucfirst(str_replace('_', ' ', $categoria)); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-2">
            <input type="text" name="acao" class="form-control" placeholder="Ação (mín. 3 caracteres)"
                value="<?php echo $this->input->get('acao'); ?>">
        </div>
        <div class="col-md-2">
            <input type="text" name="username" class="form-control" placeholder="Username (mín. 3 caracteres)"
                value="<?php echo $this->input->get('username'); ?>">
        </div>
        <div class="col-md-2">
            <input type="text" name="executado_por" class="form-control" placeholder="Executado Por (mín. 3 caracteres)"
                value="<?php echo $this->input->get('executado_por'); ?>">
        </div>
        <div class="col-md-2">
            <select name="status" class="form-control">
                <option value="">Status</option>
                <option value="success" <?php echo ($this->input->get('status') == 'success') ? 'selected' : ''; ?>>
                    Success</option>
                <option value="failed" <?php echo ($this->input->get('status') == 'failed') ? 'selected' : ''; ?>>Failed
                </option>
            </select>
        </div>
        <div class="col-md-2">
            <input type="text" name="ip_address" class="form-control" placeholder="IP Address (mín. 3 caracteres)"
                value="<?php echo $this->input->get('ip_address'); ?>">
        </div>
        <div class="col-md-2 mt-2">
            <button type="submit" class="btn btn-primary btn-block">Filtrar</button>
        </div>
    </div>
</form>

<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover">
        <thead class="thead-dark text-center">
            <tr>
                <th>ID</th>
                <th>Categoria</th>
                <th>Ação</th>
                <th>Username</th>
                <th>Executado Por</th>
                <th>Status</th>
                <th>IP Address</th>
                <th>Data/Hora</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($logs)): ?>
                <?php foreach ($logs as $log): ?>
                    <tr>
                        <td class="text-center"><?php echo $log->id; ?></td>
                        <td><?php echo $log->categoria; ?></td>
                        <td><?php echo $log->acao; ?></td>
                        <td><?php echo $log->username; ?></td>
                        <td><?php echo $log->executado_por; ?></td>
                        <td class="text-center">
                            <?php echo $log->status == 'success'
                                ? '<span class="badge badge-success">Success</span>'
                                : '<span class="badge badge-danger">Failed</span>'; ?>
                        </td>
                        <td><?php echo $log->ip_address; ?></td>
                        <td class="text-center"><?php echo date('d/m/Y H:i:s', strtotime($log->created_at)); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="text-center">Nenhum log encontrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="mt-4">
    <?php echo $pagination; ?>
</div>

<?php
$this->load->view('templates/footer');
?>