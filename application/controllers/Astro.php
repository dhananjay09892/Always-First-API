<?php 

class Astro extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
        header("content-type: application/json; charset=utf-8");
        $this->load->library('Curl');
        $this->load->model('AstroModel');
    }
    public function getHoroscopeToday(){
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            $json = array('status' => 400, 'message' => 'Bad request.');
        } else {
            $json = $this->AstroModel->getHoroscopeToday();
            $json = empty($json) ? array('No data found') : $json;
            $json = array("status" => 200, "message" => "success", "body" => $json);
        }
        echo json_encode($json, JSON_UNESCAPED_UNICODE);
    }
    public function getHoroscopeTomorrow(){
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            $json = array('status' => 400, 'message' => 'Bad request.');
        } else {
            $json = $this->AstroModel->getHoroscopeTomorrow();
            $json = empty($json) ? array('No data found') : $json;
            $json = array("status" => 200, "message" => "success", "body" => $json);
        }
        echo json_encode($json, JSON_UNESCAPED_UNICODE);
    }
    public function getHoroscopeYesterday(){
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            $json = array('status' => 400, 'message' => 'Bad request.');
        } else {
            $json = $this->AstroModel->getHoroscopeYesterday();
            $json = empty($json) ? array('No data found') : $json;
            $json = array("status" => 200, "message" => "success", "body" => $json);
        }
        echo json_encode($json, JSON_UNESCAPED_UNICODE);
    }
    public function getHoroscopeMonth(){
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            $json = array('status' => 400, 'message' => 'Bad request.');
        } else {
            $json = $this->AstroModel->getHoroscopeMonth();
            $json = empty($json) ? array('No data found') : $json;
            $json = array("status" => 200, "message" => "success", "body" => $json);
        }
        echo json_encode($json, JSON_UNESCAPED_UNICODE);
    }
    public function getHoroscope(){
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            $json = array('status' => 400, 'message' => 'Bad request.');
        } else {
            $json = $this->AstroModel->getHoroscope();
            $json = empty($json) ? array('No data found') : $json;
            $json = array("status" => 200, "message" => "success", "body" => $json);
        }
        echo json_encode($json, JSON_UNESCAPED_UNICODE);
    }
    public function jokes(){
        $post_data = $this->input->post();
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            $json = array('status' => 400, 'message' => 'Bad request.');
        } else {
            $json = $this->AstroModel->jokes($post_data);
            $json = empty($json) ? array('No data found') : $json;
            $json = array("status" => 200, "message" => "success", "body" => $json);
        }
        echo json_encode($json, JSON_UNESCAPED_UNICODE);
    }
    public function quotes(){
        $post_data = $this->input->post();
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            $json = array('status' => 400, 'message' => 'Bad request.');
        } else {
            $json = $this->AstroModel->quotes($post_data);
            $json = empty($json) ? array('No data found') : $json;
            $json = array("status" => 200, "message" => "success", "body" => $json);
        }
        echo json_encode($json, JSON_UNESCAPED_UNICODE);
    }
    public function photos(){
        $post_data = $this->input->post();
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            $json = array('status' => 400, 'message' => 'Bad request.');
        } else {
            $json = $this->AstroModel->photos($post_data);
            $json = empty($json) ? array('No data found') : $json;
            $json = array("status" => 200, "message" => "success", "body" => $json);
        }
        echo json_encode($json, JSON_UNESCAPED_UNICODE);
    }
    public function quotesToday(){
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            $json = array('status' => 400, 'message' => 'Bad request.');
        } else {
            $json = $this->AstroModel->quotesToday();
            $json = empty($json) ? array('No data found') : $json;
            $json = array("status" => 200, "message" => "success", "body" => $json);
        }
        echo json_encode($json, JSON_UNESCAPED_UNICODE);
    }
    public function jki(){
        $post_data = $this->input->post();
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            $json = array('status' => 400, 'message' => 'Bad request.');
        } else {
            $json = $this->AstroModel->jki($post_data);
            $json = empty($json) ? array('No data found') : $json;
            $json = array("status" => 200, "message" => "success", "body" => $json);
        }
        echo json_encode($json, JSON_UNESCAPED_UNICODE);
    }
    public function jqi(){
        $post_data = $this->input->post();
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            $json = array('status' => 400, 'message' => 'Bad request.');
        } else {
            $json = $this->AstroModel->jqi($post_data);
            $json = empty($json) ? array('No data found') : $json;
            $json = array("status" => 200, "message" => "success", "body" => $json);
        }
        echo json_encode($json, JSON_UNESCAPED_UNICODE);
    }
}