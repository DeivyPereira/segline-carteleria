<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';

class Render_private extends REST_Controller
{
    public function __construct()
    {
        parent::__construct('key');
        $model = array('render_model', 'render_drops_model', 'tv_model', 'render_demo_model');
        $this->load->model($model);
    }

    public function index_get()
    {
        $data = $this->input->get();

        $this->db->where('deleted', 0);
        $this->db->where('uuid!=', "");
        if ($data['key'] != "") {
            $this->db->like('title', $data['key']);
        }
        $rows = $this->render_model->num_rows();
        if ($this->input->get('page') !== null) {
            $page = (int) $this->input->get('page') * $data['per_page'];
        }

        $this->db->where('deleted', 0);
        $this->db->where('uuid!=', "");
        if ($data['key'] != "") {
            $this->db->like('title', $data['key']);
        }
        $this->db->limit($data['per_page'], $page);
        $this->db->select('title, start, end, created, status, sede, tv_uuid, uuid');
        $items = $this->render_model->get_all();
        foreach ($items as $i => $o) {
            $this->db->select('grid, name');
            $this->db->where('render_uuid', $o->uuid);
            $items[$i]->drops = $this->render_drops_model->get_all();

            $this->db->select('name');
            $this->db->where('uuid', $o->tv_uuid);
            $tv = $this->tv_model->get_all();
            $tv = $tv[0];
            $items[$i]->tv = $tv;
        }
        if ($items) {
            $this->response(['status' => true, 'items' => $items, 'num_rows' => $rows], 200);
        } else {
            $this->response(['status' => false, 'items' => [], 'num_rows' => $rows], 200);
        }
    }

    public function index_post()
    {
        $data = $this->post();
        $drops = $data['drops'];
        unset($data['drops']);

        // Salvamos en base de datos render
        $data['uuid'] = $this->uuid->v4();
        $save = $this->render_model->save($data);

        if (!empty($save)) {

            foreach ($drops['grid1'] as $item) {
                $newData = [
                    'uuid' => $this->uuid->v4(),
                    'render_uuid' => $data['uuid'],
                    'name' => $item['name'],
                    'grid' => 1
                ];
                $this->render_drops_model->save($newData);
            }

            foreach ($drops['grid2'] as $item) {
                $newData = [
                    'uuid' => $this->uuid->v4(),
                    'render_uuid' => $data['uuid'],
                    'name' => $item['name'],
                    'grid' => 2
                ];
                $this->render_drops_model->save($newData);
            }

            foreach ($drops['grid3'] as $item) {
                $newData = [
                    'uuid' => $this->uuid->v4(),
                    'render_uuid' => $data['uuid'],
                    'name' => $item['name'],
                    'grid' => 3
                ];
                $this->render_drops_model->save($newData);
            }

            foreach ($drops['grid4'] as $item) {
                $newData = [
                    'uuid' => $this->uuid->v4(),
                    'render_uuid' => $data['uuid'],
                    'name' => $item['name'],
                    'grid' => 4
                ];
                $this->render_drops_model->save($newData);
            }

            foreach ($drops['grid5'] as $item) {
                $newData = [
                    'uuid' => $this->uuid->v4(),
                    'render_uuid' => $data['uuid'],
                    'name' => $item['name'],
                    'grid' => 5
                ];
                $this->render_drops_model->save($newData);
            }
            $this->response(['status' => true, 'response' => '¡Agregado a lista de reproducción!'], 201);
        } else {
            $this->response(['status' => false, 'response' => '¡Ocurrió un error en el servidor!'], 201);
        }
    }

    public function index_delete($uuid)
    {
        $id = self::get_render_id($uuid);
        $delete = $this->render_model->delete($id);
        if (!empty($delete)) {
            $drops = self::get_drops_id($uuid);
            foreach ($drops as $item) {
                $this->render_drops_model->delete($item->id);
            }
            $this->response(['status' => true, 'response' => '¡Eliminado de la lista de reproducción!'], 201);
        } else {
            $this->response(['status' => false, 'response' => '¡Ocurrió un error en el servidor!'], 201);
        }
    }

    private function get_drops_id($render_uuid)
    {
        $this->db->select('id');
        $this->db->where('render_uuid', $render_uuid);
        return $this->render_drops_model->get_all();
    }

    private function get_render_id($uuid)
    {
        $this->db->select('id');
        $this->db->where('uuid', $uuid);
        $item = $this->render_model->get_all();
        $item = $item[0];
        return $item->id;
    }

    public function find_get($uuid)
    {
        $id = self::get_id($uuid);
        $items = $this->render_model->get($id);
        $form = [
            'title' => $items->title,
            'type' => $items->type,
            'start' => $items->start,
            'end' => $items->end,
            'sede' => $items->sede,
            'tv_uuid' => $items->tv_uuid,
            'status' => $items->status,
            'border' => $items->border,
            'drops' => [
                'grid1' => [],
                'grid2' => [],
                'grid3' => [],
                'grid4' => [],
                'grid5' => [],
            ]
        ];

        $this->db->select('name, grid');
        $this->db->where('render_uuid', $uuid);
        $drops = $this->render_drops_model->get_all();
        foreach ($drops as $item) {
            if ($item->grid == 1) array_push($form['drops']['grid1'], $item);
            if ($item->grid == 2) array_push($form['drops']['grid2'], $item);
            if ($item->grid == 3) array_push($form['drops']['grid3'], $item);
            if ($item->grid == 4) array_push($form['drops']['grid4'], $item);
            if ($item->grid == 5) array_push($form['drops']['grid5'], $item);
        }
        $this->response(['status' => true, 'item' => $form]);
    }

    private function get_id($uuid)
    {
        $this->db->select('id');
        $this->db->where('uuid', $uuid);
        $o = $this->render_model->get_all();
        return $o[0]->id;
    }

    public function index_put($uuid)
    {
        $data = $this->put();

        $drops = $data['drops'];
        unset($data['drops']);

        $id = self::get_id($uuid);
        $save = $this->render_model->save($data, $id);
        if (!empty($save)) {

            // Borrar los drops existentes
            $this->db->where('render_uuid', $uuid);
            $drops_id = $this->render_drops_model->get_all();
            foreach ($drops_id as $item) {
                $this->render_drops_model->delete($item->id);
            }

            // Guardamos los nuevos drops
            foreach ($drops['grid1'] as $item) {
                $newData = [
                    'uuid' => $this->uuid->v4(),
                    'render_uuid' => $uuid,
                    'name' => $item['name'],
                    'grid' => 1
                ];
                $this->render_drops_model->save($newData);
            }

            foreach ($drops['grid2'] as $item) {
                $newData = [
                    'uuid' => $this->uuid->v4(),
                    'render_uuid' => $uuid,
                    'name' => $item['name'],
                    'grid' => 2
                ];
                $this->render_drops_model->save($newData);
            }

            foreach ($drops['grid3'] as $item) {
                $newData = [
                    'uuid' => $this->uuid->v4(),
                    'render_uuid' => $uuid,
                    'name' => $item['name'],
                    'grid' => 3
                ];
                $this->render_drops_model->save($newData);
            }

            foreach ($drops['grid4'] as $item) {
                $newData = [
                    'uuid' => $this->uuid->v4(),
                    'render_uuid' => $uuid,
                    'name' => $item['name'],
                    'grid' => 4
                ];
                $this->render_drops_model->save($newData);
            }

            foreach ($drops['grid5'] as $item) {
                $newData = [
                    'uuid' => $this->uuid->v4(),
                    'render_uuid' => $uuid,
                    'name' => $item['name'],
                    'grid' => 5
                ];
                $this->render_drops_model->save($newData);
            }

            $this->response(['status' => true, 'response' => 'Cambios guardados con éxito!'], 201);
        } else {
            $this->response(['status' => false, 'response' => '¡Ocurrió un error en el servidor!'], 201);
        }
    }

    public function save_all_post()
    {
        $data = $this->post();
        $drops = $data['drops'];
        unset($data['drops']);

        $this->db->select('uuid, sede');
        $tvs = $this->tv_model->get_all();
        $count = 0;
        foreach ($tvs as $item) {
            // Salvamos en base de datos render
            $data['uuid'] = $this->uuid->v4();
            $data['sede'] = $item->sede;
            $data['tv_uuid'] = $item->uuid;
            $save = $this->render_model->save($data);

            foreach ($drops['grid1'] as $item) {
                $newData = [
                    'uuid' => $this->uuid->v4(),
                    'render_uuid' => $data['uuid'],
                    'name' => $item['name'],
                    'grid' => 1
                ];
                $this->render_drops_model->save($newData);
            }

            foreach ($drops['grid2'] as $item) {
                $newData = [
                    'uuid' => $this->uuid->v4(),
                    'render_uuid' => $data['uuid'],
                    'name' => $item['name'],
                    'grid' => 2
                ];
                $this->render_drops_model->save($newData);
            }

            foreach ($drops['grid3'] as $item) {
                $newData = [
                    'uuid' => $this->uuid->v4(),
                    'render_uuid' => $data['uuid'],
                    'name' => $item['name'],
                    'grid' => 3
                ];
                $this->render_drops_model->save($newData);
            }

            foreach ($drops['grid4'] as $item) {
                $newData = [
                    'uuid' => $this->uuid->v4(),
                    'render_uuid' => $data['uuid'],
                    'name' => $item['name'],
                    'grid' => 4
                ];
                $this->render_drops_model->save($newData);
            }

            foreach ($drops['grid5'] as $item) {
                $newData = [
                    'uuid' => $this->uuid->v4(),
                    'render_uuid' => $data['uuid'],
                    'name' => $item['name'],
                    'grid' => 5
                ];
                $this->render_drops_model->save($newData);
            }
            $count++;
            if ($count == count($tvs)) {
                $this->response(['status' => true, 'response' => '¡Agregado a lista de reproducción!'], 201);
                die;
            }
        }
    }

    public function save_demo_post()
    {
        $data = $this->post();
        $toSave = [
            'uuid' => $this->uuid->v4(),
            'data' => serialize($data)
        ];
        $save = $this->render_demo_model->save($toSave);
        if (!empty($save)) {
            $this->response(['status' => true, 'uuid' => $toSave['uuid']], 201);
        } else {
            $this->response(['status' => true, 'response' => '¡Ocurrió un error en el servidor!'], 201);
        }
    }
}
