<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ColaboradoresModel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    public function listar($limit, $offset)
    {
        $this->db->select('uc.*, ec.rua, ec.numero, ec.complemento, ec.bairro, ec.cidade, ec.estado, ec.pais, ec.cep');
        $this->db->from('usuarios_colaboradores uc');
        $this->db->join('enderecos_colaboradores ec', 'uc.id = ec.colaborador_id AND ec.padrao = "sim"', 'left');
        $this->db->order_by('uc.id', 'ASC');
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        return $query->result();
    }
    public function listar_com_filtro($busca = '', $limit = 20, $offset = 0)
    {
        $this->db->select('uc.*, ec.rua, ec.numero, ec.complemento, ec.bairro, ec.cidade, ec.estado, ec.pais, ec.cep');
        $this->db->from('usuarios_colaboradores uc');
        $this->db->join('enderecos_colaboradores ec', 'uc.id = ec.colaborador_id AND ec.padrao = "sim"', 'left');

        if ($busca) {
            $this->db->group_start();
            $this->db->like('uc.nome', $busca);
            $this->db->or_like('uc.email', $busca);
            $this->db->or_like('uc.telefone', $busca);
            $this->db->or_like('uc.cpf', $busca);
            $this->db->or_like('uc.cargo', $busca);
            $this->db->or_like('uc.departamento', $busca);
            $this->db->or_like('ec.rua', $busca);
            $this->db->or_like('ec.bairro', $busca);
            $this->db->or_like('ec.cidade', $busca);
            $this->db->or_like('ec.estado', $busca);
            $this->db->or_like('ec.cep', $busca);
            $this->db->group_end();
        }

        $this->db->order_by('uc.id', 'ASC');
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        return $query->result();
    }
    public function buscar_colaboradores($busca)
    {
        $this->db->like('nome', $busca);
        $this->db->or_like('email', $busca);
        $this->db->or_like('telefone', $busca);
        $this->db->or_like('cpf', $busca);
        $this->db->or_like('cargo', $busca);
        $this->db->or_like('departamento', $busca);
        $query = $this->db->get('usuarios_colaboradores');
        return $query->result();
    }
    public function listar_colaboradores()
    {
        $query = $this->db->get('usuarios_colaboradores');
        return $query->result();
    }
    public function listar_todos()
    {
        $this->db->select('id, nome, cpf, email, telefone, data_nascimento, cargo, departamento, salario, data_admissao, observacoes, status');
        $this->db->from('usuarios_colaboradores');
        $query = $this->db->get();
        return $query->result();
    }
    public function contar_colaboradores($busca = '')
    {
        if ($busca) {
            $this->db->like('nome', $busca);
            $this->db->or_like('email', $busca);
            $this->db->or_like('telefone', $busca);
            $this->db->or_like('cpf', $busca);
            $this->db->or_like('cargo', $busca);
            $this->db->or_like('departamento', $busca);
        }
        return $this->db->count_all_results('usuarios_colaboradores');
    }
    public function salvar($data)
    {
        $this->db->insert('usuarios_colaboradores', $data);
        return $this->db->insert_id();
    }
    public function atualizar($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->where('status', 'active');
        return $this->db->update('usuarios_colaboradores', $data);
    }
    public function excluir($id)
    {
        $this->db->where('id', $id);
        return $this->db->update('usuarios_colaboradores', array('status' => 'inactive'));
    }
    public function alterar_status($id, $status)
    {
        $this->db->where('id', $id);
        return $this->db->update('usuarios_colaboradores', array('status' => $status));
    }
    public function alterar_status_massa($ids, $status)
    {
        $this->db->where_in('id', $ids);
        return $this->db->update('usuarios_colaboradores', array('status' => $status));
    }
    public function buscar_por_id($id)
    {
        $this->db->select('uc.*, ec.id as endereco_id, ec.cep, ec.rua, ec.numero, ec.complemento, ec.bairro, ec.cidade, ec.estado, ec.pais, ec.padrao');
        $this->db->from('usuarios_colaboradores uc');
        $this->db->join('enderecos_colaboradores ec', 'uc.id = ec.colaborador_id', 'left');
        $this->db->where('uc.id', $id);
        $query = $this->db->get();

        return $query->row();
    }

    public function listar_enderecos($colaborador_id)
    {
        $this->db->where('colaborador_id', $colaborador_id);
        $query = $this->db->get('enderecos_colaboradores');
        return $query->result();
    }
    public function atualizar_endereco($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('enderecos_colaboradores', $data);
    }

    public function salvar_endereco($data)
    {
        if (isset($data['id'])) {
            $this->db->where('id', $data['id']);
            return $this->db->update('enderecos_colaboradores', $data);
        }
        return $this->db->insert('enderecos_colaboradores', $data);
    }
    public function inativar_enderecos_padrao($colaborador_id)
    {
        $this->db->where('colaborador_id', $colaborador_id);
        $this->db->update('enderecos_colaboradores', array('padrao' => 'nao'));
    }
    public function deletar_endereco($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('enderecos_colaboradores');
    }

}
