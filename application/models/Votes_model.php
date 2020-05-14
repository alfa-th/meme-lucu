<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Votes_model extends CI_Model
{
  public function insert_or_update_vote($username, $post_id, $newState)
  {
    $data = [
      "id" => $username . "_" . $post_id,
      "username" => $username,
      "post_id" => $post_id,
      "state" => $newState
    ];

    return $this->db->replace("vote", $data);
  }

  public function get_total_votes_from_postid($post_id)
  {
    $query = $this->db->query("
    SELECT 
    (SELECT COUNT(*) FROM `vote` WHERE post_id = ? AND state = 'Y') 
    - 
    (SELECT COUNT(*) FROM `vote` WHERE post_id = ? AND state = 'N')
    AS count
    ", [$post_id, $post_id]);

    return $query->row()->count;
  }

  public function get_vote_state_from_username_postid($username, $post_id)
  {
    $query = $this->db->get_where("vote", [
      "username" => $username,
      "post_id" => $post_id
    ]);

    return $query->row()->state;
  }
}
