<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Upload extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();

    $config['upload_path']   = './images/';
    $config['allowed_types'] = 'gif|jpg|png';
    $config['encrypt_name']  = TRUE;
    $config['max_size']      = 100;
    $config['max_width']     = 1024;
    $config['max_height']    = 768;

    $this->load->library('upload', $config);

    if ($this->session->userdata("logged_in") == FALSE) {
      $this->session->set_flashdata("error", ["Silahkan login terlebih dahulu"]);
      redirect("login");
    }
  }

  public function upload_action()
  {
    if (!$this->upload->do_upload('image-file')) {
      $this->session->set_flashdata("error", ["Terjadi kesalahan pada saat mengupload"]);
      redirect("/upload");
    } else {
      $this->session->set_flashdata("success", $this->upload->data());
      redirect("/upload");
    }
  }

  public function load()
  {
    $this->load->view("pages/upload/index");
  }
}
