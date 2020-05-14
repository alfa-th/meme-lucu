<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Upload extends CI_Controller
{
  public $upload_path  = "./images/";

  public function __construct()
  {
    parent::__construct();

    // Tetapkan konfigurasi library pada variabel config
    $config['upload_path']   = $this->upload_path;
    $config['allowed_types'] = 'jpg|png';
    $config['encrypt_name']  = TRUE;
    $config['max_width']     = 2048;
    // $config['min_width']    = 100;
    $config['max_height']    = 2048;
    // $config['min_height']    = 100;

    // Lakukan inisialisasi library dengan variabel config
    $this->load->library('upload', $config);

    // Lakukan inisialisasi model
    $this->load->model('posts_model');

    // Lakukan redirect apabila user tidak masuk
    if ($this->session->userdata("logged_in") == FALSE) {
      $this->session->set_flashdata("error", ["Silahkan login terlebih dahulu"]);
      redirect(base_url("login"));
    }
  }

  public function upload_action()
  {
    // Lakukan proses atau fungsi upload menggunakan gambar yang ada di POST dengan nama form image-file
    // Jika fungsi mengembalikan FALSE, maka ada error dan lakukan redirect 
    if (!$this->upload->do_upload('image-file')) {
      // Inisiasi sebuah array kosong yang akan diisi oleh errors string
      $errors = [];
      // Isi array error dengan hasil fungsi display_errors
      switch ($this->upload->display_errors("", "")) {
        case "invalid_filesize":
          array_push($errors, "Ukuran file terlalu besar");
        case "invalid_filetype":
          array_push($errors, "Mohon gunakan file dengan format jpg atau png");
        case "invalid_dimensions":
          array_push($errors, "Dimensi file terlalu besar atau kecil");
      }

      // Jika ada error yang dapat dijelaskan, maka gunakan penjelasan tersebut, 
      // jika tidak ada, maka gunakan penjelasan umum
      // $errors = $errors == [] ? ["Terjadi kesalahan pada saat mengupload"] : $errors;
      $errors = $errors == [] ? [$this->upload->display_errors()] : $errors;

      // Taruh error di flashdata agar dapat di tampilkan ke user dan redirect
      $this->session->set_flashdata("error", $errors);
      redirect(base_url("upload"));
    }

    // Siapkan data query dari POST maupun hasil upload
    $query_data = [
      "poster" => $this->session->userdata("username"),
      "judul" => $this->input->post("judul"),
      "img_link" => $this->upload_path.$this->upload->data("file_name"),
      "kategori" => $this->input->post("kategori").","
    ];

    // Lakukan insert post pada database dengan keterangan gambar dan post
    // Apabila fungsi insert_post mengembalikan FALSE, maka ada kesalahan yang terjadi di database
    // Sehingga beritahu user melalui flashdata dan lakukan redirect
    $post_id = $this->posts_model->insert_post(...array_values($query_data));
    if ($post_id == FALSE) {
      $this->session->set_flashdata("error", "Terjadi kesalahan pada database, mohon upload ulang");
      return redirect(base_url("upload"));
    };

    // Beritahu apabila proses upload sukses pada flashdata dan redirect ke post yang bersangkutan
    $this->session->set_flashdata("success", ["Upload sukses", $post_id, $query_data]);
    return redirect(base_url("upload"));
  }

  // Fungsi yang meng-serve halaman ke client
  public function load()
  {
    $this->load->view("pages/upload/index");
  }
}
