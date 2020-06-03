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

    if ($result_state == TRUE) {
      return $this->db->insert_id();
    } else {
      return FALSE;
    }
  }

  public function delete_from_postid($post_id)
  {
    $result_state = $this->db->delete("post", [
      "id" => $post_id,
    ]);

    return $result_state;
  }

  public function get_all_posts($sort = "created_at")
  {
    if ($sort == "votes") {
      $query = $this->db->query("
      SELECT
        post.*,
        vote.post_id,
        SUM(
            CASE vote.state WHEN 'Y' THEN 1 WHEN 'N' THEN -1
        END
        ) AS votes
      FROM
          vote
      LEFT JOIN post ON vote.post_id = post.id
      GROUP BY
          vote.post_id
      ORDER BY votes DESC
      ");
    } else {
      $this->db->order_by($sort . " ASC");
      $query = $this->db->get("post");
    }

    return $query->result_array();
  }

  public function get_allposts_from_username($username)
  {
    $query = $this->db->get_where("post", [
      "poster" => $username
    ]);

    return $query->result_array();
  }

  public function get_post_from_postid($post_id)
  {
    $query = $this->db->get_where("post", [
      "id" => $post_id
    ]);

    return $query->row_array();
  }

  public function get_category_from_postid($post_id)
  {
    $query = $this->db->get_where("post", [
      "id" => $post_id
    ]);

    return $query->row()->kategori;
  }

  public function get_posts_from_category($category)
  {
    $query = $this->db
      ->select("*")
      ->from("post")
      ->like("kategori", $category, "both")
      ->get();

    return $query->result_array();
  }

  public function report_post($post_id)
  {
    $query = $this->db->query("
      UPDATE post
      SET report_count = report_count + 1
      WHERE id = ?
    ", [$post_id]);

    return $query;
  }

  public function get_all_reported_posts()
  {
    $query = $this->db->query("
    SELECT * FROM POST WHERE report_count > 0 ORDER BY report_count DESC 
    ");

    return $query->result_array();
  }
}
