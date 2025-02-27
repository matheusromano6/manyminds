<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');

        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }
    public function token()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }

        $username = $this->session->userdata('username');

        $this->db->select('api_token');
        $this->db->from('users');
        $this->db->where('username', $username);
        $query = $this->db->get();
        $result = $query->row();

        echo "Token de API: " . $result->api_token;
    }
    public function index()
    {
        $data['title'] = 'Dashboard';
        $this->load->view('dashboard', $data);
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('login');
    }
}
