<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';

class Calendar extends REST_Controller
{
    public function __construct()
    {
        parent::__construct('key');
        $model = array('render_model', 'render_drops_model', 'tv_model');
        $this->load->model($model);
    }

    public function index_get()
    {
        $data = $this->input->get();

        $this->db->where('deleted', 0);
        $this->db->where('status', 1);
        $this->db->where('sede', $data['sede']);
        $this->db->where('tv_uuid', $data['tv']);
        $this->db->select('title, start, end, uuid, sede, tv_uuid');
        $items = $this->render_model->get_all();

        $arr = [];
        foreach ($items as $i => $o) {
            $this->db->select('name');
            $this->db->where('uuid', $data['tv']);
            $tv = $this->tv_model->get_all();
            $tv = $tv[0];
            $obj = [
                'uuid' => $o->uuid,
                'start' => $o->start,
                'end' => $o->end,
                'title' => $o->title . " | " . self::get_sede($data['sede']) . " | " . $tv->name
            ];
            array_push($arr, $obj);
        }

        if ($arr) {
            $this->response(['status' => true, 'items' => $arr], 200);
        } else {
            $this->response(['status' => false, 'items' => []], 200);
        }
    }

    private function get_sede($sede)
    {
        if ($sede == 1) return "Breña: +51 (01) 6044700";
        if ($sede == 2) return "Comas: +51 (01) 6015700";
        if ($sede == 3) return "Los Olivos: +51 (01) 6143311";
        if ($sede == 4) return "San Juan de Lurigancho: +51 (01) 6184660";
        if ($sede == 5) return "Trujillo El Molino: +51 (44) 606200";
        if ($sede == 6) return "Trujillo San Isidro: +51 (44) 606100";
        if ($sede == 7) return "Cajamarca: +51 (76) 602525";
    }

    public function index_put($uuid)
    {
        $data = $this->put();
        $id = self::get_id($uuid);
        $update = $this->render_model->save($data, $id);
        if (!empty($update)) {
            $this->response(['status' => true, 'response' => '¡Cambios guardados con éxito!'], 200);
        } else {
            $this->response(['status' => false, 'response' => '¡Ocurrió un error en el servidor!'], 200);
        }
    }

    private function get_id($uuid)
    {
        $this->db->select('id');
        $this->db->where('uuid', $uuid);
        $o = $this->render_model->get_all();
        return $o[0]->id;
    }
}
