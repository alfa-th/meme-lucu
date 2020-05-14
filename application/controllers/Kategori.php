<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Kategori extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();

    $this->load->model("votes_model");
    $this->load->model("posts_model");
  }

  // Fungsi yang meng-serve halaman-halaman kategori 
  public function index($kategori_name = NULL)
  {
    if ($kategori_name == NULL) {
      return redirect(base_url("/beranda"));
    }
  }

  // Fungsi yang meng-serve halaman-halaman kategori 
  public function load($category_name = NULL)
  {
    if ($category_name == NULL) {
      return redirect(base_url("/beranda"));
    }

    $data = [
      "categorized_data" => $this->posts_model->get_posts_from_category($category_name),
      "category_name" => $category_name
    ];

    return $this->load->view("pages/kategori/index", $data);
  }
}
