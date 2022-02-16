<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Users_model extends MY_Model
{
    protected $_table_name = 'users';
    public $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_timestamps = true;
    protected $soft_delete = true;
    protected $_order_by = '';

    public $belongs_to = array();
    public $_direction = 'asc';

    public $rules = array(
        'name' => array(
            'field'  => 'name',
            'label'  => 'Nombre y Apellido',
            'rules'  => 'required',
            'errors' => array('required' => 'El campo %s es requerido')
        ),
        'role' => array(
            'field'  => 'role',
            'label'  => 'Rol del usuario',
            'rules'  => 'required',
            'errors' => array('required' => 'El campo %s es requerido')
        ),
        'status' => array(
            'field'  => 'status',
            'label'  => 'Estado',
            'rules'  => 'required',
            'errors' => array('required' => 'El campo %s es requerido')
        ),
        'email' => array(
            'field'  => 'email',
            'label'  => 'Correo Electrónico',
            'rules'  => 'required',
            'errors' => array('required' => 'El campo %s es requerido')
        ),
        'password' => array(
            'field'  => 'password',
            'label'  => 'Contraseña',
            'rules'  => 'required',
            'errors' => array('required' => 'El campo %s es requerido')
        ),
    );

    public $update = array(
        'name' => array(
            'field'  => 'name',
            'label'  => 'Nombre y Apellido',
            'rules'  => 'required',
            'errors' => array('required' => 'El campo %s es requerido')
        ),
        'role' => array(
            'field'  => 'role',
            'label'  => 'Rol del usuario',
            'rules'  => 'required',
            'errors' => array('required' => 'El campo %s es requerido')
        ),
        'status' => array(
            'field'  => 'status',
            'label'  => 'Estado',
            'rules'  => 'required',
            'errors' => array('required' => 'El campo %s es requerido')
        ),
        'email' => array(
            'field'  => 'email',
            'label'  => 'Correo Electrónico',
            'rules'  => 'required',
            'errors' => array('required' => 'El campo %s es requerido')
        ),
    );

    function check_unique_user_email($id = '', $email)
    {
        $this->db->where('email', $email);
        if ($id) {
            $this->db->where_not_in('id', $id);
        }
        return $this->db->get('users')->num_rows();
    }

    public function login($email, $password)
    {
        $this->db->where('email', $email);
        $query = $this->db->get('users')->row();
        $info = ['msg' => "Al parecer no estas registrado!", "status" => false];
        if ($query) {
            if (password_verify($password, $query->password)) {
                if ($query->status > 0) {
                    $info = array('data' => $query, "status" => true);
                } else {
                    $info = array('msg' => "Su usuario se encuentra inactivo", "status" => false);
                }
            } else {
                $info = array('msg' => "Contraseña inválida", "status" => false);
            }
        }
        return $info;
    }

    public function admin_login($email, $password)
    {
        $this->db->where('email', $email);
        $this->db->where('role', 9);
        $query = $this->db->get('user')->row();
        $info = ['msg' => "Al parecer no estas registrado!", "status" => false];
        if ($query) {
            if (password_verify($password, $query->password)) {
                if ($query->status > 0) {
                    $info = array('data' => $query, "status" => true);
                } else {
                    $info = array('msg' => "Su usuario se encuentra inactivo", "status" => false);
                }
            } else {
                $info = array('msg' => "Contraseña inválida", "status" => false);
            }
        }
        return $info;
    }

    public function check_item($email)
    {
        $this->db->where('email', $email);
        $query = $this->db->get('users')->num_rows();
        if ($query > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function definitive_delete($id)
    {
        $delete = $this->db->delete('user', ['id' => $id]);
        return $delete;
    }
}
