<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Lapor extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();

    $this->load->model('posts_model');

    if ($this->session->userdata("is_admin") == FALSE) {
      $this->session->set_flashdata("error", ["Hanya admin yang boleh mengakses"]);
      redirect(base_url(""));
    }
  }

  // Fungsi yang meng-serve halaman ke client
  public function load()
  {
    // Dapatkan meme yang dilapor yang ada pada database
    $data = [
      "all_posts" => $this->posts_model->get_all_reported_posts()
    ];

    $this->load->view("pages/lapor/index", $data);
  }
}
