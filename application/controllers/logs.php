<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Logs extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->library('session');
        $this->load->library('pagination');
        $this->load->helper('url');
        $this->load->model('LogsModel');

        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }

    public function listar($page = 0)
    {
        $filtros = array(
            'categoria' => $this->input->get('categoria'),
            'acao' => $this->input->get('acao'),
            'username' => $this->input->get('username'),
            'executado_por' => $this->input->get('executado_por'),
            'status' => $this->input->get('status'),
            'ip_address' => $this->input->get('ip_address'),
            'data_inicio' => $this->input->get('data_inicio'),
            'data_fim' => $this->input->get('data_fim')
        );

        $data['categorias'] = $this->LogsModel->listar_categorias();

        $config['base_url'] = site_url('logs/listar');
        $config['total_rows'] = $this->LogsModel->contar_logs($filtros);
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

        $data['logs'] = $this->LogsModel->listar_logs($filtros, $config['per_page'], $page);
        $data['pagination'] = $this->pagination->create_links();
        $data['title'] = 'Logs do Sistema';

        $this->load->view('logs/listar', $data);
    }

}
