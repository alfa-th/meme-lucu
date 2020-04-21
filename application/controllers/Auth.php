<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Auth extends CI_Controller
{
  public function index()
  {
    $this->render("login");
  }

  public function register()
  {
    // Ambil data yang ada POST
    $data = [
      "request" => [
        "email" => $this->input->post("email"),
        "username" => $this->input->post("username"),
        "password" => $this->input->post("password"),
        "confirm_password" => $this->input->post("confirm_password"),
        "setuju" => $this->input->post("setuju") == "on" ? true : false
      ]
    ];
    
    // Email harus ada dan harus sesuai dengan format email
    $this->form_validation->set_rules(
      "email",
      "Email",
      "required|valid_email",
      [
        "required" => "Email harus diisi",
        "valid_email" => "Format email tidak sesuai",
      ]
    );

    // Username harus ada dan harus mempunyai panjang lebih dari 5 karakter
    $this->form_validation->set_rules(
      "username",
      "Username",
      "required|min_length[5]",
      [
        "required" => "Username harus diisi",
        "min_length" => "Username harus melebihi 5 karakter",
      ]
    );

    // Password harus ada dan harus mempunyai panjang lebih dari 5 karakter
    $this->form_validation->set_rules(
      "password",
      "Password",
      "required|min_length[5]",
      [
        "required" => "Password harus diisi",
        "min_length" => "Password harus melebihi 5 karakter",
      ]
    );

    // Confirm password harus ada dan mengikuti nilai yang dimiliki oleh password
    $this->form_validation->set_rules(
      "confirm_password",
      "Confirm Password",
      "required|matches[password]",
      [
        "required" => "Password harus diisi",
        "matches" => "Password dan Confirm Password tidak sama",
      ]
    );

    $this->form_validation->set_rules(
      "setuju",
      "Menyetujui syarat penggunaan",
      "required",
      [
        "required" => "Pengguna harus menyetujui syarat dan ketentuan untuk mendaftar",
      ]
    );

    if ($this->form_validation->run() == FALSE) {
      // Ambil error validasi dan taruh di flash dan redirect ulang ke URI login
      $this->session->set_flashdata("validation_errors", $this->form_validation->error_array());
      redirect(base_url("register"));
    } else {
      $this->load->view("pages/beranda/index", $data);
    }

    // Lakukan pengecekan username dan password pada database
    //    Jika username tidak ada atau password salah , set flash username/password yang dimasukkan tidak cocok pada data yang ada di sistem
    //    Jika username ada dan password benar, set session secara umum
  }

  public function login()
  {
    $data = [
      "request" => [
        "username" => $this->input->post("username"),
        "password" => $this->input->post("password"),
        "checkbox" => $this->input->post("remember-me") == "on" ? true : false
      ]
    ];

    // Username harus ada dan harus mempunyai panjang lebih dari 5 karakter
    $this->form_validation->set_rules(
      "username",
      "Username",
      "required|min_length[5]",
      [
        "required" => "Username harus diisi",
        "min_length" => "Username harus melebihi 5 karakter",
      ]
    );

    // Username harus ada dan harus mempunyai panjang lebih dari 5 karakter
    $this->form_validation->set_rules(
      "password",
      "Password",
      "required|min_length[5]",
      [
        "required" => "Password harus diisi",
        "min_length" => "Password harus melebihi 5 karakter",
      ]
    );

    if ($this->form_validation->run() == FALSE) {
      // Ambil error-error validasi lalu taruh di flash dan redirect ulang ke URI login
      $this->session->set_flashdata("validation_errors", $this->form_validation->error_array());
      redirect(base_url("login"));
    } else {
      $this->load->view("pages/beranda/index", $data);
    }

    // Lakukan pengecekan username dan password pada database
    //    Jika username tidak ada atau password salah , set flash username/password yang dimasukkan tidak cocok pada data yang ada di sistem
    //    Jika username ada dan password benar, set session secara umum
  }

  public function render($page)
  {
    switch ($page) {
      case "login":
        $this->load->view("pages/login/index");
        break;

      case "register":
        $this->load->view("pages/register/index");
        break;
    }
  }
}
