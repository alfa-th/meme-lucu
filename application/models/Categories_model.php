<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Categories_model extends CI_Model
{
  public function get_all_categories()
  {
    $query = $this->db->get("common_category");

    return $query->result_array();
  }
}
