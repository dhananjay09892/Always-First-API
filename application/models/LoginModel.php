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
                if($app_data_user['isVerified'] == 0){
                    $this->forgotPassword($app_data_user['email']);
                    $data['message'] = 'OTP has been sent to your email';
                    return array('isVerified' => false, 'message' => $data['message']);
                }else{
                    $result = array(
                        'user_id' => (int)$app_data_user['user_id'],
                        'email' => $app_data_user['email'],
                        'name' => $app_data_user['name'],
                        'category' => $app_data_user['category'],
                        'isVerified' => true
                    );
                    return $result;
                }
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
                'old_password' => '',
                'device_id' => $device_id,
                'device_token' => $device_token,
                'category' => '',
                'login_type' => $login_type,
                'OTP' => '',
                'Created_at' => date('Y-m-d H:i:s'),
                'isVerified' => 0
            );
            $this->db->insert('app_data', $app_data);
            $this->forgotPassword($post_data['email']);
            $data['message'] = 'OTP has been sent to your email';
            $data['category'] = '';
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
        if ($c != NULL || $c != '') {
            $category = explode(',', $c);
            foreach ($category as $cat) {
                $catN = $this->db->get_where('wp5q_terms', array('term_id' => $cat))->row();
                $catname = $catN->name;
                $catX['name'] = html_entity_decode($catname);
                $catX['id'] = $cat;
                $result[] = $catX;
            }
            return $result;
        }else{
            // get all data from category_setting table 
            // $this->db->where('user_id', $user_id);
            $query = $this->db->get('category_setting');
            $user = $query->result_array();
            foreach ($user as $cat) {
                $catN = $this->db->get_where('wp5q_terms', array('term_id' => $cat['cat_id']))->row();
                $catname = $catN->name;
                $catX['name'] = html_entity_decode($catname);
                $catX['id'] = $cat['cat_id'];
                $result[] = $catX;
            }
            // $cNew = "154,114,43,94,166,101,80";
            // $category = explode(',', $cNew);
            // foreach ($category as $cat) {
            //     $catN = $this->db->get_where('wp5q_terms', array('term_id' => $cat))->row();
            //     $catX['name'] = $catN->name;
            //     $catX['id'] = $cat;
            //     $result[] = $catX;
            // }
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
        $this->email->from($this->config->item('smtp_user'), 'Always First Admin');
        $this->email->to($email);
        $this->email->subject('Always First OTP');
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
                $this->db->where('user_id', $user_id);
                // update isVerified to 1 and OTP to NULL
                $this->db->update('app_data', array('isVerified' => 1, 'OTP' => ''));
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
    public function getProfile($user_id){
        $user = $this->db->get_where('app_data', array('user_id' => $user_id))->result_array();
        if(count($user) >= 1 ){
            $user = $user[count($user) - 1];
            $result = array(
                'user_id' => $user['user_id'],
                'email' => $user['email'],
                'name' => $user['name']
            );
            return $result;
        }else {
            return false;
        }
    }
    public function updateProfile($user_id, $name, $email){
        if($name != NULL){
            $this->db->where('user_id', $user_id);
            $this->db->update('app_data', array('name' => $name));
        }
        if($email != NULL){
            $this->db->where('user_id', $user_id);
            $this->db->update('app_data', array('email' => $email));
        }
        return true;
    }
    public function deleteUser($user_id){
        // check if user is exist in wp5q_users and app_data and wp5q_usermeta
        $user = $this->db->get_where('app_data', array('user_id' => $user_id))->result_array();
        if (count($user) >= 1) {
            $this->db->where('ID', $user_id);
            $this->db->delete('wp5q_users');
            $this->db->where('user_id', $user_id);
            $this->db->delete('app_data');
            $this->db->where('user_id', $user_id);
            $this->db->delete('wp5q_usermeta');
            return true;
        } else {
            return false;
        }
    }
}
