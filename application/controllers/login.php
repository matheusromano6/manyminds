<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->database();
        $this->load->model('UserModel');
        $this->load->model('LogsModel');
    }

    public function gerar_token_api($username)
    {
        $token = bin2hex(random_bytes(32));
        $this->db->set('api_token', $token);
        $this->db->where('username', $username);
        $this->db->update('users');
        return $token;
    }
    public function index()
    {
        $ip = $this->input->ip_address();
        $data['tempo_espera'] = 0;

        $query = $this->db->get_where('users', array('ip_locked' => $ip));
        $user = $query->row();

        if ($user && $user->lock_time > date('Y-m-d H:i:s')) {
            $tempo_restante = strtotime($user->lock_time) - time();
            $data['tempo_espera'] = $tempo_restante;
        }

        $this->load->view('login', $data);
    }


    public function register()
    {
        $name = $this->input->post('name');
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        if ($this->UserModel->check_username_exists($username)) {
            $this->session->set_flashdata('error', 'Nome de usuário já está em uso.');
            redirect('login');
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $token = bin2hex(random_bytes(32));

            $data = array(
                'name' => $name,
                'username' => $username,
                'password' => $hashed_password,
                'status' => 'active',
                'api_token' => $token
            );

            if ($this->UserModel->register($data)) {
                echo "
                    <html>
                    <head>
                        <meta charset='UTF-8'>
                        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                        <title>Registro Bem-sucedido</title>
                        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css'>
                        <style>
                            body {
                                background: #f8f9fa;
                                display: flex;
                                justify-content: center;
                                align-items: center;
                                height: 100vh;
                                text-align: center;
                            }
                            .success-container {
                                background: #fff;
                                padding: 30px;
                                border-radius: 10px;
                                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                                max-width: 400px;
                                width: 100%;
                            }
                            .success-container img {
                                max-width: 120px;
                                margin-bottom: 20px;
                            }
                            .success-container h3 {
                                color: #28a745;
                                margin-bottom: 20px;
                            }
                            .token-box {
                                background: #f1f1f1;
                                padding: 15px;
                                border-radius: 5px;
                                word-break: break-all;
                                font-size: 14px;
                                margin-bottom: 20px;
                            }
                            .btn-login {
                                background: #007bff;
                                color: #fff;
                                border: none;
                                padding: 10px 20px;
                                border-radius: 5px;
                                text-decoration: none;
                            }
                            .btn-login:hover {
                                background: #0056b3;
                            }
                        </style>
                    </head>
                    <body>
                        <div class='success-container'>
                            <!-- Logo Centralizado -->
                            <img src='" . base_url('assets/images/logo_manyminds.jpeg') . "' alt='Logo'>
                            
                            <!-- Mensagem de Sucesso -->
                            <h3>Registro realizado com sucesso!</h3>
                            <p>Seu Token de API é:</p>
                            <div class='token-box'>{$token}</div>
                            <p><strong>Guarde este token com segurança.</strong></br> Ele será necessário para consumir a API.</p>
                            
                            <!-- Botão de Login -->
                            <a href='" . site_url('login') . "' class='btn-login'>Fazer Login</a>
                        </div>
                    </body>
                    </html>
                ";
            } else {
                $this->session->set_flashdata('error', 'Erro ao registrar o usuário. Tente novamente.');
                redirect('login');
            }

        }
    }

    public function authenticate()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $ip = $this->input->ip_address();

        if ($this->UserModel->verificar_ip_bloqueado($username, $ip)) {
            $this->LogsModel->salvar_log('login', 'Tentativa de acesso com IP bloqueado', $username, 'blocked');
            $this->session->set_flashdata('error', 'Seu IP está temporariamente bloqueado. Tente novamente mais tarde.');
            redirect('login');
        }

        $query = $this->db->get_where('users', array('username' => $username, 'status' => 'active'));
        $user = $query->row();

        if ($user) {
            if (password_verify($password, $user->password)) {
                $this->session->set_userdata(array('user_id' => $user->id, 'username' => $user->username, 'logged_in' => TRUE));

                $this->UserModel->resetar_tentativas($username);

                $this->LogsModel->salvar_log('login', 'Login bem-sucedido', $username, 'success');
                redirect('dashboard');
            } else {
                $this->UserModel->incrementar_tentativa($username, $ip);

                $this->LogsModel->salvar_log('login', 'Senha incorreta', $username, 'failed');
                $this->session->set_flashdata('error', 'Senha incorreta.');
            }
        } else {
            $this->LogsModel->salvar_log('login', 'Usuário não encontrado', $username, 'failed');
            $this->session->set_flashdata('error', 'Usuário não encontrado.');
        }

        redirect('login');
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('login');
    }
}
