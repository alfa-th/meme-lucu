<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Posts_model extends CI_Model
{
  public function insert_post($poster, $judul, $img_link, $kategori)
  {
    $result_state = $this->db->insert("post", [
      "poster" => $poster,
      "judul" => $judul,
      "img_link" => $img_link,
      "kategori" => $kategori
    ]);
    
    if($result_state == TRUE) {
      return $this->db->insert_id();
    } else {
      return FALSE;
    }
  }

  public function get_all_posts()
  {
    $this->db->order_by("created_at ASC");
    $query = $this->db->get("post");

    return $query->result_array();
  }
}
