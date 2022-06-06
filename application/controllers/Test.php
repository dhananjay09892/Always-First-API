<?php 

class Test extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
        header("content-type: application/json; charset=utf-8");
        $this->load->library('Curl');
        $this->load->model('PostModel');
        $this->load->model('Model');
    }
    public function getTest(){
        $post_data = $this->input->post();
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            $json = array('status' => 400, 'message' => 'Bad request.');
        } else {
            $per_page = $post_data['per_page'] ? $post_data['per_page'] : 50;
            $page = $post_data['page'] ? $post_data['page'] : 1;
            $category = $post_data['category'] ? $post_data['category'] : '';
            $search = $post_data['search'] ? $post_data['search'] : '';
            $author = $post_data['author'] ? $post_data['author'] : '';
            $tags = $post_data['tags'] ? $post_data['tags'] : '';
            $json = $this->PostModel->getDataFromSql($per_page, $page, $category, $search, $author, $tags);
            $json = array("status" => 200, "message" => "success", "body" => $json);
        }
        echo json_encode($json, JSON_UNESCAPED_UNICODE);
    }
    public function getTestCategory(){
        $method = $_SERVER['REQUEST_METHOD'];
        $post_data = $this->input->post();
        if ($method != 'POST') {
            $json = array('status' => 400, 'message' => 'Bad request.');
        } else {
            if(isset($post_data['id'])){
                $per_page = $post_data['per_page'] ? $post_data['per_page'] : 50;
                $page = $post_data['page'] ? $post_data['page'] : 1;
                $category = $post_data['id'] ? $post_data['id'] : '';
                $search = $post_data['search'] ? $post_data['search'] : '';
                $author = $post_data['author'] ? $post_data['author'] : '';
                $tags = $post_data['tags'] ? $post_data['tags'] : '';
                $json = $this->PostModel->getDataFromSql($per_page, $page, $category, $search, $author, $tags);
                $json = array("status" => 200, "message" => "success", "body" => $json);
            }else{
                $json = array('status' => 400, 'message' => 'Parameter id is required.');
            }
        }
        echo json_encode($json, JSON_UNESCAPED_UNICODE);
    }
    public function getTestTag(){
        $method = $_SERVER['REQUEST_METHOD'];
        $post_data = $this->input->post();
        if ($method != 'POST') {
            $json = array('status' => 400, 'message' => 'Bad request.');
        } else {
            if(isset($post_data['id'])){
                $per_page = $post_data['per_page'] ? $post_data['per_page'] : 50;
                $page = $post_data['page'] ? $post_data['page'] : 1;
                $category = $post_data['category'] ? $post_data['category'] : '';
                $search = $post_data['search'] ? $post_data['search'] : '';
                $author = $post_data['author'] ? $post_data['author'] : '';
                $tags = $post_data['id'] ? $post_data['id'] : '';
                $json = $this->PostModel->getDataFromSql($per_page, $page, $category, $search, $author, $tags);
                $json = array("status" => 200, "message" => "success", "body" => $json);
            }else{
                $json = array('status' => 400, 'message' => 'Parameter id is required.');
            }
        }
        echo json_encode($json, JSON_UNESCAPED_UNICODE);
    }
    public function getTestSearch(){
        $method = $_SERVER['REQUEST_METHOD'];
        $post_data = $this->input->post();
        if ($method != 'POST') {
            $json = array('status' => 400, 'message' => 'Bad request.');
        } else {
            if(isset($post_data['s'])){
                $per_page = $post_data['per_page'] ? $post_data['per_page'] : 50;
                $page = $post_data['page'] ? $post_data['page'] : 1;
                $category = $post_data['category'] ? $post_data['category'] : '';
                $search = $post_data['s'] ? $post_data['s'] : '';
                $author = $post_data['author'] ? $post_data['author'] : '';
                $tags = $post_data['tags'] ? $post_data['tags'] : '';
                $json = $this->PostModel->getDataFromSql($per_page, $page, $category, $search, $author, $tags);
                $json = array("status" => 200, "message" => "success", "body" => $json);
            }else{
                $json = array('status' => 400, 'message' => 'Parameter s is required.');
            }
        }
        echo json_encode($json, JSON_UNESCAPED_UNICODE);
    }
    public function getTestAuthor(){
        $method = $_SERVER['REQUEST_METHOD'];
        $post_data = $this->input->post();
        if ($method != 'POST') {
            $json = array('status' => 400, 'message' => 'Bad request.');
        } else {
            if(isset($post_data['id'])){
                $per_page = $post_data['per_page'] ? $post_data['per_page'] : 50;
                $page = $post_data['page'] ? $post_data['page'] : 1;
                $category = $post_data['category'] ? $post_data['category'] : '';
                $search = $post_data['search'] ? $post_data['search'] : '';
                $author = $post_data['id'] ? $post_data['id'] : '';
                $tags = $post_data['tags'] ? $post_data['tags'] : '';
                $json = $this->PostModel->getDataFromSql($per_page, $page, $category, $search, $author, $tags);
                $json = array("status" => 200, "message" => "success", "body" => $json);
            }else{
                $json = array('status' => 400, 'message' => 'Parameter id is required.');
            }
        }
        echo json_encode($json, JSON_UNESCAPED_UNICODE);
    }
    public function getCategory(){
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'GET') {
            $json = array("status" => 400, "message" => "Bad request");
        } else {
            $json = $this->Model->getCategory();
            $json = array("status" => 200, "message" => "success", "body" => $json);
        }
        echo htmlspecialchars_decode(json_encode($json, JSON_UNESCAPED_UNICODE));
        // echo json_encode($json);
    }
    public function getMenuCategory(){
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'GET') {
            $json = array("status" => 400, "message" => "Bad request");
        } else {
            $json = $this->Model->getMenuCategory();
            $json = array("status" => 200, "message" => "success", "body" => $json);
        }
        echo htmlspecialchars_decode(json_encode($json, JSON_UNESCAPED_UNICODE));
        // echo json_encode($json);
    }
    // this is not api Only for getting Data
    public function getCats(){
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'GET') {
            $json = array("status" => 400, "message" => "Bad request");
        } else {
            $json = $this->Model->getCats();
            // $json = array("status" => 200, "message" => "success", "body" => $json);
        }
        echo json_encode($json, JSON_UNESCAPED_UNICODE);
        // echo json_encode($json);
    }
    // this is not api Only for getting Data
    public function getMenuCats(){
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'GET') {
            $json = array("status" => 400, "message" => "Bad request");
        } else {
            $json = $this->Model->getMenuCats();
            // $json = array("status" => 200, "message" => "success", "body" => $json);
        }
        echo json_encode($json, JSON_UNESCAPED_UNICODE);
        // echo json_encode($json);
    }
    public function socialLinks(){
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'GET') {
            $json = array("status" => 400, "message" => "Bad request");
        } else {
            $json = $this->Model->socialLinks();
        }
        $json = array("status" => 200, "message" => "success", "body" => $json);
        echo json_encode($json, JSON_UNESCAPED_UNICODE);
        // echo json_encode($json);
    }
    public function getAds()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'GET') {
            $json = array("status" => 400, "message" => "Bad request");
        } else {
            $json = $this->Model->getAds();
            $json = array("status" => 200, "message" => "success", "body" => $json);
        }
        echo json_encode($json, JSON_UNESCAPED_UNICODE);
        // echo json_encode($json);
    }
    public function getAdsCategory()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'GET') {
            $json = array("status" => 400, "message" => "Bad request");
        } else {
            $json = $this->Model->getAdsCategory();
            $json = array("status" => 200, "message" => "success", "body" => $json);
        }
        echo json_encode($json, JSON_UNESCAPED_UNICODE);
        // echo json_encode($json);
    }
    public function getAdsArticle()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'GET') {
            $json = array("status" => 400, "message" => "Bad request");
        } else {
            $json = $this->Model->getAdsArticle();
            $json = array("status" => 200, "message" => "success", "body" => $json);
        }
        echo json_encode($json, JSON_UNESCAPED_UNICODE);
        // echo json_encode($json);
    }
    public function getScriptAds()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'GET') {
            $json = array("status" => 400, "message" => "Bad request");
        } else {
            $json = $this->Model->getScriptAds();
            $json = array("status" => 200, "message" => "success", "body" => $json);
        }
        echo json_encode($json, JSON_UNESCAPED_UNICODE);
        // echo json_encode($json);
    }
    public function sanitized_text($data){
        $data = str_replace("'", '\'', $data);
        $data = str_replace('"', "\"", $data);
        return $data;
    }
    public function feedback(){
        $method = $_SERVER['REQUEST_METHOD'];
        $post_data = $this->input->post();
        if ($method != 'POST') {
            $json = array('status' => 400, 'message' => 'Bad request.');
        } else {
            if(isset($post_data['name']) && isset($post_data['email']) && isset($post_data['message']) && isset($post_data['phone'])){
                $name       = $this->sanitized_text($post_data['name']);
                $email      = $this->sanitized_text($post_data['email']);
                $phone      = $this->sanitized_text($post_data['phone']);
                $message    = $this->sanitized_text($post_data['message']);
                $data       = array(
                    'name'      => $name,
                    'email'     => $email,
                    'phone'     => $phone,
                    'message'   => $message,
                    'created_at'=> date('Y-m-d H:i:s')
                );
                $json       = $this->Model->feedback($data);
                // $json       = array("status" => 200, "message" => "success");
            }else{
                $json       = array('status' => 400, 'message' => 'Parameter name, email, message and phone is required.');
            }
        }
        echo json_encode($json, JSON_UNESCAPED_UNICODE);
    }
    public function privacyPolicy(){
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'GET') {
            $json = array("status" => 400, "message" => "Bad request");
        } else {
            $json = $this->Model->privacyPolicy();
            $json = array("status" => 200, "message" => "success", "body" => $json);
        }
        echo json_encode($json, JSON_UNESCAPED_UNICODE);
        // echo json_encode($json);
    }
    public function termsAndConditions(){
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'GET') {
            $json = array("status" => 400, "message" => "Bad request");
        } else {
            $json = $this->Model->termsAndConditions();
            $json = array("status" => 200, "message" => "success", "body" => $json);
        }
        echo json_encode($json, JSON_UNESCAPED_UNICODE);
        // echo json_encode($json);
    }
    public function videos(){
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'GET') {
            $json = array("status" => 400, "message" => "Bad request");
        } else {
            $per_page = 20;
            $page = 1;
            $category = 3632;
            $search = '';
            $author = '';
            $tags = '';
            $json = $this->PostModel->videos($per_page, $page, $category, $search, $author, $tags);
            $json = array("status" => 200, "message" => "success", "body" => $json);
        }
        echo json_encode($json, JSON_UNESCAPED_UNICODE);
        // echo json_encode($json);
    }
    public function marketAPI(){
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'GET') {
            $json = array("status" => 400, "message" => "Bad request");
        } else {
            $json = $this->Model->marketAPI();
            $json = array("status" => 200, "message" => "success", "body" => $json);
        }
        echo json_encode($json, JSON_UNESCAPED_UNICODE);
        // echo json_encode($json);
    }
    // public function test(){
    //     $post_data = $this->input->post();
    //     $method = $_SERVER['REQUEST_METHOD'];
    //     if ($method != 'GET') {
    //         $json = array("status" => 400, "message" => "Bad request");
    //     } else {
    //         $per_page = $post_data['per_page'] ? $post_data['per_page'] : 50;
    //         $page = $post_data['page'] ? $post_data['page'] : 1;
    //         $category = $post_data['category'] ? $post_data['category'] : '';
    //         $search = $post_data['search'] ? $post_data['search'] : '';
    //         $author = $post_data['author'] ? $post_data['author'] : '';
    //         $tags = $post_data['tags'] ? $post_data['tags'] : '';
    //         $json = $this->PostModel->getDataFromSqlRelated($per_page, $page, $category, $search, $author, $tags);
    //         $json = array("status" => 200, "message" => "success", "body" => $json);
    //     }
    //     echo json_encode($json, JSON_UNESCAPED_UNICODE);
    //     // echo json_encode($json);
    // }
    // public function getDataFromSqlTest(){
    //     $post_data = $this->input->post();
    //     $method = $_SERVER['REQUEST_METHOD'];
    //     if ($method != 'GET') {
    //         $json = array("status" => 400, "message" => "Bad request");
    //     } else {
    //         $per_page = $post_data['per_page'] ? $post_data['per_page'] : 50;
    //         $page = $post_data['page'] ? $post_data['page'] : 1;
    //         $category = $post_data['category'] ? $post_data['category'] : '';
    //         $search = $post_data['search'] ? $post_data['search'] : '';
    //         $author = $post_data['author'] ? $post_data['author'] : '';
    //         $tags = $post_data['tags'] ? $post_data['tags'] : '';
    //         $json = $this->PostModel->getDataFromSqlTest($per_page, $page, $category, $search, $author, $tags);
    //         $json = array("status" => 200, "message" => "success", "body" => $json);
    //     }
    //     echo json_encode($json, JSON_UNESCAPED_UNICODE);
    //     // echo json_encode($json);
    // }

}