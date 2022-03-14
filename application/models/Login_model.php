<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login_model extends CI_Model
{
    public function check(string $email, string $password)
    {
        $get = $this->db->get_where('tbl_user',['email' => $email,'password' => md5($password)])->row_array();
        return $get;
    }
}