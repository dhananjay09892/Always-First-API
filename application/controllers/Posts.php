<?php

class Posts extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
        header("content-type: application/json; charset=utf-8");
        $this->load->library('Curl');
        $this->load->model('Model');
    }

    public function getPosts()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            $json = array('status' => 400, 'message' => 'Bad request.');
        } else {
            $per_page = $_POST['per_page'] ? $_POST['per_page'] : 20;
            $page = $_POST['page'] ? $_POST['page'] : 1;
            $category = $_POST['category'] ? $_POST['category'] : '';
            $search = $_POST['search'] ? $_POST['search'] : '';
            $author = $_POST['author'] ? $_POST['author'] : '';
            $tags = $_POST['tags'] ? $_POST['tags'] : '';
            $json = $this->Model->getPostsAll($per_page, $page, $category, $search, $author, $tags);
            $json = array("status" => 200, "message" => "success", "body" => $json);
        }
        echo json_encode($json, JSON_UNESCAPED_UNICODE);
    }
    public function getPostsCategory()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $post_data = $this->input->post();
        if ($method != 'POST') {
            $json = array('status' => 400, 'message' => 'Bad request.');
        } else {
            if(isset($post_data['id'])){
                $per_page = $_POST['per_page'] ? $_POST['per_page'] : 20;
                $page = $_POST['page'] ? $_POST['page'] : 1;
                $category = $_POST['id'] ? $_POST['id'] : '';
                $search = $_POST['search'] ? $_POST['search'] : '';
                $author = $_POST['author'] ? $_POST['author'] : '';
                $tags = $_POST['tags'] ? $_POST['tags'] : '';
                $json = $this->Model->getPostsAll($per_page, $page, $category, $search, $author, $tags);
                $json = array("status" => 200, "message" => "success", "body" => $json);
            }else{
                $json = array('status' => 400, 'message' => 'Parameter id is required.');
            }
        }
        echo json_encode($json, JSON_UNESCAPED_UNICODE);
    }
    public function getPostsTag()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            $json = array('status' => 400, 'message' => 'Bad request.');
        } else {
            if(isset($_POST['id'])){
                $per_page = $_POST['per_page'] ? $_POST['per_page'] : 20;
                $page = $_POST['page'] ? $_POST['page'] : 1;
                $category = $_POST['category'] ? $_POST['category'] : '';
                $search = $_POST['search'] ? $_POST['search'] : '';
                $author = $_POST['author'] ? $_POST['author'] : '';
                $tags = $_POST['id'] ? $_POST['id'] : '';
                $json = $this->Model->getPostsAll($per_page, $page, $category, $search, $author, $tags);
                $json = array("status" => 200, "message" => "success", "body" => $json);
            }else{
                $json = array('status' => 400, 'message' => 'Parameter id is required.');
            }
        }
        echo json_encode($json, JSON_UNESCAPED_UNICODE);
    }
    public function getPostsSearch()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            $json = array('status' => 400, 'message' => 'Bad request.');
        } else {
            if(isset($_POST['search']) || isset($_POST['s'])){
                $per_page = $_POST['per_page'] ? $_POST['per_page'] : 20;
                $page = $_POST['page'] ? $_POST['page'] : 1;
                $category = $_POST['category'] ? $_POST['category'] : '';
                $search = $_POST['s'] ? $_POST['s'] : '';
                $search = $_POST['search'] ? $_POST['search'] : $search;
                $author = $_POST['author'] ? $_POST['author'] : '';
                $tags = $_POST['tags'] ? $_POST['tags'] : '';
                $json = $this->Model->getPostsAll($per_page, $page, $category, $search, $author, $tags);
                $json = array("status" => 200, "message" => "success", "body" => $json);
            }else{
                $json = array('status' => 400, 'message' => 'Parameter search is required.');
            }
        }
        echo json_encode($json, JSON_UNESCAPED_UNICODE);
    }
    public function getPostsAuthor()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            $json = array('status' => 400, 'message' => 'Bad request.');
        } else {
            if(isset($_POST['id'])){
                $per_page = $_POST['per_page'] ? $_POST['per_page'] : 20;
                $page = $_POST['page'] ? $_POST['page'] : 1;
                $category = $_POST['category'] ? $_POST['category'] : '';
                $search = $_POST['search'] ? $_POST['search'] : '';
                $author = $_POST['id'] ? $_POST['id'] : '';
                $tags = $_POST['tags'] ? $_POST['tags'] : '';
                $json = $this->Model->getPostsAll($per_page, $page, $category, $search, $author, $tags);
                $json = array("status" => 200, "message" => "success", "body" => $json);
            }else{
                $json = array('status' => 400, 'message' => 'Parameter id is required.');
            }
        }
        echo json_encode($json, JSON_UNESCAPED_UNICODE);
    }
}
