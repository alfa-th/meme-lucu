<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
  public function register()
  {
  }

  public function login()
  {
    $data = [
      "request" => [
        "username" => $this->input->post("username"),
        "password" => $this->input->post("checkbox"),
        "checkbox" => $this->input->post("checkbox")
      ]
    ];

    $this->load->view("pages/home/index", $data);
  }
}
