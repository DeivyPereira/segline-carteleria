<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';

class Multimedia extends REST_Controller
{
    public function __construct()
    {
        parent::__construct('key');
        $model = array('multimedia_model');
        $this->load->model($model);
    }

    public function index_get()
    {
        $data = $this->input->get();
        //$this->db->where('deleted', 0);
        if ($data['search'] != "") {
            $this->db->like('name', $data['search']);
        }
        $rows = $this->multimedia_model->num_rows();

        if ($this->input->get('page') !== null) {
            $page = (int) $this->input->get('page') * $data['per_page'];
        }

        //$this->db->where('deleted', 0);
        if ($data['search'] != "") {
            $this->db->like('name', $data['search']);
        }
        $this->db->limit($data['per_page'], $page);
        $this->db->select('name, uuid');
        $items = $this->multimedia_model->get_all();
        if ($items) {
            $this->response(['status' => true, 'items' => $items, 'num_rows' => $rows], 200);
        } else {
            $this->response(['status' => false, 'items' => [], 'num_rows' => $rows], 200);
        }
    }

    public function index_post()
    {
		$field = 'file'; // The name attribute of the file input control.
		$file_selected = isset($_FILES[$field]) && isset($_FILES[$field]['name']) && $_FILES[$field]['name'] != '';
        $config['upload_path']          = './uploads/';
        $config['allowed_types']        = 'gif|jpg|png|jpeg|mp4|mov|wmv|mpg';
        if ($this->load->library('upload', $config)) {
            if ($this->upload->do_upload('file')) {
                $data = [
                    'uuid' => $this->uuid->v4(),
                    'name' => $this->upload->data('file_name')
                ];
                $this->multimedia_model->save($data);
                $this->response(['status' => true, 'response' => $this->upload->data()]);
            } else {
                $this->response(['status' => false, 'response' =>$this->upload->display_errors()]);
                //$this->response(['status' => false, 'response' => $this->upload->data()]);
            }
        }
    }

    public function index_delete($uuid)
    {
        $id = self::get_id($uuid);
        $multimedia = $this->multimedia_model->get($id);
        if (unlink('./uploads/' . $multimedia->name)) {
            $remove = $this->multimedia_model->delete($id);
            if (!empty($remove)) {
                $this->response(['status' => true]);
            } else {
                $this->response(['status' => false]);
            }
        }
    }

    private function get_id($uuid)
    {
        $this->db->where('uuid', $uuid);
        $user = $this->multimedia_model->get_all();
        $user = $user[0];
        return $user->id;
    }
}
