<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Users_model extends CI_Model
{
  public function is_username_exists($username)
  {
    // Query user dengan username parameter 
    $query = $this->db->get_where("user", [
      "username" => $username
    ]);

    // Jika hasil query kosong, kembalikan false, jika ada, kembalikan true
    if (empty($query->result_array())){
      return false;
    } else {
      return true;
    }
  }

  public function is_email_exists($email)
  {
    // Query user dengan email parameter 
    $query = $this->db->get_where("user", [
      "email" => $email
    ]);

    // Jika hasil query kosong, kembalikan false, jika ada, kembalikan true
    if (empty($query->result_array())){
      return false;
    } else {
      return true;
    }
  }

  public function get_hashed_password($username)
  {
    // Query user dengan username parameter 
    $query = $this->db->get_where("user", [
      "username" => $username
    ]);

    // row() digunakan karena hanya mengembalikan 1 hasil
    return $query->row()->password;
  }

  // $data = [
  //   "request" => [
  //     "email" => $this->input->post("email"),
  //     "username" => $this->input->post("username"),
  //     "password" => $this->input->post("password"),
  //     "confirm_password" => $this->input->post("confirm_password"),
  //     "setuju" => $this->input->post("setuju") == "on" ? true : false
  //   ]
  // ];

  public function register_new_user($email, $username, $hashed_password)
  {
    return $this->db->insert("user", [
      "email" => $email,
      "username" => $username,
      "password" => $hashed_password
    ]);
  }
}
