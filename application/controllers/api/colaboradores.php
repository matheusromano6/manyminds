// application/controllers/api/Colaboradores.php
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Colaboradores extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('ColaboradoresModel');
        $this->load->helper('url');
    }

    public function index()
    {
        $token = $this->input->get_request_header('Authorization');

        if (!$this->validar_token($token)) {
            $this->output
                ->set_status_header(401)
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'error', 'message' => 'Token Inválido']));
            return;
        }
        $colaboradores = $this->ColaboradoresModel->listar_colaboradores();

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($colaboradores));
    }
    private function validar_token($token)
    {
        $this->db->where('api_token', $token);
        $query = $this->db->get('users');
        return $query->num_rows() > 0;
    }
}
