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

  public function index($post_number)
  {
  }

  public function action($action_type, $post_id)
  {
    $username = $this->session->userdata("username");

    switch ($action_type) {
      case "upvote":
        $this->votes_model->insertOrUpdateVote($username, $post_id, "Y");
        
        break;
      case "downvote":
        $this->votes_model->insertOrUpdateVote($username, $post_id, "N");
        
        break;
      case "netral":
        $this->votes_model->insertOrUpdateVote($username, $post_id, "=");
        
        break;
    }
  }

  public function load()
  {
    $this->load->view("pages/beranda/index");
  }
}
