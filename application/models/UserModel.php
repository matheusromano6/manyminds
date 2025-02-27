<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UserModel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function register($data)
    {
        return $this->db->insert('users', $data);
    }
    public function check_username_exists($username)
    {
        $query = $this->db->get_where('users', array('username' => $username));
        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function get_user_by_username($username)
    {
        $query = $this->db->get_where('users', array('username' => $username, 'status' => 'active'));
        return $query->row();
    }
    public function verificar_ip_bloqueado($username, $ip)
    {
        $this->db->where('username', $username);
        $this->db->where('ip_locked', $ip);
        $this->db->where('lock_time >', date('Y-m-d H:i:s'));
        $query = $this->db->get('users');

        return $query->num_rows() > 0;
    }

    public function incrementar_tentativa($username, $ip)
    {
        $this->db->set('failed_attempts', 'failed_attempts+1', FALSE);
        $this->db->where('username', $username);
        $this->db->update('users');

        $this->db->select('failed_attempts');
        $this->db->where('username', $username);
        $query = $this->db->get('users');
        $user = $query->row();

        if ($user && $user->failed_attempts >= 3) {
            $this->db->set('ip_locked', $ip);
            $this->db->set('lock_time', date('Y-m-d H:i:s', strtotime('+1 minute')));
            $this->db->where('username', $username);
            $this->db->update('users');
        }
    }

    public function resetar_tentativas($username)
    {
        $this->db->set('failed_attempts', 0);
        $this->db->set('ip_locked', NULL);
        $this->db->set('lock_time', NULL);
        $this->db->where('username', $username);
        $this->db->update('users');
    }
}
