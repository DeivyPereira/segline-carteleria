<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';

class Tv extends REST_Controller
{
    public function __construct()
    {
        parent::__construct('key');
        $model = array('tv_model');
        $this->load->model($model);
    }

    public function index_get()
    {
        $data = $this->input->get();

        $this->db->where('deleted', 0);
        if ($data['key'] != "") {
            $this->db->like('name', $data['key']);
        }
        $rows = $this->tv_model->num_rows();
        if ($this->input->get('page') !== null) {
            $page = (int) $this->input->get('page') * $data['per_page'];
        }
        $this->db->where('deleted', 0);
        if ($data['key'] != "") {
            $this->db->like('name', $data['key']);
        }
        $this->db->limit($data['per_page'], $page);
        $this->db->select('id, name, description, created, uuid, status, sede');
        $items = $this->tv_model->get_all();
        if ($items) {
            $this->response(['status' => true, 'items' => $items, 'num_rows' => $rows], 200);
        } else {
            $this->response(['status' => false, 'items' => [], 'num_rows' => $rows], 200);
        }
    }

    public function index_post()
    {
        $data = $this->post();
        $data['uuid'] = $this->uuid->v4();
        $id = $this->tv_model->save($data);
        if (!empty($id)) {
            $this->response(array('status' => true, 'response' => '¡El televisor ha sido agregado!'), 201);
        } else {
            $this->response(array('status' => false, 'response' => '¡Ocurrió un error en el servidor!'), 201);
        }
    }

    public function index_put($uuid)
    {
        $data = $this->put();
        $id = self::get_id($uuid);
        $update = $this->tv_model->save($data, $id);
        if (!empty($update)) {
            $this->response(array('status' => true, 'response' => '¡Información actualizada!'), 201);
        } else {
            $this->response(array('status' => true, 'response' => '¡Ocurrió un error en el servidor!'), 201);
        }
    }

    public function index_delete($uuid)
    {
        $id = self::get_id($uuid);
        $delete = $this->tv_model->delete($id);

        if (!is_null($delete)) {
            $this->response(array('status' => true, 'response' => '¡Televisor eliminado!'), 200);
        } else {
            $this->response(array('status' => false, 'response', 'Ocurrió un error en el servidor...'), 400);
        }
    }

    public function by_sede_get($int)
    {
        $this->db->where('sede', $int);
        $items = $this->tv_model->get_all();
        if (!empty($items)) {
            $this->response(['status' => true, 'items' => $items], 200);
        } else {
            $this->response(['status' => false, 'items' => []], 200);
        }
    }

    private function get_id($uuid)
    {
        $this->db->where('uuid', $uuid);
        $this->db->select('id');
        $user = $this->tv_model->get_all();
        $user = $user[0];
        return $user->id;
    }
}
