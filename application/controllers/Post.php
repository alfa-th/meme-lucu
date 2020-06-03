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
  public function index($post_number = NULL)
  {
    if ($post_number == NULL) {
      return redirect(base_url("/beranda"));
    }
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
      case "report":
        $this->posts_model->report_post($post_id);
        break;
      case "delete":
        $this->posts_model->delete_from_postid($post_id);
        break;
    }
  }

  // Fungsi yang meng-serve halaman ke client
  public function load($post_id = NULL)
  {
    $data = [
      "post_data" => $this->posts_model->get_post_from_postid($post_id),
      "post_id" => $post_id
    ];

    if(!empty($data["post_data"])) {
      return $this->load->view("pages/post/index", $data);
    } else {
      return $this->load->view("pages/post/empty");
    }
  }
}
