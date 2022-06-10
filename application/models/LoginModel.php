<?php
defined('BASEPATH') or exit('No direct script access allowed');


class LoginModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('Curl');
    }
    public function login($email, $password)
    {
        // // get user data from database
        // $this->db->where('username', $email);
        // $query = $this->db->get('users');
        // $user = $query->row();
        // if ($user) {
        //     // check if password is correct
        //     $hash = $user->password;
        //     if (password_verify($password, $hash)) {
        //         // user is found
        //         $user->password = null;
        //         return $user;
        //     } else {
        //         return false;
        //     }
        // } else {
        //     return false;
        // }
    }
    public function register($post_data)
    {
        // `user_login`, `user_pass`, `user_nicename`, `user_email`, `user_url`, `user_registered`, `user_activation_key`, `user_status`, `display_name
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
            $app_data = array(
                'email' => $post_data['email'],
                'name' => $post_data['name'],
                'password' => password_hash($post_data['password'], PASSWORD_DEFAULT),
                'old_password' => NULL,
                'device_id' => $device_id,
                'device_token' => $device_token
            );
            $this->db->insert('app_data', $app_data);
            return $data;
        }
        return false;
    }
    public function checkUserdata($data)
    {
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
}
