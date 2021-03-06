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

  public function is_username_admin($username)
  {
    $query = $this->db->get_where("user", [
      "username" => $username
    ]);

    if($query->row()->type == "admin") {
      return true;
    } else {
      return false;
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

  public function register_new_user($email, $username, $hashed_password)
  {
    return $this->db->insert("user", [
      "email" => $email,
      "username" => $username,
      "password" => $hashed_password
    ]);
  }

  public function get_user_from_username($username)
  {
    $query = $this->db->get_where("user", [
      "username" => $username
    ]);

    $result = $query->row_array();
    unset($result["password"]);
    
    return $result;
  }

  public function get_totalvotes_from_username($username)
  {
    $query = $this->db->query("
    SELECT 
    (SELECT COUNT(*) FROM vote LEFT JOIN post ON vote.post_id = post.id WHERE state = 'Y' AND post.poster = ?) 
    -
    (SELECT COUNT(*) FROM vote LEFT JOIN post ON vote.post_id = post.id WHERE state = 'N' AND post.poster = ?) AS count 
    ", [$username, $username]);

    return $query->row()->count;
  }
}
