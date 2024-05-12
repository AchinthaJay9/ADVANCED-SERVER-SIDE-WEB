<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Like extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('like_model');
		$this->load->library('session');
	}


	public function index(){

		if (!isset($this->session->userdata['login']) ||
			$this->session->userdata['login'] == null){

			echo json_encode(array(
				'success' => false,
				'message' => "Not logged in",
			));
			return;
		}

		$id = $this->session->userdata('login');

		if ($this->input->server('REQUEST_METHOD') === 'POST') {

			$input = json_decode($this->input->raw_input_stream, true);

			if (isset($input['answer']) && $input['answer'] != null) {

				//Remove likes for answer by user single line
				$this->db->delete('like', array(
					'answer' => $input['answer'],
					'uid' => $id
				));

				$this->db->insert('like', array(
					'answer' => $input['answer'],
					'uid' => $id,
					'time' => date('Y-m-d H:i:s'),
					'like' => $input['like']
				));
			}
			else if (isset($input['question']) && $input['question'] != null) {

				$this->db->delete('like', array(
					'question' => $input['question'],
					'uid' => $id
				));

				$this->db->insert('like', array(
					'question' => $input['question'],
					'uid' => $id,
					'time' => date('Y-m-d H:i:s'),
					'like' => $input['like']
				));
			}
			else {

				echo json_encode(array(
					'success' => false,
					'message' => "Invalid request",
				));
				return;
			}
			echo json_encode(array(
				'success' => true,
				'message' => ""
			));
			return;
		}




		echo json_encode(array(
			'success' => false,
			'message' => "Invalid request",
		));
		return;


	}
	public function login(){
		if ($this->input->server('REQUEST_METHOD') === 'POST'){

			$input = json_decode($this->input->raw_input_stream, true);

			$username = $input['username'];
			$password = $input['password'];

			$user = $this->db->get_where('user', array('username' => $username));

			if ($this->db->error()['code'] != 0){
				echo json_encode(array(
					'success' => false,
					'message' => json_encode($this->db->error()),
				));
				return;
			}

			$user = $user->row_array();



			if ($user == null){
				echo json_encode(array(
					'success' => false,
					'message' => "Invalid username!",
				));
				return;
			}
			if (strcmp($password, $user['password']) != 0){
				echo json_encode(array(
					'success' => false,
					'message' => "Wrong password",
				));
				return;
			}

			$this->session->set_userdata('login', $user['id']);

			echo json_encode(array(
				'success' => true,
				'message' => "Logged in successfully",
				'id' => $user['id']
			));

			return;
		}
	}
}
