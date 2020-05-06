<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Votes_model extends CI_Model
{
  public function insertOrUpdateVote($username, $post_id, $newState)
  {
    $data = [
      "id" => $username."_".$post_id,
      "username" => $username,
      "post_id" => $post_id,
      "state" => $newState
    ];

    return $this->db->replace("vote", $data);
  }
  
  public function getTotalVotes($post_id)
  {
    
  }

  public function getStateFromId($id)
  {
    $query = $this->db->get("vote", [
      "id" => $id
    ]);

    return $query->row()->state;
  }

  
  public function getStateFromUsernamePostID($username, $post_id)
  {
    $query = $this->db->get_where("vote", [
      "username" => $username,
      "post_id" => $post_id
    ]);

    return $query->row()->state;
  }
}
