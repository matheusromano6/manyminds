<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Colaboradores extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('pagination');
        $this->load->model('ColaboradoresModel');
        $this->load->model('LogsModel');

        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }

    public function listar($page = 0)
    {
        $busca = $this->input->get('busca');

        $config['base_url'] = site_url('colaboradores/listar');
        $config['total_rows'] = $this->ColaboradoresModel->contar_colaboradores($busca);
        $config['per_page'] = 20;
        $config['uri_segment'] = 3;
        $config['full_tag_open'] = '<nav><ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul></nav>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_link'] = 'Próximo';
        $config['prev_link'] = 'Anterior';
        $config['attributes'] = array('class' => 'page-link');
        $this->pagination->initialize($config);

        $data['colaboradores'] = $this->ColaboradoresModel->listar_com_filtro($busca, $config['per_page'], $page);
        $data['pagination'] = $this->pagination->create_links();
        $data['title'] = 'Colaboradores';
        $data['busca'] = $busca;

        $username = $this->session->userdata('username') ? $this->session->userdata('username') : 'sistema';

        $this->LogsModel->salvar_log('colaborador_listar', 'Listagem de colaboradores realizada', $username, 'success');

        $this->load->view('colaboradores/listar', $data);
    }

    public function verificar_cpf_existente($cpf)
    {
        $this->db->where('cpf', $cpf);
        $query = $this->db->get('usuarios_colaboradores');
        return $query->num_rows() > 0;
    }

    public function verificar_email_existente($email)
    {
        $this->db->where('email', $email);
        $query = $this->db->get('usuarios_colaboradores');
        return $query->num_rows() > 0;
    }

    public function salvar()
    {
        $data = array(
            'nome' => $this->input->post('nome'),
            'cpf' => $this->input->post('cpf'),
            'email' => $this->input->post('email'),
            'telefone' => $this->input->post('telefone'),
            'data_nascimento' => $this->input->post('data_nascimento'),
            'cargo' => $this->input->post('cargo'),
            'departamento' => $this->input->post('departamento'),
            'salario' => $this->input->post('salario'),
            'data_admissao' => $this->input->post('data_admissao'),
            'observacoes' => $this->input->post('observacoes')
        );

        $cpf = $this->input->post('cpf');
        $email = $this->input->post('email');

        if ($this->verificar_cpf_existente($cpf)) {
            $this->session->set_flashdata('error', 'Este CPF já está cadastrado.');
            $this->LogsModel->salvar_log('colaborador_salvar', 'Erro: CPF duplicado', $cpf, 'failed');
            redirect('colaboradores/cadastrar');
        }
        if ($this->verificar_email_existente($email)) {
            $this->session->set_flashdata('error', 'Este E-mail já está cadastrado.');
            $this->LogsModel->salvar_log('colaborador_salvar', 'Erro: E-mail duplicado', $email, 'failed');
            redirect('colaboradores/cadastrar');
        }

        $colaborador_id = $this->ColaboradoresModel->salvar($data);
        $this->LogsModel->salvar_log('colaborador_cadastro', 'Colaborador cadastrado', $colaborador_id, 'success');

        $ceps = $this->input->post('cep');
        $ruas = $this->input->post('rua');
        $numeros = $this->input->post('numero');
        $complementos = $this->input->post('complemento');
        $bairros = $this->input->post('bairro');
        $cidades = $this->input->post('cidade');
        $estados = $this->input->post('estado');
        $paises = $this->input->post('pais');
        $padrao = $this->input->post('padrao');

        if (is_array($ceps) && count($ceps) > 0) {
            for ($i = 0; $i < count($ceps); $i++) {
                $endereco = array(
                    'colaborador_id' => $colaborador_id,
                    'cep' => $ceps[$i],
                    'rua' => $ruas[$i],
                    'numero' => $numeros[$i],
                    'complemento' => $complementos[$i],
                    'bairro' => $bairros[$i],
                    'cidade' => $cidades[$i],
                    'estado' => $estados[$i],
                    'pais' => $paises[$i],
                    'padrao' => isset($padrao[$i]) ? $padrao[$i] : 'nao'
                );
                $this->ColaboradoresModel->salvar_endereco($endereco);
                $this->LogsModel->salvar_log('endereco_salvar', 'Endereço cadastrado', $colaborador_id, 'success');
            }
        }

        $this->session->set_flashdata('success', 'Colaborador cadastrado com sucesso!');

        redirect(site_url('colaboradores/editar/' . $colaborador_id));
    }

    public function salvar_endereco()
    {
        $colaborador_id = $this->input->post('colaborador_id');
        $cep = $this->input->post('cep');
        $rua = $this->input->post('rua');
        $numero = $this->input->post('numero');
        $complemento = $this->input->post('complemento');
        $bairro = $this->input->post('bairro');
        $cidade = $this->input->post('cidade');
        $estado = $this->input->post('estado');
        $pais = $this->input->post('pais');
        $padrao = $this->input->post('padrao');

        if ($padrao === 'sim') {
            $this->ColaboradoresModel->inativar_enderecos_padrao($colaborador_id);
        }

        $data = array(
            'colaborador_id' => $colaborador_id,
            'cep' => $cep,
            'rua' => $rua,
            'numero' => $numero,
            'complemento' => $complemento,
            'bairro' => $bairro,
            'cidade' => $cidade,
            'estado' => $estado,
            'pais' => $pais,
            'padrao' => $padrao
        );

        $result = $this->ColaboradoresModel->salvar_endereco($data);

        if ($result) {
            $this->LogsModel->salvar_log('endereco_salvar', 'Endereço cadastrado/atualizado', $colaborador_id, 'success');

            $this->session->set_flashdata('success', 'Endereço cadastrado com sucesso!');

            echo json_encode(['status' => 'success']);
        } else {
            $this->LogsModel->salvar_log('endereco_salvar', 'Erro ao salvar endereço', $colaborador_id, 'failed');

            echo json_encode(['status' => 'error']);
        }
    }

    public function excluir_endereco($id)
    {
        if ($this->ColaboradoresModel->deletar_endereco($id)) {
            $this->LogsModel->salvar_log('endereco_excluir', 'Endereço excluído', $id, 'success');
            echo 'success';
        } else {
            $this->LogsModel->salvar_log('endereco_excluir', 'Erro ao excluir endereço', $id, 'failed');
            echo 'error';
        }
    }

    public function atualizar($id)
    {
        $data = array(
            'nome' => $this->input->post('nome'),
            'email' => $this->input->post('email'),
            'telefone' => $this->input->post('telefone')
        );

        if ($this->ColaboradoresModel->atualizar($id, $data)) {
            $this->LogsModel->salvar_log('colaborador_atualizacao', 'Colaborador atualizado', $id, 'success');

            $ceps = $this->input->post('cep');
            $ruas = $this->input->post('rua');
            $numeros = $this->input->post('numero');
            $complementos = $this->input->post('complemento');
            $bairros = $this->input->post('bairro');
            $cidades = $this->input->post('cidade');
            $estados = $this->input->post('estado');
            $paises = $this->input->post('pais');
            $padrao = $this->input->post('padrao');

            if (is_array($ceps) && count($ceps) > 0) {
                for ($i = 0; $i < count($ceps); $i++) {
                    $endereco = array(
                        'colaborador_id' => $id,
                        'cep' => $ceps[$i],
                        'rua' => $ruas[$i],
                        'numero' => $numeros[$i],
                        'complemento' => $complementos[$i],
                        'bairro' => $bairros[$i],
                        'cidade' => $cidades[$i],
                        'estado' => $estados[$i],
                        'pais' => $paises[$i],
                        'padrao' => isset($padrao[$i]) ? $padrao[$i] : 'nao'
                    );
                    $this->ColaboradoresModel->atualizar_endereco($id, $endereco);
                    $this->LogsModel->salvar_log('endereco_atualizar', 'Endereço atualizado', $id, 'success');
                }
            }

            $this->session->set_flashdata('success', 'Colaborador atualizado com sucesso!');
        } else {
            $this->LogsModel->salvar_log('colaborador_atualizar', 'Erro ao atualizar colaborador', $id, 'failed');
            $this->session->set_flashdata('error', 'Colaborador inativado não pode ser editado.');
        }

        redirect('colaboradores/listar');
    }

    public function cadastrar()
    {
        $data['title'] = 'Cadastrar Colaborador';
        $this->LogsModel->salvar_log('colaborador_acessar', 'Acessou tela de cadastro', '', 'success');
        $this->load->view('colaboradores/formulario', $data);
    }

    public function editar($id)
    {
        $colaborador = $this->ColaboradoresModel->buscar_por_id($id);

        if (!$colaborador) {
            $this->session->set_flashdata('error', 'Colaborador não encontrado.');
            $this->LogsModel->salvar_log('colaborador_editar', 'Colaborador não encontrado', $id, 'failed');
            redirect('colaboradores/listar');
        }

        $data['colaborador'] = $colaborador;
        $data['enderecos'] = $this->ColaboradoresModel->listar_enderecos($colaborador->id);
        $data['title'] = 'Editar Colaborador';

        $data['success'] = $this->session->flashdata('success');

        $this->LogsModel->salvar_log('colaborador_edicao', 'Acessou tela de edição', $id, 'success');
        $this->load->view('colaboradores/formulario', $data);
    }


    public function excluir($id)
    {
        if ($this->ColaboradoresModel->excluir($id)) {
            $this->LogsModel->salvar_log('colaborador_inativar', 'Colaborador inativado', $id, 'success');
            $this->session->set_flashdata('success', 'Colaborador inativado com sucesso.');
        } else {
            $this->LogsModel->salvar_log('colaborador_inativar', 'Erro ao inativar colaborador', $id, 'failed');
            $this->session->set_flashdata('error', 'Erro ao inativar colaborador.');
        }
        redirect('colaboradores/listar');
    }

    public function inativar_individual()
    {
        $id = $this->input->post('id');
        if ($id) {
            $this->ColaboradoresModel->inativar_massa(array($id));
            $this->LogsModel->salvar_log('colaborador_inativar', 'Colaborador inativado individualmente', $id, 'success');
            echo 'success';
        } else {
            echo 'error';
        }
    }

    public function alterar_status()
    {
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        if ($id && ($status == 'active' || $status == 'inactive')) {
            $this->ColaboradoresModel->alterar_status($id, $status);
            $this->LogsModel->salvar_log('colaborador_alterar_status', 'Status alterado', $id, 'success');
            echo 'success';
        } else {
            $this->LogsModel->salvar_log('colaborador_alterar_status', 'Erro ao alterar status', $id, 'failed');
            echo 'error';
        }
    }

    public function inativar_massa()
    {
        $ids = $this->input->post('ids');
        if (!empty($ids)) {
            $this->ColaboradoresModel->alterar_status_massa($ids, 'inactive');
            $this->LogsModel->salvar_log('colaborador_inativacao', 'Colaboradores inativados em massa', implode(',', $ids), 'success');
            echo 'success';
        } else {
            echo 'error';
        }
    }

    public function ativar_massa()
    {
        $ids = $this->input->post('ids');
        if (!empty($ids)) {
            $this->ColaboradoresModel->alterar_status_massa($ids, 'active');
            $this->LogsModel->salvar_log('colaborador_ativacao', 'Colaboradores ativados em massa', implode(',', $ids), 'success');
            echo 'success';
        } else {
            echo 'error';
        }
    }
}
