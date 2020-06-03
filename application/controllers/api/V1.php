<?php
defined("BASEPATH") or exit("No direct script access allowed");

class V1 extends CI_Controller
{
  public function __construct()
  {
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    $method = $_SERVER['REQUEST_METHOD'];
    if ($method == "OPTIONS") {
      die();
    }

    parent::__construct();

    $this->load->model("votes_model");
    $this->load->model("categories_model");
    $this->load->model("posts_model");
  }

  private function bad_request()
  {
    // Set header 400 agar tidak memperlihatkan error backend
    return $this->output->set_header('HTTP/1.1 400 BAD REQUEST');
  }

  // Testing apabila API root bekerja
  public function index()
  {
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode(array('foo' => 'bar')));
  }

  // API untuk mendapatkan post dalam jumlah halaman
  public function page($page_number = NULL)
  {
    // Cek apabila parameter yang dimasukkan oleh client sesuai, jika tidak, set bad request
    if (empty($page_number)) {
      return $this->bad_request();
    }

    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode(array('foo' => $page_number)));
  }

  // API untuk mendapatkan post dalam jarak 
  public function range($range_start = NULL, $range_end = NULL)
  {
    // Cek apabila parameter yang dimasukkan oleh client sesuai, jika tidak, set bad request
    if (empty($range_Start) || empty($range_end)) {
      return $this->bad_request();
    }

    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode(array('foo' => $range_start)));
  }

  // API untuk mendapatkan vote state suatu post dengan username 
  public function get_vote_state($username = NULL, $post_id = NULL)
  {
    // Cek apabila parameter yang dimasukkan oleh client sesuai, jika tidak, set bad request
    if (empty($username) || empty($post_id)) {
      return $this->bad_request();
    }

    // Lakukan query pada database untuk mendapatkan vote state post
    $vote_state = $this->votes_model->get_vote_state_from_username_postid($username, $post_id);

    // Serve vote state dalam bentuk json
    return $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode(array('state' => $vote_state)));
  }

  // API untuk mendapatkan vote count suatu post 
  public function get_votes($post_id)
  {
    if (empty($post_id)) {
      return $this->bad_request();
    }

    // Lakukan query pada database untuk mendapatkan total vote post
    $vote_count = $this->votes_model->get_total_votes_from_postid($post_id);

    // Serve vote state dalam bentuk json
    return $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode(array('count' => $vote_count)));
  }

  public function get_category($post_id)
  {
    if (empty($post_id)) {
      return $this->bad_request();
    }

    $category_string = $this->posts_model->get_category_from_postid($post_id);
    $categories = explode(",", $category_string);

    return $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode(array('category' => $categories)));
  }

  public function get_all_categories()
  {
    $categories_type = $this->categories_model->get_all_categories();

    return $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode(array('categories_type' => $categories_type)));
  }
  
}
