<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Post extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();

    $this->load->model("votes_model");
    $this->load->model("posts_model");
  }

  // Fungsi yang meng-serve halaman post 
  public function index($post_number)
  {
  }

  // API untuk aksi upvote, downvote, dan neutralize
  public function action($action_type, $post_id)
  {
    $username = $this->session->userdata("username");

    switch ($action_type) {
      case "upvote":
        $this->votes_model->insert_or_update_vote($username, $post_id, "Y");
        break;
      case "downvote":
        $this->votes_model->insert_or_update_vote($username, $post_id, "N");
        break;
      case "neutralize":
        $this->votes_model->insert_or_update_vote($username, $post_id, "-");
        break;
    }
  }

  // Fungsi yang meng-serve halaman ke client
  public function load()
  {
    $this->load->view("pages/beranda/index");
  }
}
