<?php
defined("BASEPATH") or exit("No direct script access allowed");

class V1 extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode(array('foo' => 'bar')));
  }
}
