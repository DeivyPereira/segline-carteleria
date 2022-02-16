<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';

class Render extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            'tv_model',
            'render_model',
            'render_drops_model',
            'render_demo_model',
            'schedule_model',
            'schedule_tasks_model'
        ]);
    }

    public function demo($uuid)
    {
        $data['demo'] = self::get_demo($uuid);

        $month = date('n');
        $year = date('Y');
        $this->db->select('uuid');
        $this->db->where('month', $month);
        $this->db->where('year', $year);
        $this->db->where('sede', $data['demo']['sede']);
        $schedule = $this->schedule_model->get_all();
        $data['schedule'] = $schedule[0];

        $this->db->select('title, date, description');
        $this->db->where('schedule_uuid', $data['schedule']->uuid);
        $data['schedule']->tasks = $this->schedule_tasks_model->get_all();

        $data['month'] = self::get_month();

        $this->load->view('demo/grid6', $data);

        /*
        if ($data['data']['type'] == 1) $this->load->view('demo/grid1', $data);
        if ($data['data']['type'] == 2) $this->load->view('demo/grid2', $data);
        if ($data['data']['type'] == 3) $this->load->view('demo/grid3', $data);
        if ($data['data']['type'] == 4) $this->load->view('demo/grid4', $data);
        if ($data['data']['type'] == 5) $this->load->view('demo/grid5', $data);
        */
    }

    private function get_month()
    {
        $int = date('n');
        if ($int == 1) return "Enero";
        if ($int == 2) return "Febrero";
        if ($int == 3) return "Marzo";
        if ($int == 4) return "Abril";
        if ($int == 5) return "Mayo";
        if ($int == 6) return "Junio";
        if ($int == 7) return "Julio";
        if ($int == 8) return "Agosto";
        if ($int == 9) return "Septiembre";
        if ($int == 10) return "Octubre";
        if ($int == 11) return "Noviembre";
        if ($int == 12) return "Diciembre";
    }

    private function get_demo($uuid)
    {
        $this->db->select('id,data');
        $this->db->where('uuid', $uuid);
        $items = $this->render_demo_model->get_all();
        $items = $items[0];
        $this->render_demo_model->delete($items->id);
        return unserialize($items->data);
    }

    public function render_public($id)
    {
        $this->db->select('uuid');
        $tv = $this->tv_model->get($id);

        $this->db->select('uuid, start, end, type, border, sede');
        $this->db->where('status', 1);
        $this->db->where('deleted', 0);
        $this->db->where('tv_uuid', $tv->uuid);
        $renders = $this->render_model->get_all();
        // Filtro por fecha
        $data['drops'] = [];
        foreach ($renders as $item) {
            $today = date('Y') . "-" . date('m') . "-" . date('d') . " " . date('H') . ":" . date('i');
            $today = strtotime($today);
            $start = strtotime($item->start);
            $end = strtotime($item->end);

            if ($today >= $start && $today <= $end) {
                $this->db->select('name, grid');
                $this->db->where('render_uuid', $item->uuid);
                $data['drops'] = $this->render_drops_model->get_all();
                $data['border'] = $item->border;
                $data['uuid'] = $item->uuid;
                $sede = $item->sede;
            }
        }

        $month = date('n');
        $year = date('Y');
        $this->db->select('uuid');
        $this->db->where('month', $month);
        $this->db->where('year', $year);
        $this->db->where('sede', $sede);
        $schedule = $this->schedule_model->get_all();
        $data['schedule'] = $schedule[0];

        $data['month'] = self::get_month();

        $this->db->select('title, date, description');
        $this->db->where('schedule_uuid', $data['schedule']->uuid);
        $data['schedule']->tasks = $this->schedule_tasks_model->get_all();



        if ($data['drops'] != []) {
            $this->load->view('renders/grid6', $data);
        } else {
            $this->load->view('renders/no_content');
        }
    }

    public function check_public()
    {
        $data = $this->input->post();
        $this->db->select('id, end');
        $this->db->where('uuid', $data['uuid']);
        $render = $this->render_model->get_all();
        $render = $render[0];

        $today = date('Y') . "-" . date('m') . "-" . date('d') . " " . date('H') . ":" . date('i');
        $today = strtotime($today);
        $end = strtotime($render->end);

        if ($today >= $end) {
            $response = ['expire' => true];
        } else {
            $response = ['expire' => false];
        }
        echo json_encode($response);
    }


    private function get_id($uuid)
    {
        $this->db->select('id');
        $this->db->where('uuid', $uuid);
        $render = $this->render_model->get_all();
        return $render[0]->id;
    }
}
