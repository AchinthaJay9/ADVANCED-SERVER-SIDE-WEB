<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Answer extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('answer_model');
		$this->load->library('session');
	}

	public function index($qid = null) {
		if (!$this->session->userdata('login')) {
			echo json_encode(array('success' => false, 'message' => 'Not logged in'));
			return;
		}

		$id = $this->session->userdata('login');

		if (!$qid) {
			echo json_encode(array('success' => false, 'message' => 'Invalid question id'));
			return;
		}

		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			$input = json_decode($this->input->raw_input_stream, true);
			$question = $input['question'];
			$tags = $input['tags'];

			$insert_id = $this->answer_model->add_answer($qid, $question, $id);

			if ($insert_id) {
				echo json_encode(array('success' => true, 'message' => 'Answer added successfully', 'id' => $insert_id));
			} else {
				echo json_encode(array('success' => false, 'message' => $this->db->error()['message']));
			}
			return;
		}

		if ($this->input->server('REQUEST_METHOD') === 'GET') {
			$answers = $this->answer_model->get_answers($qid);
			echo json_encode(array('success' => true, 'data' => $answers, 'id' => $qid));
			return;
		}

		echo json_encode(array('success' => false, 'message' => 'Invalid request'));
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
