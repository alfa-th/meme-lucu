<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Beranda extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();

    $this->load->model('posts_model');
  }

  public function load()
  {
    // Dapatkan semua meme yang ada pada database
    $data = [
      "all_posts" => $this->posts_model->get_all_posts()
    ];

    $this->load->view("pages/beranda/index", $data);
  }
}
