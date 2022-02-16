<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';

class User extends REST_Controller
{
    public function __construct()
    {
        parent::__construct('key');
        $model = array('users_model');
        $this->load->model($model);
    }

    public function index_get()
    {
        $data = $this->input->get();

        $this->db->where('deleted', 0);
        if ($data['key'] != "") {
            $this->db->like('name', $data['key']);
        }
        $rows = $this->users_model->num_rows();
        if ($this->input->get('page') !== null) {
            $page = (int) $this->input->get('page') * $data['per_page'];
        }
        $this->db->where('deleted', 0);
        if ($data['key'] != "") {
            $this->db->like('name', $data['key']);
        }
        $this->db->limit($data['per_page'], $page);
        $this->db->select('name, email, created, uuid, status, role');
        $items = $this->users_model->get_all();
        if ($items) {
            $this->response(['status' => true, 'items' => $items, 'num_rows' => $rows], 200);
        } else {
            $this->response(['status' => false, 'items' => [], 'num_rows' => $rows], 200);
        }
    }

    public function index_post()
    {
        $data = $this->post();
        if (self::check_if_mail_exists($data['email']) > 0) $this->response(array('status' => false, 'response' => '¡Este correo electrónico ya se encuentra en uso!'), 201);
        $data['uuid'] = $this->uuid->v4();
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $id = $this->users_model->save($data);
        if (!empty($id)) {
            $this->response(array('status' => true, 'response' => '¡Usuario creado con éxito!'), 201);
        } else {
            $this->response(array('status' => false, 'response' => '¡Ocurrió un error en el servidor!'), 201);
        }
    }

    private function check_if_mail_exists($email)
    {
        $this->db->where('email', $email);
        $query = $this->users_model->num_rows();
        return $query;
    }

    public function index_put($uuid)
    {
        $data = $this->put();
        if ($data['password'] == '') {
            unset($data['password']);
        } else {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        $id = self::get_id($uuid);
        $update = $this->users_model->save($data, $id);
        if (!empty($update)) {
            $this->response(array('status' => true, 'response' => '¡Usuario editado con éxito!'), 201);
        } else {
            $this->response(array('status' => true, 'response' => '¡Ocurrió un error en el servidor!'), 201);
        }
    }

    public function index_delete($uuid)
    {
        $id = self::get_id($uuid);
        $delete = $this->users_model->delete($id);

        if (!is_null($delete)) {
            $this->response(array('status' => true, 'response' => 'Usuario eliminado'), 200);
        } else {
            $this->response(array('status' => false, 'response', 'Ocurrió un error en el servidor...'), 400);
        }
    }

    private function get_id($uuid)
    {
        $this->db->where('uuid', $uuid);
        $this->db->select('id');
        $user = $this->users_model->get_all();
        $user = $user[0];
        return $user->id;
    }
}
