<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';

class Schedules extends REST_Controller
{
    public function __construct()
    {
        parent::__construct('key');
        $model = array('schedule_model', 'schedule_tasks_model');
        $this->load->model($model);
    }

    public function index_get()
    {
        $data = $this->input->get();

        $this->db->where('deleted', 0);
        $rows = $this->schedule_model->num_rows();

        if ($this->input->get('page') !== null) {
            $page = (int) $this->input->get('page') * $data['per_page'];
        }

        $this->db->where('deleted', 0);
        $this->db->limit($data['per_page'], $page);
        $this->db->select('uuid, sede, year, month');
        $items = $this->schedule_model->get_all();

        foreach ($items as $i => $o) {
            $this->db->select('title, description, date');
            $this->db->where('schedule_uuid', $o->uuid);
            $items[$i]->tasks = $this->schedule_tasks_model->get_all();
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
        $tasks = $data['tasks'];
        unset($data['tasks']);
        $data['uuid'] = $this->uuid->v4();

        $save = $this->schedule_model->save($data);

        foreach ($tasks as $item) {
            $uuid = $this->uuid->v4();
            $toSave = [
                "schedule_uuid" => $data['uuid'],
                "uuid" => $uuid,
                "title" => $item['title'],
                "date" => $item['date'],
                "description" => $item['description']
            ];
            $this->schedule_tasks_model->save($toSave);
        }

        $this->response(['status' => true, 'response' => '¡Cronograma agregado!']);
    }

    public function index_delete($uuid)
    {
        $id = self::get_id($uuid);
        $delete = $this->schedule_model->delete($id);

        $this->db->select('id');
        $this->db->where('schedule_uuid', $uuid);
        $tasks = $this->schedule_tasks_model->get_all();
        foreach ($tasks as $item) {
            $this->schedule_tasks_model->delete($item->id);
        }
        $this->response(['status' => true, 'response' => '¡El cronograma ha sido borrado!']);
    }

    public function index_put($uuid)
    {
        $id = self::get_id($uuid);
        $data = $this->put();
        $tasks = $data['tasks'];
        unset($data['tasks']);
        $update = $this->schedule_model->save($data, $id);
        if (!empty($update)) {
            // Borramos todas las tasks
            $this->db->select('id');
            $this->db->where('schedule_uuid', $uuid);
            $deletable = $this->schedule_tasks_model->get_all();
            foreach ($deletable as $item) {
                $this->schedule_tasks_model->delete($item->id);
            }

            // Insertamos lo nuevo

            foreach ($tasks as $item) {
                $uuid_ = $this->uuid->v4();
                $toSave = [
                    "schedule_uuid" => $uuid,
                    "uuid" => $uuid_,
                    "title" => $item['title'],
                    "date" => $item['date'],
                    "description" => $item['description']
                ];
                $this->schedule_tasks_model->save($toSave);
            }
            $this->response(['status' => true, 'response' => '¡El cronograma ha sido editado!']);
        }
    }

    private function get_id($uuid)
    {
        $this->db->select('id');
        $this->db->where('uuid', $uuid);
        $item = $this->schedule_model->get_all();
        return $item[0]->id;
    }
}
