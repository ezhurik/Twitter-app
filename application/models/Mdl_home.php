<?php

class Mdl_home extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
   	function getTweets($username)
   	{
   		return $this->db->select('tweets')->where('username',$username)->row();
   	}

    public function saveFollowers($params)
    {
        $this->db->insert('followers_p',$params);
    }
    
}
?>

