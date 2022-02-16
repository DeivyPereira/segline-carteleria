<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';

class Multimedia extends REST_Controller
{
    private $success = "¡Información guardada con éxito!";
    private $error = "¡Ocurrió un error en el servidor!";
    private $deleted = "¡Eliminado con éxito!";

    public function __construct()
    {
        parent::__construct();
    }


    public function attached_post()
    {
        $config['upload_path']          = './uploads/attached/';
        $config['allowed_types']        = 'avi|mov|flv|mp4|wmv|mpg|MOV';
        $config['encrypt_name']        = true;
       // $config['max_size']             = 100000;

        if ($this->load->library('upload', $config)) :
            if ($this->upload->do_upload('file')) :
                $name = $this->upload->data('file_name');
                $this->response(['status' => true, 'name' => 'http://carteleriasegline.com/api/uploads/attached/'.$name], 201);
            else :
                $this->response(['status' => false, 'error' => $this->upload->display_errors()], 400);
            endif;
        else :
            $this->response(['status' => false, 'response', 'La Librería upload no se cargó correctamente'], 400);
        endif;
    }

    public function attached_delete($item)
    {
        if (unlink('./uploads/attached/' . $item)) {
            $this->response(['status' => true, 'response' => '¡El adjunto ha sido eliminado!'], 200);
        } else {
            $this->response(['status' => false, 'response' => '¡Ocurrió un error en el servidor!'], 200);
        }
    }

}
