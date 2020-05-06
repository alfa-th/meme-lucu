<?php
defined("BASEPATH") or exit("No direct script access allowed");

class V1 extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();

    $this->load->model("votes_model");
  }

  public function index()
  {
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode(array('foo' => 'bar')));
  }

  public function page($page_number)
  {
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode(array('foo' => $page_number)));
  }

  public function range($range)
  {
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode(array('foo' => $range)));
  }

  public function getState($username, $post_id)
  {
    $state = $this->votes_model->getStateFromUsernamePostID($username, $post_id);

    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode(array('state' => $state)));
  }

  
}
