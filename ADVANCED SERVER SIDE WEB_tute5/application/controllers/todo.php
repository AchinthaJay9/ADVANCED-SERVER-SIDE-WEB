<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Todo extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('todolist');
		$this->load->library('session');
	}

    public function index() {
        // Load the view containing the To-Do form
		// Load session library
		$username = $this->session->username;
		$actions = $this->todolist->getlist($username);
        $this->load->view('todo_view',array('actions'=> $actions));
    }

	public function add()
	{
		$username = $this->session->username;
		$action = $this->input->post('action');
		$this->todolist->add($username,$action);

		redirect('/todo/');
	}

	private function userid()
	{
		if(!isset($this->session->username)){
			$this->session->username = uniquid();
			$username = $this->session->username;
		}
		else{
			$username = $this->session->username;
		}
		return $username;
	}
}
