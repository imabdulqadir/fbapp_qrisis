<?php
class Appm extends CI_Model{

	function __construct(){
		
		parent::__construct();
	}
	function insertdb($datatoinsert)
	{
		$this->db->insert('users',$datatoinsert);
	}
	function updatecount($fbid)
	{
		$this->db->set('count', ' count+1 ' ,FALSE);
		$this->db->where('fbid',$fbid);
		$this->db->update('users');
	}
}