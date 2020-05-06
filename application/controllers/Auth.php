<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Auth extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();

    $this->load->model('users_model');
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

    // User harus menyetujui syarat dan ketentuan
    $this->form_validation->set_rules(
      "setuju",
      "Menyetujui syarat dan ketentuan penggunaan",
      "required",
      [
        "required" => "Pengguna harus menyetujui syarat dan ketentuan untuk mendaftar",
      ]
    );

    // Lakukan validasi form 
    // Apabila ada validasi yang salah : Ambil salahnya validasi dan taruh di flash dan redirect ulang ke URI login
    // Apabila tidak ada : Lakukan operasi database
    if ($this->form_validation->run() == FALSE) {
      $this->session->set_flashdata("error", array_values($this->form_validation->error_array()));
      return redirect(base_url("register"));
    }

    // Cek apabila email sudah dipakai atau belum
    // Apabila sudah dipakai : Beritahu user dengan menaruh pemberitahuan di flash
    if ($this->users_model->is_email_exists($data["request"]["email"]) == TRUE) {
      $this->session->set_flashdata("error", ["Email sudah dipakai"]);
      return redirect(base_url("register"));
    }

    // Cek apabila username sudah dipakai atau belum
    // Apabila sudah dipakai : Beritahu user dengan menaruh pemberitahuan di flash
    if ($this->users_model->is_username_exists($data["request"]["username"]) == TRUE) {
      $this->session->set_flashdata("error", ["Username sudah dipakai"]);
      return redirect(base_url("register"));
    }

    // Siapkan data yang akan diregistrasikan
    // Lakukan hasing pada password dengan algoritma BCrypt
    $data["register_data"] = [
      "email" => $data["request"]["email"],
      "username" => $data["request"]["username"],
      "password" => password_hash($data["request"]["password"], PASSWORD_DEFAULT)
    ];


    // Registrasikan user kedalam database sesuai data yang sudah disiapkan
    // Jika ada kesalahan yang terjadi pada insert, maka user akan diberitahu melalui flash dan diredirect ke halaman registrasi ulang
    if ($this->users_model->register_new_user(...array_values($data["register_data"])) == FALSE) {
      $this->session->set_flashdata("error", "Terjadi kesalahan pada database, mohon registrasi ulang");
      return redirect(base_url("register"));
    }

    // Taruh pemberitahuan di flash dan redirect user
    $this->session->set_flashdata("success", ["Registrasi sukses, silahkan masuk"]);
    return redirect(base_url("login"));
  }

  public function login()
  {
    $data["request"]["username"] = $this->input->post("username");
    $data["request"]["password"] = $this->input->post("password");
    $data["request"]["checkbox"] = $this->input->post("remember-me") == "on" ? TRUE : FALSE;

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

    // Jalankan form validation
    if ($this->form_validation->run() == FALSE) {
      // Ambil error-error validasi lalu taruh di flash dan redirect ulang ke URI login
      $this->session->set_flashdata("error", array_values($this->form_validation->error_array()));
      redirect(base_url("login"));
    }

    // Cek apabila username ada
    // Apabila sudah tidak ada : Beritahu user dengan menaruh pemberitahuan di flash
    if ($this->users_model->is_username_exists($data["request"]["username"]) == FALSE) {
      $this->session->set_flashdata("error", ["Username tidak ditemukan"]);
      return redirect(base_url("login"));
    }

    // Ambil password yang ada dalam bentuk hash dan lakukan pengecekan kesamaan 
    // Apabila sudah tidak : Beritahu user dengan menaruh pemberitahuan di flash
    $hashed_password = $this->users_model->get_hashed_password($data["request"]["username"]);
    if (password_verify($data["request"]["password"], $hashed_password) == FALSE) {
      $this->session->set_flashdata("error", ["Password salah"]);
      return redirect(base_url("login"));
    }

    // Siapkan data session user
    $data["session"]["logged_in"] = TRUE;
    $data["session"]["username"] = $data["request"]["username"];

    // Modifikasi session user
    $this->session->set_userdata($data["session"]);

    // Taruh pemberitahuan di flash dan redirect user
    $this->session->set_flashdata("success", ["Login sukses"]);
    return redirect(base_url("beranda"));
  }

  public function logout()
  {
    $userdatas = [
      "logged_in", "username"
    ];

    $this->session->unset_userdata($userdatas);
    $this->session->set_flashdata("success", ["Logout sukses"]);

    redirect(base_url("login"));
  }

  public function load($page)
  {
    switch ($page) {
      case "login":
        if ($this->session->userdata("logged_in") == TRUE) {
          $this->session->set_flashdata("error", ["Silahkan login terlebih dahulu"]);
          redirect(base_url(""));
        }

        $this->load->view("pages/login/index");
        break;
      case "register":
        if ($this->session->userdata("logged_in") == TRUE) {
          $this->session->set_flashdata("error", ["Silahkan login terlebih dahulu"]);
          redirect(base_url(""));
        }

        $this->load->view("pages/register/index");
        break;
    }
  }
}
