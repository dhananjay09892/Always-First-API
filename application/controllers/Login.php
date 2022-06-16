<?php

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
        header("content-type: application/json; charset=utf-8");
        $this->load->library('Curl');
        $this->load->model('LoginModel');
    }
    public function login()
    {
        $post_data = $this->input->post();
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            $json = array('status' => 405, 'message' => 'Method Not Allowed.');
        } else {
            if (isset($post_data['email']) && isset($post_data['password'])) {
                $email = $post_data['email'];
                $password = $post_data['password'];
                $result = $this->LoginModel->login($email, $password);
                if ($result) {
                    $json = array('status' => 200, 'message' => 'Login Successful.', 'data' => $result);
                } else {
                    $json = array('status' => 401, 'message' => 'Invalid Credentials.');
                }
            } else {
                $json = array('status' => 400, 'message' => 'Bad request.');
            }
        }
        echo json_encode($json, JSON_UNESCAPED_UNICODE);
    }
    public function register()
    {
        // getting data of Name Email and Password from the form
        // data used // `user_login`, `user_pass`, `user_nicename`, `user_email`, `user_url`, `user_registered`, `user_activation_key`, `user_status`, `display_name
        $post_data = $this->input->post();
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            $json = array('status' => 405, 'message' => 'Method Not Allowed.');
        } else {
            if (isset($post_data['name']) && isset($post_data['email']) && isset($post_data['password'])) {
                $data = array(
                    'name' => $post_data['name'],
                    'email' => $post_data['email'],
                    'password' => $post_data['password'],
                    'device_id' => isset($post_data['device_id']) ? $post_data['device_id'] : '',
                    'device_token' => isset($post_data['device_token']) ? $post_data['device_token'] : '',
                    'login_type' => isset($post_data['login_type']) ? $post_data['login_type'] : 'email',
                );
                $checkUserdata = $this->LoginModel->checkUserdata($data);
                if ($checkUserdata) {
                    $json = array('status' => 400, 'message' => 'User already exists.');
                } else {
                    $result = $this->LoginModel->register($data);
                    $r_data = array(
                        'user_id' => $result['user_id'],
                        'email' => $result['user_email'],
                        'name' => $result['display_name'],
                        'category' => $result['category']
                    );
                    $json = array('status' => 201, 'message' => 'User registered successfully.', 'data' => $r_data);
                }
            } else {
                $json = array('status' => 400, 'message' => 'Parameter missing.');
            }
        }
        echo json_encode($json, JSON_UNESCAPED_UNICODE);
    }
    public function forgotPassword(){
        $post_data = $this->input->post();
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            $json = array('status' => 405, 'message' => 'Method Not Allowed.');
        } else {
            if (isset($post_data['email'])) {
                $email = $post_data['email'];
                $result = $this->LoginModel->forgotPassword($email);
                if ($result) {
                    $json = array('status' => 200, 'message' => 'OTP sent to your email.', 'data' => $result);
                } else {
                    $json = array('status' => 401, 'message' => 'Invalid email.');
                }
            } else {
                $json = array('status' => 400, 'message' => 'Parameter missing.');
            }
        }
        echo json_encode($json, JSON_UNESCAPED_UNICODE);
    }
    public function socialLogin(){
        $post_data = $this->input->post();
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            $json = array('status' => 405, 'message' => 'Method Not Allowed.');
        } else {
            if (isset($post_data['email'])) {
                $password = password_hash(time(), PASSWORD_DEFAULT);
                $data = array(
                    'name' => $post_data['name'],
                    'email' => $post_data['email'],
                    'password' => $password,
                    'device_id' => isset($post_data['device_id']) ? $post_data['device_id'] : '',
                    'device_token' => isset($post_data['device_token']) ? $post_data['device_token'] : '',
                    'login_type' => isset($post_data['login_type']) ? $post_data['login_type'] : 'email',
                );
                $checkUserdata = $this->LoginModel->checkUserdata($data);
                if ($checkUserdata) {
                    $result = $this->LoginModel->socialLogin($data);
                    if($result){
                        $json = array('status' => 200, 'message' => 'Login Successful.', 'data' => $result);
                    }else{
                        $json = array('status' => 401, 'message' => 'Invalid Credentials.');
                    }
                } else{
                    if (isset($post_data['email']) && isset($post_data['name']) && isset($post_data['login_type'])){
                        $addData = $this->LoginModel->register($data);
                        $result = $this->LoginModel->socialLogin($data);
                        $json = array('status' => 201, 'message' => 'Login Successful.', 'data' => $result);
                    } else {
                        $json = array('status' => 400, 'message' => 'Parameter missing.');
                    }
                }
            } else {
                $json = array('status' => 400, 'message' => 'Parameter missing.');
            }
        }
        echo json_encode($json, JSON_UNESCAPED_UNICODE);
    }
    public function verifyOTP(){
        $post_data = $this->input->post();
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            $json = array('status' => 405, 'message' => 'Method Not Allowed.');
        } else {
            if (isset($post_data['user_id']) && isset($post_data['otp'])) {
                $user_id = $post_data['user_id'];
                $otp = $post_data['otp'];
                $result = $this->LoginModel->verifyOTP($user_id, $otp);
                if ($result) {
                    $json = array('status' => 200, 'message' => 'OTP verified successfully.', 'data' => $result);
                } else {
                    $json = array('status' => 401, 'message' => 'Invalid OTP.');
                }
            } else {
                $json = array('status' => 400, 'message' => 'Bad request.');
            }
        }
        echo json_encode($json, JSON_UNESCAPED_UNICODE);
    }
    public function getUserCategory(){
        $post_data = $this->input->post();
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            $json = array('status' => 405, 'message' => 'Method Not Allowed.');
        } else {
            if (isset($post_data['user_id'])) {
                $user_id = $post_data['user_id'];
                $result = $this->LoginModel->getUserCategory($user_id);
                if ($result) {
                    $json = array('status' => 200, 'message' => 'User category list.', 'data' => $result);
                } else {
                    $json = array('status' => 401, 'message' => 'No category found.' , 'data' => NULL);
                }
            } else {
                $json = array('status' => 400, 'message' => 'parameter missing.');
            }
        }
        echo json_encode($json, JSON_UNESCAPED_UNICODE);
    }
    public function getUserCategoryNew(){
        $post_data = $this->input->post();
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            $json = array('status' => 405, 'message' => 'Method Not Allowed.');
        } else {
            if (isset($post_data['user_id'])) {
                $user_id = $post_data['user_id'];
                $result = $this->LoginModel->getUserCategoryNew($user_id);
                if ($result) {
                    $json = array('status' => 200, 'message' => 'User category list.', 'data' => $result);
                } else {
                    $json = array('status' => 401, 'message' => 'No category found.' , 'data' => NULL);
                }
            } else {
                $json = array('status' => 400, 'message' => 'parameter missing.');
            }
        }
        echo json_encode($json, JSON_UNESCAPED_UNICODE);
    }
    public function postUserCategory(){
        $post_data = $this->input->post();
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            $json = array('status' => 405, 'message' => 'Method Not Allowed.');
        } else {
            if (isset($post_data['user_id']) && isset($post_data['category'])) {
                $user_id = $post_data['user_id'];
                $category = $post_data['category'];
                $result = $this->LoginModel->postUserCategory($user_id, $category);
                if ($result) {
                    $json = array('status' => 200, 'message' => 'User category added successfully.');
                } else {
                    $json = array('status' => 401, 'message' => 'User category not added.');
                }
            } else {
                $json = array('status' => 400, 'message' => 'Bad request.');
            }
        }
        echo json_encode($json, JSON_UNESCAPED_UNICODE);
    }
    public function resetPassword(){
        $post_data = $this->input->post();
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            $json = array('status' => 405, 'message' => 'Method Not Allowed.');
        } else {
            if (isset($post_data['user_id']) && isset($post_data['password'])) {
                $user_id = $post_data['user_id'];
                $password = $post_data['password'];
                $result = $this->LoginModel->resetPassword($user_id, $password);
                if ($result) {
                    $json = array('status' => 200, 'message' => 'Password reset successfully.');
                } else {
                    $json = array('status' => 401, 'message' => 'Invalid email.');
                }
            } else {
                $json = array('status' => 400, 'message' => 'Bad request.');
            }
        }
        echo json_encode($json, JSON_UNESCAPED_UNICODE);
    }
}
