<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . '/libraries/REST_Controller.php';
class Token extends REST_Controller
{
    public function __construct($config = 'rest')
    {
        parent::__construct('key');
        if (!in_array("Administrador", $this->token['data']->roles)) {
            $this->response(array('status' => FALSE, 'message' => 'Forbidden no admin'), 403);
        }
     }

    public function index_get()
    {
        $this->response(array('status' => FALSE, 'message' => $this->token['data']->company), 403);

    }

    public function index_post()
    {
        echo "POST";
    }

    public function find_get()
    {
        echo "GET FIND";
    }

    public function index_put()
    {
        echo "PUT";
    }

    public function index_delete()
    {
        echo "DELETE";
    }
}