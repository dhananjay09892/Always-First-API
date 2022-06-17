<?php
defined('BASEPATH') or exit('No direct script access allowed');


class LoginModel extends CI_Model
{
    public function __construct(){
        parent::__construct();
        $this->load->library('Curl');
    }
    public function login($email, $password){
        // Get user data from database
        $user = $this->db->get_where('wp5q_users', array('user_email' => $email))->row_array();
        if ($user) {
            // Check if password matches
            if (password_verify($password, $user['user_pass'])) {
                // User logged in
                $app_data_user = $this->db->get_where('app_data', array('email' => $email))->result_array();
                $app_data_user = $app_data_user[count($app_data_user) - 1];
                $result = array(
                    'user_id' => (int)$app_data_user['user_id'],
                    'email' => $app_data_user['email'],
                    'name' => $user['display_name'],
                    'category' => $app_data_user['category']
                );
                return $result;
            } else {
                // Password does not match
                return false;
            }
        } else {
            // User not found
            return false;
        }
    }
    public function register($post_data){
        $data = array(
            'user_login' => $post_data['email'],
            'user_pass' => password_hash($post_data['password'], PASSWORD_DEFAULT),
            'user_nicename' => $post_data['name'],
            'user_email' => $post_data['email'],
            'user_url' => '',
            'user_registered' => date('Y-m-d H:i:s'),
            'user_activation_key' => '',
            'user_status' => '0',
            'display_name' => $post_data['name']
        );
        $userName = $post_data['name'];
        if ($this->db->insert('wp5q_users', $data)) {
            // remove password from data
            $user_id = $this->db->insert_id();
            // insert user_id to data
            $data['user_id'] = $user_id;
            if (str_contains($userName, ' ')) {
                $first_name = explode(' ', $userName)[0];
                $last_name = explode(' ', $userName)[1];
            } else {
                $first_name = $userName;
                $last_name = '';
            }
            $metaData = array(
                'user_id' => $user_id,
                'meta_key' => 'wp5q_capabilities',
                'meta_value' => 'a:0:{}'
            );
            $this->db->insert('wp5q_usermeta', $metaData);
            $metaData = array(
                'user_id' => $user_id,
                'meta_key' => 'wp5q_user_level',
                'meta_value' => '0'
            );
            $this->db->insert('wp5q_usermeta', $metaData);
            $metaData = array(
                'user_id' => $user_id,
                'meta_key' => 'nickname',
                'meta_value' => $userName
            );
            $this->db->insert('wp5q_usermeta', $metaData);
            $metaData = array(
                'user_id' => $user_id,
                'meta_key' => 'first_name',
                'meta_value' => $first_name
            );
            $this->db->insert('wp5q_usermeta', $metaData);
            $metaData = array(
                'user_id' => $user_id,
                'meta_key' => 'last_name',
                'meta_value' => $last_name
            );
            $this->db->insert('wp5q_usermeta', $metaData);
            $metaData = array(
                'user_id' => $user_id,
                'meta_key' => 'show_admin_bar_front',
                'meta_value' => 'false'
            );
            $this->db->insert('wp5q_usermeta', $metaData);
            $device_id = isset($post_data['device_id'])?$post_data['device_id']:'0';
            $device_token = isset($post_data['device_token'])?$post_data['device_token']:'0';
            $login_type = isset($post_data['login_type'])?$post_data['login_type']:'';
            $app_data = array(
                'user_id' => $user_id,
                'email' => $post_data['email'],
                'name' => $post_data['name'],
                'password' => password_hash($post_data['password'], PASSWORD_DEFAULT),
                'old_password' => NULL,
                'device_id' => $device_id,
                'device_token' => $device_token,
                'category' => NULL,
                'login_type' => $login_type,
                'OTP' => NULL,
                'Created_at' => date('Y-m-d H:i:s'),
            );
            $this->db->insert('app_data', $app_data);
            return $data;
        }
        return false;
    }
    public function checkUserdata($data){
        $this->db->where('user_email', $data['email']);
        $query = $this->db->get('wp5q_users');
        $user = $query->row();
        if ($user) {
            // return array('status' => 200, 'message' => 'User already exists.', 'data' => $user);
            return true;
        } else {
            // return array('status' => 404, 'message' => 'User not found.', 'data' => $user);
            return false;
        }
    }
    public function socialLogin($data){
        $email = $data['email'];
        $user = $this->db->get_where('app_data', array('email' => $email))->result_array();
        if ($user) {
            $user = $user[count($user) - 1];
            // if($user['login_type'] == 'facebook' || $user['login_type'] == 'google'){
                $result = array(
                    'user_id' => (int)$user['user_id'],
                    'email' => $user['email'],
                    'name' => $user['name'],
                    'category' => $user['category']
                );
                // return array('status' => 200, 'message' => 'User already exists.', 'data' => $user);
                return $result;
            // }else {
            //     return false;
            // }
        } else {
            // return array('status' => 404, 'message' => 'User not found.', 'data' => $user);
            return false;
        }
    }
    public function getUserCategory($user_id){
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('app_data');
        $user = $query->row();
        $c = $user->category;
        $category = explode(',', $c);
        return $category;
    }
    public function getUserCategoryNew($user_id){
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('app_data');
        $user = $query->row();
        $c = $user->category;
        if($c!=NULL){
            $category = explode(',', $c);
            foreach ($category as $cat) {
                $catN = $this->db->get_where('wp5q_terms', array('term_id' => $cat))->row();
                $catX['name'] = $catN->name;
                $catX['id'] = $cat;
                $result[] = $catX;
            }
            return $result;
        }else{
            $cNew = "65,35,36,8248,8096,131,12849,3490,92,27,8403,2639,16,3632";
            $category = explode(',', $cNew);
            foreach ($category as $cat) {
                $catN = $this->db->get_where('wp5q_terms', array('term_id' => $cat))->row();
                $catX['name'] = $catN->name;
                $catX['id'] = $cat;
                $result[] = $catX;
            }
            return $result;
        }
    }
    public function postUserCategory($user_id, $category){
        // $category = implode(',', $category);
        $this->db->where('user_id', $user_id);
        $this->db->update('app_data', array('category' => $category));
        return true;
    }
    public function forgotPassword($email){
        $user = $this->db->get_where('app_data', array('email' => $email))->result_array();
        if ($user) {
            $user = $user[count($user) - 1];
            $OTP = rand(1000, 9999);
            $user_id = $user['user_id'];
            $this->db->where('user_id', $user_id);
            $this->db->update('app_data', array('OTP' => $OTP));
            $result = array(
                'user_id'=> $user_id
            );
            if($this->sendOTP($email, $OTP)){
                return $result;
            }else{
                return false;
            }
        } else {
            return false;
        }
    }
    public function sendOTP($email, $OTP){
        $this->load->library('email');
        $this->load->config('email');
        $this->email->from($this->config->item('smtp_user'), 'Admin');
        $this->email->to($email);
        $this->email->subject('OTP');
        $this->email->message('Your OTP is '.$OTP);
        if($this->email->send()){
            return true;
        }else{
            return false;
        }
    }
    public function verifyOTP($user_id, $OTP){
        $user = $this->db->get_where('app_data', array('user_id' => $user_id))->result_array();
        if ($user) {
            $user = $user[count($user) - 1];
            $user_id = $user['user_id'];
            $user_otp = $user['OTP'];
            $result = array(
                'user_id' => $user_id
            );
            if($user_otp == $OTP){
                return $result;
            }else{
                return false;
            }
        } else {
            return false;
        }
    }
    public function resetPassword($user_id, $password){
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $user = $this->db->get_where('app_data', array('user_id' => $user_id))->result_array();
        if ($user) {
            $wp_user = $this->db->get_where('wp5q_users', array('ID' => $user_id))->result_array();
            if($wp_user){
                $wp_user = $wp_user[count($wp_user) - 1];
                $this->db->where('ID', $wp_user['ID']);
                $this->db->update('wp5q_users', array('user_pass' => $hashed_password));
            }
            $user = $user[count($user) - 1];
            $this->db->where('user_id', $user['user_id']);
            $this->db->update('app_data', array('password' => $hashed_password, 'old_password' => $user['password']));
            return true;
        } else {
            return false;
        }
    }
    public function getOTP($user_id){
        $user = $this->db->get_where('app_data', array('user_id' => $user_id))->result_array();
        if ($user) {
            $user = $user[count($user) - 1];
            $user_id = $user['user_id'];
            $user_otp = $user['OTP'];
            $result = array(
                'user_id' => $user_id,
                'OTP' => $user_otp
            );
            return $result;
        } else {
            return false;
        }
    }
}
