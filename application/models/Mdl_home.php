<?php

class Mdl_home extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function checkAndRetrieveFollowers($username)
    {
        // $res=$this->db->select('user_id')->where('username',$username)->get('followers')->row();
        return $this->db->select('followers')->where('username',$username)->get('followers')->result_array();
    }

    public function saveFollowers($username,$followers)
    {
      $data=array(
        'username'=>$username,
        'followers'=>$followers
      );
      $this->db->insert('followers',$data);
    }

   	function getTweets($username)
   	{
   		return $this->db->select('tweets')->where('username',$username)->row();
   	}

}
?>

