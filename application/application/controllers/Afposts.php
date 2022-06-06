<?php

class Afposts extends CI_Controller {    
    public function __construct(){
        parent::__construct();
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
        header("content-type: application/json; charset=utf-8");
        $this->load->library('Curl');
        $this->load->model('Model');
    }
    // Always First
        public function getPosts(){
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method != 'GET') {
                $json = array("status" => 400, "message" => "Bad request");
            } else {
                $per_page = $_GET['per_page'] ? $_GET['per_page'] : 10;
                $page = $_GET['page'] ? $_GET['page'] : 1;
                $category = $_GET['category'] ? $_GET['category'] : '';
                $search = $_GET['search'] ? $_GET['search'] : '';
                $author = $_GET['author'] ? $_GET['author'] : '';
                $tags = $_GET['tags'] ? $_GET['tags'] : '';
                $json = $this->Model->getPostsAll($per_page,$page,$category,$search,$author,$tags);
            }
            $json = array("status" => 200, "message" => "success", "body" => $json);
            echo json_encode($json, JSON_UNESCAPED_UNICODE);
            // echo json_encode($json);
        }
        public function getPostsPage($page){
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method != 'GET') {
                $json = array("status" => 400, "message" => "Bad request");
            } else {
                $per_page = $_GET['per_page'] ? $_GET['per_page'] : 10;
                $page = $page ? $page : 1;
                $category = $_GET['category'] ? $_GET['category'] : '';
                $search = $_GET['search'] ? $_GET['search'] : '';
                $author = $_GET['author'] ? $_GET['author'] : '';
                $tags = $_GET['tags'] ? $_GET['tags'] : '';
                $json = $this->Model->getPostsAll($per_page, $page, $category, $search, $author, $tags);
            }
            $json = array("status" => 200, "message" => "success", "body" => $json);
            echo json_encode($json, JSON_UNESCAPED_UNICODE);
            // echo json_encode($json);
        }
        public function getPostsCategory($cat){
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method != 'GET') {
                $json = array("status" => 400, "message" => "Bad request");
            } else {
                $per_page = $_GET['per_page'] ? $_GET['per_page'] : 10;
                $page = $_GET['page'] ? $_GET['page'] : 1;
                $category = $cat ? $cat : '';
                $search = $_GET['search'] ? $_GET['search'] : '';
                $author = $_GET['author'] ? $_GET['author'] : '';
                $tags = $_GET['tags'] ? $_GET['tags'] : '';
                $json = $this->Model->getPostsAll($per_page, $page, $category, $search, $author, $tags);
            }
            $json = array("status" => 200, "message" => "success", "body" => $json);
            echo json_encode($json, JSON_UNESCAPED_UNICODE);
            // echo json_encode($json);
        }
        public function getPostsCategoryPage($cat,$page){
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method != 'GET') {
                $json = array("status" => 400, "message" => "Bad request");
            } else {
                $per_page = $_GET['per_page'] ? $_GET['per_page'] : 10;
                $page = $page ? $page : 1;
                $category = $cat ? $cat : '';
                $search = $_GET['search'] ? $_GET['search'] : '';
                $author = $_GET['author'] ? $_GET['author'] : '';
                $tags = $_GET['tags'] ? $_GET['tags'] : '';
                $json = $this->Model->getPostsAll($per_page, $page, $category, $search, $author, $tags);
            }
            $json = array("status" => 200, "message" => "success", "body" => $json);
            echo json_encode($json, JSON_UNESCAPED_UNICODE);
            // echo json_encode($json);
        }
        public function getPostsTag($tag){
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method != 'GET') {
                $json = array("status" => 400, "message" => "Bad request");
            } else {
                $per_page = $_GET['per_page'] ? $_GET['per_page'] : 10;
                $page = $_GET['page'] ? $_GET['page'] : 1;
                $category = $_GET['category'] ? $_GET['category'] : '';
                $search = $_GET['search'] ? $_GET['search'] : '';
                $author = $_GET['author'] ? $_GET['author'] : '';
                $tags = $tag ? $tag : '';
                $json = $this->Model->getPostsAll($per_page, $page, $category, $search, $author, $tags);
            }
            $json = array("status" => 200, "message" => "success", "body" => $json);
            echo json_encode($json, JSON_UNESCAPED_UNICODE);
            // echo json_encode($json);
        }
        public function getPostsTagPage($tag,$page){
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method != 'GET') {
                $json = array("status" => 400, "message" => "Bad request");
            } else {
                $per_page = $_GET['per_page'] ? $_GET['per_page'] : 10;
                $page = $page ? $page : 1;
                $category = $_GET['category'] ? $_GET['category'] : '';
                $search = $_GET['search'] ? $_GET['search'] : '';
                $author = $_GET['author'] ? $_GET['author'] : '';
                $tags = $tag ? $tag : '';
                $json = $this->Model->getPostsAll($per_page, $page, $category, $search, $author, $tags);
            }
            $json = array("status" => 200, "message" => "success", "body" => $json);
            echo json_encode($json, JSON_UNESCAPED_UNICODE);
            // echo json_encode($json);
        }
        public function getPostsSearch($search){
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method != 'GET') {
                $json = array("status" => 400, "message" => "Bad request");
            } else {
                $per_page = $_GET['per_page'] ? $_GET['per_page'] : 10;
                $page = 1;
                $category = $_GET['category'] ? $_GET['category'] : '';
                $search = $search ? $search : '';
                $author = $_GET['author'] ? $_GET['author'] : '';
                $tags = $_GET['tags'] ? $_GET['tags'] : '';
                $json = $this->Model->getPostsAll($per_page, $page, $category, $search, $author, $tags);
            }
            $json = array("status" => 200, "message" => "success", "body" => $json);
            echo json_encode($json, JSON_UNESCAPED_UNICODE);
            // echo json_encode($json);
        }
        public function getPostsSearchPage($search,$page){
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method != 'GET') {
                $json = array("status" => 400, "message" => "Bad request");
            } else {
                $per_page = $_GET['per_page'] ? $_GET['per_page'] : 10;
                $page = $page ? $page : 1;
                $category = $_GET['category'] ? $_GET['category'] : '';
                $search = $search ? $search : '';
                $author = $_GET['author'] ? $_GET['author'] : '';
                $tags = $_GET['tags'] ? $_GET['tags'] : '';
                $json = $this->Model->getPostsAll($per_page, $page, $category, $search, $author, $tags);
            }
            $json = array("status" => 200, "message" => "success", "body" => $json);
            echo json_encode($json, JSON_UNESCAPED_UNICODE);
            // echo json_encode($json);
        }
        public function getPostsAuthor($author){
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method != 'GET') {
                $json = array("status" => 400, "message" => "Bad request");
            } else {
                $per_page = $_GET['per_page'] ? $_GET['per_page'] : 10;
                $page = 1;
                $category = $_GET['category'] ? $_GET['category'] : '';
                $search = $_GET['search'] ? $_GET['search'] : '';
                $author = $author ? $author : '';
                $tags = $_GET['tags'] ? $_GET['tags'] : '';
                $json = $this->Model->getPostsAll($per_page, $page, $category, $search, $author, $tags);
            }
            $json = array("status" => 200, "message" => "success", "body" => $json);
            echo json_encode($json, JSON_UNESCAPED_UNICODE);
            // echo json_encode($json);
        }
        public function getPostsAuthorPage($author,$page){
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method != 'GET') {
                $json = array("status" => 400, "message" => "Bad request");
            } else {
                $per_page = $_GET['per_page'] ? $_GET['per_page'] : 10;
                $page = $page ? $page : 1;
                $category = $_GET['category'] ? $_GET['category'] : '';
                $search = $_GET['search'] ? $_GET['search'] : '';
                $author = $author ? $author : '';
                $tags = $_GET['tags'] ? $_GET['tags'] : '';
                $json = $this->Model->getPostsAll($per_page, $page, $category, $search, $author, $tags);
            }
            $json = array("status" => 200, "message" => "success", "body" => $json);
            echo json_encode($json, JSON_UNESCAPED_UNICODE);
            // echo json_encode($json);
        }
        public function getCategory(){
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method != 'GET') {
                $json = array("status" => 400, "message" => "Bad request");
            } else {
                $json = $this->Model->getCategory();
            }
            $json = array("status" => 200, "message" => "success", "body" => $json);
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
        public function getCats(){
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method != 'GET') {
                $json = array("status" => 400, "message" => "Bad request");
            } else {
                $json = $this->Model->getCats();
            }
            // $json = array("status" => 200, "message" => "success", "body" => $json);
            echo json_encode($json, JSON_UNESCAPED_UNICODE);
            // echo json_encode($json);
        }
        public function getMenuCats(){
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method != 'GET') {
                $json = array("status" => 400, "message" => "Bad request");
            } else {
                $json = $this->Model->getMenuCats();
            }
            // $json = array("status" => 200, "message" => "success", "body" => $json);
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

    // SuryyasKiran 

        public function getPostsSK()
        {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method != 'GET') {
                $json = array("status" => 400, "message" => "Bad request");
            } else {
                $per_page = $_GET['per_page'] ? $_GET['per_page'] : 10;
                $page = $_GET['page'] ? $_GET['page'] : 1;
                $category = $_GET['category'] ? $_GET['category'] : '';
                $search = $_GET['search'] ? $_GET['search'] : '';
                $author = $_GET['author'] ? $_GET['author'] : '';
                $tags = $_GET['tags'] ? $_GET['tags'] : '';
                $json = $this->Model->getPostsAllSK($per_page, $page, $category, $search, $author, $tags);
            }
            $json = array("status" => 200, "message" => "success", "body" => $json);
            echo json_encode($json, JSON_UNESCAPED_UNICODE);
            // echo json_encode($json);
        }
        public function getPostsPageSK($page)
        {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method != 'GET') {
                $json = array("status" => 400, "message" => "Bad request");
            } else {
                $per_page = $_GET['per_page'] ? $_GET['per_page'] : 10;
                $page = $page ? $page : 1;
                $category = $_GET['category'] ? $_GET['category'] : '';
                $search = $_GET['search'] ? $_GET['search'] : '';
                $author = $_GET['author'] ? $_GET['author'] : '';
                $tags = $_GET['tags'] ? $_GET['tags'] : '';
                $json = $this->Model->getPostsAllSK($per_page, $page, $category, $search, $author, $tags);
            }
            $json = array("status" => 200, "message" => "success", "body" => $json);
            echo json_encode($json, JSON_UNESCAPED_UNICODE);
            // echo json_encode($json);
        }
        public function getPostsCategorySK($cat)
        {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method != 'GET') {
                $json = array("status" => 400, "message" => "Bad request");
            } else {
                $per_page = $_GET['per_page'] ? $_GET['per_page'] : 10;
                $page = $_GET['page'] ? $_GET['page'] : 1;
                $category = $cat ? $cat : '';
                $search = $_GET['search'] ? $_GET['search'] : '';
                $author = $_GET['author'] ? $_GET['author'] : '';
                $tags = $_GET['tags'] ? $_GET['tags'] : '';
                $json = $this->Model->getPostsAllSK($per_page, $page, $category, $search, $author, $tags);
            }
            $json = array("status" => 200, "message" => "success", "body" => $json);
            echo json_encode($json, JSON_UNESCAPED_UNICODE);
            // echo json_encode($json);
        }
        public function getPostsCategoryPageSK($cat, $page)
        {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method != 'GET') {
                $json = array("status" => 400, "message" => "Bad request");
            } else {
                $per_page = $_GET['per_page'] ? $_GET['per_page'] : 10;
                $page = $page ? $page : 1;
                $category = $cat ? $cat : '';
                $search = $_GET['search'] ? $_GET['search'] : '';
                $author = $_GET['author'] ? $_GET['author'] : '';
                $tags = $_GET['tags'] ? $_GET['tags'] : '';
                $json = $this->Model->getPostsAllSK($per_page, $page, $category, $search, $author, $tags);
            }
            $json = array("status" => 200, "message" => "success", "body" => $json);
            echo json_encode($json, JSON_UNESCAPED_UNICODE);
            // echo json_encode($json);
        }
        public function getPostsTagSK($tag)
        {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method != 'GET') {
                $json = array("status" => 400, "message" => "Bad request");
            } else {
                $per_page = $_GET['per_page'] ? $_GET['per_page'] : 10;
                $page = $_GET['page'] ? $_GET['page'] : 1;
                $category = $_GET['category'] ? $_GET['category'] : '';
                $search = $_GET['search'] ? $_GET['search'] : '';
                $author = $_GET['author'] ? $_GET['author'] : '';
                $tags = $tag ? $tag : '';
                $json = $this->Model->getPostsAllSK($per_page, $page, $category, $search, $author, $tags);
            }
            $json = array("status" => 200, "message" => "success", "body" => $json);
            echo json_encode($json, JSON_UNESCAPED_UNICODE);
            // echo json_encode($json);
        }
        public function getPostsTagPageSK($tag, $page)
        {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method != 'GET') {
                $json = array("status" => 400, "message" => "Bad request");
            } else {
                $per_page = $_GET['per_page'] ? $_GET['per_page'] : 10;
                $page = $page ? $page : 1;
                $category = $_GET['category'] ? $_GET['category'] : '';
                $search = $_GET['search'] ? $_GET['search'] : '';
                $author = $_GET['author'] ? $_GET['author'] : '';
                $tags = $tag ? $tag : '';
                $json = $this->Model->getPostsAllSK($per_page, $page, $category, $search, $author, $tags);
            }
            $json = array("status" => 200, "message" => "success", "body" => $json);
            echo json_encode($json, JSON_UNESCAPED_UNICODE);
            // echo json_encode($json);
        }
        public function getPostsSearchSK($search)
        {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method != 'GET') {
                $json = array("status" => 400, "message" => "Bad request");
            } else {
                $per_page = $_GET['per_page'] ? $_GET['per_page'] : 10;
                $page = 1;
                $category = $_GET['category'] ? $_GET['category'] : '';
                $search = $search ? $search : '';
                $author = $_GET['author'] ? $_GET['author'] : '';
                $tags = $_GET['tags'] ? $_GET['tags'] : '';
                $json = $this->Model->getPostsAllSK($per_page, $page, $category, $search, $author, $tags);
            }
            $json = array("status" => 200, "message" => "success", "body" => $json);
            echo json_encode($json, JSON_UNESCAPED_UNICODE);
            // echo json_encode($json);
        }
        public function getPostsSearchPageSK($search, $page)
        {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method != 'GET') {
                $json = array("status" => 400, "message" => "Bad request");
            } else {
                $per_page = $_GET['per_page'] ? $_GET['per_page'] : 10;
                $page = $page ? $page : 1;
                $category = $_GET['category'] ? $_GET['category'] : '';
                $search = $search ? $search : '';
                $author = $_GET['author'] ? $_GET['author'] : '';
                $tags = $_GET['tags'] ? $_GET['tags'] : '';
                $json = $this->Model->getPostsAllSK($per_page, $page, $category, $search, $author, $tags);
            }
            $json = array("status" => 200, "message" => "success", "body" => $json);
            echo json_encode($json, JSON_UNESCAPED_UNICODE);
            // echo json_encode($json);
        }
        public function getPostsAuthorSK($author)
        {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method != 'GET') {
                $json = array("status" => 400, "message" => "Bad request");
            } else {
                $per_page = $_GET['per_page'] ? $_GET['per_page'] : 10;
                $page = 1;
                $category = $_GET['category'] ? $_GET['category'] : '';
                $search = $_GET['search'] ? $_GET['search'] : '';
                $author = $author ? $author : '';
                $tags = $_GET['tags'] ? $_GET['tags'] : '';
                $json = $this->Model->getPostsAllSK($per_page, $page, $category, $search, $author, $tags);
            }
            $json = array("status" => 200, "message" => "success", "body" => $json);
            echo json_encode($json, JSON_UNESCAPED_UNICODE);
            // echo json_encode($json);
        }
        public function getPostsAuthorPageSK($author, $page)
        {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method != 'GET') {
                $json = array("status" => 400, "message" => "Bad request");
            } else {
                $per_page = $_GET['per_page'] ? $_GET['per_page'] : 10;
                $page = $page ? $page : 1;
                $category = $_GET['category'] ? $_GET['category'] : '';
                $search = $_GET['search'] ? $_GET['search'] : '';
                $author = $author ? $author : '';
                $tags = $_GET['tags'] ? $_GET['tags'] : '';
                $json = $this->Model->getPostsAllSK($per_page, $page, $category, $search, $author, $tags);
            }
            $json = array("status" => 200, "message" => "success", "body" => $json);
            echo json_encode($json, JSON_UNESCAPED_UNICODE);
            // echo json_encode($json);
        }
        public function getCategorySK()
        {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method != 'GET') {
                $json = array("status" => 400, "message" => "Bad request");
            } else {
                $json = $this->Model->getCategorySK();
            }
            $json = array("status" => 200, "message" => "success", "body" => $json);
            echo json_encode($json, JSON_UNESCAPED_UNICODE);
            // echo json_encode($json);
        }
        public function getMenuCategorySK()
        {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method != 'GET') {
                $json = array("status" => 400, "message" => "Bad request");
            } else {
                $json = $this->Model->getMenuCategorySK();
            }
            $json = array("status" => 200, "message" => "success", "body" => $json);
            echo json_encode($json, JSON_UNESCAPED_UNICODE);
            // echo json_encode($json);
        }
        public function getCatsSK()
        {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method != 'GET') {
                $json = array("status" => 400, "message" => "Bad request");
            } else {
                $json = $this->Model->getCatsSK();
            }
            // $json = array("status" => 200, "message" => "success", "body" => $json);
            echo json_encode($json, JSON_UNESCAPED_UNICODE);
            // echo json_encode($json);
        }
        public function getMenuCatsSK()
        {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method != 'GET') {
                $json = array("status" => 400, "message" => "Bad request");
            } else {
                $json = $this->Model->getMenuCatsSK();
            }
            // $json = array("status" => 200, "message" => "success", "body" => $json);
            echo json_encode($json, JSON_UNESCAPED_UNICODE);
            // echo json_encode($json);
        }
        public function socialLinksSK(){
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method != 'GET') {
                $json = array("status" => 400, "message" => "Bad request");
            } else {
                $json = $this->Model->getSocialLinksSK();
            }
            $json = array("status" => 200, "message" => "success", "body" => $json);
            echo json_encode($json, JSON_UNESCAPED_UNICODE);
            // echo json_encode($json);
        }


    // Advertisement 

        public function getAds(){
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method != 'GET') {
                $json = array("status" => 400, "message" => "Bad request");
            } else {
                $json = $this->Model->getAds();
            }
            $json = array("status" => 200, "message" => "success", "body" => $json);
            echo json_encode($json, JSON_UNESCAPED_UNICODE);
            // echo json_encode($json);
        }
        public function getAdsArticle(){
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method != 'GET') {
                $json = array("status" => 400, "message" => "Bad request");
            } else {
                $json = $this->Model->getAdsArticle();
            }
            $json = array("status" => 200, "message" => "success", "body" => $json);
            echo json_encode($json, JSON_UNESCAPED_UNICODE);
            // echo json_encode($json);
        }
        public function getScriptAds(){
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method != 'GET') {
                $json = array("status" => 400, "message" => "Bad request");
            } else {
                $json = $this->Model->getScriptAds();
            }
            $json = array("status" => 200, "message" => "success", "body" => $json);
            echo json_encode($json, JSON_UNESCAPED_UNICODE);
            // echo json_encode($json);
        }
}