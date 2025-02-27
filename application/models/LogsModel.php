<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LogsModel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function salvar_log($categoria, $acao, $username, $status)
    {
        $data = array(
            'categoria' => $categoria,
            'acao' => $acao,
            'username' => $username,
            'executado_por' => $this->session->userdata('username') ? $this->session->userdata('username') : 'sistema',
            'status' => $status,
            'ip_address' => $this->input->ip_address()
        );

        return $this->db->insert('sistema_logs', $data);
    }
    
    public function listar_categorias()
    {
        $query = $this->db->query("SHOW COLUMNS FROM sistema_logs LIKE 'categoria'");
        $row = $query->row()->Type;
        preg_match('/enum\((.*)\)/', $row, $matches);
        $enum_values = str_getcsv($matches[1], ",", "'");
        return $enum_values;
    }

    public function listar_logs($filtros = [], $limit = 20, $offset = 0)
    {
        if (!empty($filtros['categoria'])) {
            $this->db->where('categoria', $filtros['categoria']);
        }
        if (!empty($filtros['acao']) && strlen($filtros['acao']) >= 3) {
            $this->db->like('acao', $filtros['acao']);
        }
        if (!empty($filtros['username']) && strlen($filtros['username']) >= 3) {
            $this->db->like('username', $filtros['username']);
        }
        if (!empty($filtros['executado_por']) && strlen($filtros['executado_por']) >= 3) {
            $this->db->like('executado_por', $filtros['executado_por']);
        }
        if (!empty($filtros['ip_address']) && strlen($filtros['ip_address']) >= 3) {
            $this->db->like('ip_address', $filtros['ip_address']);
        }
        if (!empty($filtros['status'])) {
            $this->db->where('status', $filtros['status']);
        }
        if (!empty($filtros['data_inicio']) && !empty($filtros['data_fim'])) {
            $this->db->where('created_at >=', $filtros['data_inicio']);
            $this->db->where('created_at <=', $filtros['data_fim']);
        }

        $this->db->order_by('created_at', 'DESC');

        $this->db->limit($limit, $offset);

        $query = $this->db->get('sistema_logs');
        return $query->result();
    }
    public function contar_logs($filtros = [])
    {
        if (!empty($filtros['acao'])) {
            $this->db->like('acao', $filtros['acao']);
        }
        if (!empty($filtros['descricao'])) {
            $this->db->like('descricao', $filtros['descricao']);
        }
        if (!empty($filtros['status'])) {
            $this->db->where('status', $filtros['status']);
        }
        if (!empty($filtros['data_inicio']) && !empty($filtros['data_fim'])) {
            $this->db->where('data_criacao >=', $filtros['data_inicio']);
            $this->db->where('data_criacao <=', $filtros['data_fim']);
        }

        return $this->db->count_all_results('sistema_logs');
    }
}
