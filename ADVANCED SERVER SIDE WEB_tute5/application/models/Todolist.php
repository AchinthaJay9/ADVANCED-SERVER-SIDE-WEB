<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Todolist extends CI_Model {
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

    function getlist($userid)
	{
        $this->db->where('user_id',$userid);
		$res = $this->db->get('todo_actions');
		if($res->num_rows() == 0){
			return false;
		}
		$actions = array();
		foreach($res->result() as $row){
			$actions[] = $row->action;
		}
		return $actions;
    }

	function add($userid,$action)
	{
		$this->db->insert('todo_actions',array('userid'=> $userid, 'action'=> $action));
	}
}
