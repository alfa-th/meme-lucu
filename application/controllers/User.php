<?php
defined("BASEPATH") or exit("No direct script access allowed");

class User extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();

    $this->load->model("users_model");
    $this->load->model("posts_model");
  }

  // Fungsi yang meng-serve halaman post 
  public function index($user_name = NULL)
  {
    if ($user_name == NULL) {
      return redirect(base_url("/beranda"));
    }
  }

  // Fungsi yang meng-serve halaman ke client
  public function load($username)
  {
    $data = [
      "user_data" => $this->users_model->get_user_from_username($username),
      "username" => $username,
      "all_posts" => $this->posts_model->get_allposts_from_username($username),
      "total_votes" => $this->users_model->get_totalvotes_from_username($username)
    ];

    if(!empty($data["user_data"])) {
      return $this->load->view("pages/user/index", $data);
    } else {
      return $this->load->view("pages/user/empty");
    }
  }
}
