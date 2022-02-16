<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';
class Login extends REST_Controller
{
    public function __construct($config = 'rest')
    {
        parent::__construct();
        $this->load->model(['users_model']);
    }

    public function index_get()
    {
    }

    public function index_post()
    {
        $email = $this->post('email');
        $password = $this->post('password');
        $invalidLogin = ['msg' => "Datos invalidos, Vuelve a intentarlo", "status" => false];
        if (!$email || !$password) $this->response($invalidLogin, 200);
        $id = $this->users_model->login($email, $password);

        if ($id['status'] > 0) {
            // Datos del usuario
            $data = $id['data'];
            $token['id'] = $data->id;
            $token['status'] = $data->status;
            // Tiempo y expiración del token
            $date = new DateTime();
            $token['time'] = $date->getTimestamp();
            $token['token_expire_time'] = $date->getTimestamp() + 60 * 60 * 5;
            $token['iat'] = $date->getTimestamp();
            $token['exp'] = $date->getTimestamp() + 60 * 60 * 5;
            $output =  $this->authorization_token->generateToken($token);
            $info = [
                'token' => $output,
                'status' => true,
                'role' => $data->role,
                'user' => $data->uuid,
                'expire' => $token['exp']
            ];
            $this->response($info, 200);
        } else {
            $this->response($id, 200);
        }
    }

    public function check_get()
    {
        $token = $this->get('token');
        $decoded = $this->authorization_token->validateToken();
        if (!$decoded) {
            $this->response(null, REST_Controller::HTTP_UNAUTHORIZED);
        }
        $data = array('data' => $decoded['data']);
        $this->response($data, REST_Controller::HTTP_OK);
    }

    public function logout_post()
    {
        $data = array('data' => 'success');
        $this->response($data, REST_Controller::HTTP_OK);
    }
}
